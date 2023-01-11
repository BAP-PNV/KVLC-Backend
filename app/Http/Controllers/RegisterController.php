<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Services\Interfaces\IAccountService;
use App\Services\Interfaces\IOTPService;
use App\Services\Interfaces\IRedisService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RegisterController extends Controller
{
    public function __construct(
        private readonly IAccountService $accountService,
        private  readonly  IOTPService $otpService,
        private readonly IRedisService $redisService
    ) {}
    /**
     * @OA\Post(
     ** path="api/account/register", tags={"Author"}, summary="Register", operationId="register",
     *  @OA\Parameter(name="fullName",in="query",required=true, @OA\Schema( type="string" )),
     *  @OA\Parameter(name="email", in="query", required=true, @OA\Schema(type="string")),
     *   @OA\Parameter( name="password", in="query", required=true, @OA\Schema(type="string")),
     *   @OA\Response( response=201, description="Success",@OA\MediaType(mediaType="application/json",)),
     *   @OA\Response( response=401, description="Unauthenticated"
     *   ),
     *   @OA\Response( response=400, description="Bad Request"
     *   ),
     *   @OA\Response( response=404, description="not found"
     *   ),
     *    @OA\Response( response=403, description="Forbidden"
     *      )
     *)
     **/
    public function register(RegisterRequest $request){
        $userData = $request->validated();
        $otp = rand(100000,999999);
        $user = new User;
        $user['email'] = $userData['email'];

        $this->otpService->sendOTP($user, $otp);

        $this->redisService->setOtp($user['email'],$otp);
        $this->redisService->setInfoRegis($userData,$otp);

    }
    public function confirmRegistration(Request $request) {

            $opt = $request->input('otp');
            $email = $request->input('email');

            $optConfirm = $this->redisService->getOtp($email);

            if($optConfirm == null){
                return $this->responseError(
                    "Email not sign up !",
                    Response::HTTP_BAD_REQUEST,
                );
            }
            elseif ($opt == $optConfirm){
                        $user =  $this->redisService->getInfoRegis($opt);

                        $accData = $this->accountService->register((array)$user);

                        $this->redisService->deleteOtp($user->email);
                        $this->redisService->deleteInfor($opt);


                        return $this->responseSuccessWithData(
                        "Create a new account successfully!",
                        $accData,
                        Response::HTTP_CREATED
                        );
            }
            else{
                return $this->responseError(
                    "OTP Invalid!",
                     Response::HTTP_BAD_REQUEST
                );
            }
    }
}
