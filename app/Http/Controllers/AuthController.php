<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Services\Interfaces\IAuthService;
use App\Utils\CookieGenerator;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function __construct(private readonly IAuthService $authService) {}
    public function login(AuthRequest $request): JsonResponse
    {
        $email = $request->input("email");
        $password = $request->input("password");
        $loginData = $this->authService->login($email, $password);
        if ($loginData) {
            ["accessToken" => $accessToken, "refreshToken" => $refreshToken] = $loginData;
            $response = $this->responseSuccessWithData(
                "login.successful",
                compact("accessToken")
            );
            $refreshTokenCookie = CookieGenerator::generateRefreshTokenCookie($refreshToken);
            return $response->cookie($refreshTokenCookie);
        }
        return $this->responseErrorWithDetails(
            "login.failed",
            ["error" => "Email or password wrong!"],
            Response::HTTP_UNAUTHORIZED
        );
    }
}
