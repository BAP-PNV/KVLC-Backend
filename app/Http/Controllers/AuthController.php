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
        $response = $this->authService->login($email, $password);
        if ($response) {
            return $this->responseSuccessWithData(
                "login.successful",
                $response
            );
        }
        return $this->responseErrorWithDetails(
            "login.fails",
            ["error" => "Email or password wrong!"],
            Response::HTTP_UNAUTHORIZED
        );
    }
}
