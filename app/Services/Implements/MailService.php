<?php

namespace App\Services\Implements;

use App\Mail\OTPMail;
use App\Mail\ResetPassWordMail;
use App\Mail\WelComeMail;
use App\Models\User;
use App\Services\Interfaces\MailType;
use Illuminate\Support\Facades\Mail;


class MailService implements \App\Services\Interfaces\IMailService
{
    public function sendMail(MailType $mailType, array $info = []): void
    {

        switch ($mailType) {
            default: {return;}
            case MailType::OTP_MAIL: {
                $otp = rand(123456, 999999); //random
                $user = $info["user"];
                $otpMail = new OTPMail($user, $otp);
                Mail::to($user->email)->send($otpMail);
                return;
            }
            case MailType::WELCOME_MAIL:{
                $email = $info["email"];
                $passWord=$info['passWord'];
                $wellMail=new WelComeMail($email,$passWord);
                Mail::to($email)->send($wellMail);
                return;
            }
            case MailType::CHANGE_PASSWORD:{
                $email = $info["email"];
                $resetPass=new ResetPassWordMail($email);
                Mail::to($email)->send($resetPass);
            }
        }
    }
}
