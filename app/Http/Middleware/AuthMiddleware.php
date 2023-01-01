<?php

namespace App\Http\Middleware;

use App\Services\Interfaces\IAuthService;
use App\Services\Interfaces\IJWTService;
use App\Services\Interfaces\IRedisService;
use App\Services\Interfaces\TokenType;
use App\Traits\ApiResponse;
use App\Utils\RequestUtils;
use Closure;
use Firebase\JWT\ExpiredException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthMiddleware
{
    use ApiResponse;
    public function __construct(
        private readonly IJWTService   $jwtService,
        private readonly IRedisService $redisService,
        private readonly IAuthService $authService
    )
    {
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return Response|RedirectResponse|JsonResponse
     */
    public function handle(Request $request, Closure $next): Response|RedirectResponse|JsonResponse
    {
        $path = $request->path();
        if ($this->isLogin($path)) {
            $loginResult = $this->regenerateTokensBaseOnRFToken($request);
            if ($loginResult) return $loginResult;
            return $next($request);
        }
        // handle path /api/
        if ($this->checkAccessToken($request)) {
            return $next($request);
        }
        $response = $this->regenerateTokensBaseOnRFToken($request);
        if ($response) return $response;
        return $this->responseErrorWithDetails(
            "re-login.required",
            ["error" => "Token invalid! Please re-login!"]
        );
    }
    private function isLogin(string $path): bool {
        return str_contains($path, "auth/login");
    }
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @return JsonResponse|null
     */
    private function regenerateTokensBaseOnRFToken(Request $request): JsonResponse|null {
        $refreshToken = $request->cookie("refresh-token");
        if ($refreshToken ) {
            try {
                ["uid" => $userId]= $this->jwtService->verifyToken($refreshToken, TokenType::REFRESH_TOKEN);
                $storedRefreshToken = $this->redisService->getRefreshTokenByUserId($userId);
                if ($storedRefreshToken ==  null || $refreshToken != $storedRefreshToken) {
                    return null;
                }
                ["accessToken" => $newAccessToken, "refreshToken" => $newRefreshToken] = $this->authService->getAccessAndRefreshToken($userId);

                $response = $this->responseSuccessWithData(
                    "login.successful.viaRF",
                    ["accessToken" => $newAccessToken]
                );
                $refreshTokenCookie = cookie(
                    "refresh-token",
                    $newRefreshToken,
                    env("REFRESH_TOKEN_EXPIRED_TIME")/(60*1000),
                    "/api/auth/",
                    null,
                    true
                );
                return $response->cookie($refreshTokenCookie);
            } catch (\UnexpectedValueException $e) {}
        }
        return null;
    }
    private function checkAccessToken(Request $request): bool {
        $accessToken = RequestUtils::getAccessTokenFromRequest($request);
        if ($accessToken) {
            try {
                $this->jwtService->verifyToken($accessToken, TokenType::ACCESS_TOKEN);
                return true;
            } catch (\UnexpectedValueException $e) {

            }
        }
        return false;
    }
}
