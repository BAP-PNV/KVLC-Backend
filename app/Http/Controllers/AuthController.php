<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Services\Interfaces\IAuthService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function __construct(private readonly IAuthService $authService) {}
    public function login(AuthRequest $request): JsonResponse
    {
        $email = $request->input("email");
        $password = $request->input("password");
        $responseData = $this->authService->login($email, $password);
        if ($responseData) {
            $accessToken = $responseData["accessToken"];
            $response = $this->responseSuccessWithData(
                "login.successful",
                compact("accessToken")
            );
            $refreshTokenCookie = cookie(
                "refresh-token",
                $responseData["refreshToken"],
                env("REFRESH_TOKEN_EXPIRED_TIME")/(60*1000),
                "/api/auth/",
                null,
                true
            );
            $response->cookie($refreshTokenCookie);
            return $response;
        }
        return $this->responseErrorWithDetails(
            "login.failed",
            ["error" => "Email or password wrong!"],
            Response::HTTP_UNAUTHORIZED
        );
    }
}
