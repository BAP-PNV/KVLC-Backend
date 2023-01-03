<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Services\Interfaces\IAccountService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RegisterController extends Controller
{
    public function __construct(private readonly IAccountService $accountService) {}
    public function register(RegisterRequest $request){
        $newUser = $request->validated();

        $accData = $this->accountService->register($newUser);

        return $this->responseSuccessWithData(
            "Create a new account successfully!",
            $accData,
            Response::HTTP_CREATED
        );
    }
}
