<?php

namespace App\Services\Interfaces;

use Illuminate\Support\Facades\Redis;

interface IRedisService
{
    public function setRefreshTokenWithUserId(int $userId, string $token): void;
    public function getRefreshTokenByUserId(int $userId): string|null;

    public function setOtp($email,$otp):void;
    public function getOtp($email):int|null;

    public function setInfoRegis($dataRegis,$otp):void;

    public function getInfoRegis($otp):mixed;

    public  function deleteOtp($email): mixed;
    public function  deleteInfor($otp): mixed;
}
