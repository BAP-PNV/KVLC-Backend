<?php

namespace App\Services\Implements;

use App\Services\Interfaces\IRedisService;
use Illuminate\Support\Facades\Redis;

class RedisService implements IRedisService
{

    public function setRefreshTokenWithUserId(int $userId, string $token): void
    {
        Redis::set("Refresh:$userId", $token);
    }

    public function getRefreshTokenByUserId(int $userId): string|null
    {
        return Redis::get("Refresh:$userId");
    }
}
