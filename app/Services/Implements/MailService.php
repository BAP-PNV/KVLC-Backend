<?php

namespace App\Services\Implements;

use App\Mail\OTPMail;
use App\Mail\WellComeMail;
use App\Models\User;
use App\Services\Interfaces\MailType;
use Illuminate\Support\Facades\Mail;


class MailService implements \App\Services\Interfaces\IMailService
{
    public function sendMail(MailType $mailType, User $user)
    {

        switch ($mailType) {
            default: {return;}
            case MailType::OTP_MAIL: {
                $otp = rand(123456, 999999); //random
                $otpMail = new OTPMail($user, $otp);
                Mail::to($user->email)->send($otpMail);
                dd('thanh cong');
                return;
            }
            case MailType::WELCOME_MAIL:{
                 $wellMail=new WellComeMail($user);
                 Mail::to($user->email)->send($wellMail);
                 dd('successfully');
            }
        }
    }
}
