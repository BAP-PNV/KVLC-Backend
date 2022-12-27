<?php
namespace App\Services\Interfaces;
interface IOTPService
{
    public function sendOTP(string $mailTo, int $otp);
    public function validateOTP(string $email, int $otp);
}
