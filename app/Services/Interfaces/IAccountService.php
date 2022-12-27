<?php
namespace App\Services\Interfaces;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;

interface IAccountService {
    public function register(RegisterRequest $request);
    public function forgotPassword();
    public function validateForgotPasswordToken(Request $request);
    public function updateInformation();
}
