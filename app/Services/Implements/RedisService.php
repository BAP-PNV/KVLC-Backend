<?php

namespace App\Services\Implements;

use App\Services\Interfaces\IRedisService;
use Illuminate\Support\Facades\Redis;
use function Termwind\renderUsing;

class RedisService implements IRedisService
{

    public function setRefreshTokenWithUserId(int $userId, string $token): void
    {
        Redis::set("Refresh:$userId", $token);
        Redis::expire("Refresh:$userId", 10);
    }

    public function getRefreshTokenByUserId(int $userId): string|null
    {
        return Redis::get("Refresh:$userId");
    }
    public function setOtp($email,$otp):  void
    {
        Redis::set("Otp:$email",$otp);
    }
    public function getOtp($email): int
    {
        return Redis::get("Otp:$email");
    }

    public  function  setInfoRegis($dataRegis,$otp): void
    {
        $user = json_encode($dataRegis);
       Redis::set("InforRegis:$otp",$user);

    }
    public function  getInfoRegis($otp): mixed
    {
       return json_decode(Redis::get("InforRegis:$otp"));
    }
    public  function deleteOtp($email): mixed
    {
        Redis::del("Otp:$email");
        return "ok";
    }
    public function  deleteInfor($otp): mixed
    {
        Redis::del("InforRegis:$otp");
        return "ok";
    }
}
