<?php
namespace App\Services\Interfaces;
use App\Http\Requests\AuthRequest;

interface IAuthService {
    public function login(AuthRequest $request): mixed;
    public function refreshToken(): mixed;
}
