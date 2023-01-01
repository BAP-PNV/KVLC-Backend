<?php

namespace App\Services\Implements;

use App\Repositories\Interfaces\IUserRepository;
use App\Services\Interfaces\IAuthService;
use App\Services\Interfaces\IJWTService;
use App\Services\Interfaces\IRedisService;
use App\Services\Interfaces\TokenType;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;

class AuthService implements IAuthService
{
    public function __construct(
        private readonly IJWTService $jwtService,
        private readonly IUserRepository $userRepository,
        private readonly IRedisService $redisService
    )
    {}

    public function login(string $email, string $password): array
    {
        $user = $this->userRepository->findOneBy(["email" => $email]);
        if ($user) {
            if (Hash::check($password, $user->password)) {
                return $this->getAccessAndRefreshToken($user->id);
            }
        }
        return [];
    }

    public function refreshToken(string $token): array
    {
        return $this->jwtService->verifyToken($token, TokenType::REFRESH_TOKEN);
    }

    public function getAccessAndRefreshToken(int $userId): array
    {
        $accessToken = $this->jwtService->generateAccessToken($userId);
        $refreshToken = $this->jwtService->generateRefreshToken($userId);

        //save refresh token into Redis
        $this->redisService->setRefreshTokenWithUserId($userId, $refreshToken);

        return compact("accessToken", "refreshToken");
    }
}
