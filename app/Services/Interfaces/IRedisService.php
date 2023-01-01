<?php

namespace App\Services\Interfaces;

interface IRedisService
{
    public function setRefreshTokenWithUserId(int $userId, string $token): void;
    public function getRefreshTokenByUserId(int $userId): string|null;
}
