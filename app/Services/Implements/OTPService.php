<?php

namespace App\Services\Implements;

use App\Services\Interfaces\IMailService;
use App\Services\Interfaces\IOTPService;
use App\Services\Interfaces\MailType;

class OTPService implements IOTPService
{
    private IMailService $mailService;

    public function __construct(IMailService $mailService)
    {
        $this->mailService = $mailService;
    }

    public function sendOTP(string $mailTo, int $otp)
    {
        $this->mailService->sendMail(MailType::OTP_MAIL, );
    }

    public function validateOTP(string $email, int $otp)
    {
        // TODO: Implement validateOTP() method.
    }
}
