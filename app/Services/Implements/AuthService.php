<?php

namespace App\Services\Implements;

use App\Repositories\Interfaces\IUserRepository;
use App\Services\Interfaces\IAuthService;
use App\Services\Interfaces\IJWTService;
use App\Services\Interfaces\TokenType;
use Illuminate\Support\Facades\Hash;

class AuthService implements IAuthService
{
    public function __construct(
        private readonly IJWTService     $jwtService,
        private readonly IUserRepository $userRepository
    )
    {}

    public function login(string $email, string $password): array
    {
        $user = $this->userRepository->findOneBy(["email" => $email]);
        if ($user) {
            if (Hash::check($password, $user->password)) {
                $accessToken = $this->jwtService->generateAccessToken($user->id);
                $refreshToken = $this->jwtService->generateRefreshToken($user->id);
                return compact("accessToken", "refreshToken");
            }
        }
        return [];
    }

    public function refreshToken(string $token): array
    {
        return $this->jwtService->verifyToken($token, TokenType::REFRESH_TOKEN);
    }
}
