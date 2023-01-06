<?php

namespace App\Http\Controllers;



use App\Services\Interfaces\IFriendService;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FriendController extends Controller
{
    public function __construct(
        private readonly IFriendService $friendService
    )
    {}


    public function findFriend(Request $request){
        $userId = $request->input('id');
        $search = $request->input('q');
        $findFriend = $this->friendService->findFriend($userId,$search);
        return$findFriend;

    }
    public function unFriend(Request $request){
        $userIdWant = $request->input('userIdWant');
        $userIdBe = $request ->input('userIdBe');
        $unFriend = $this->friendService->unFriend($userIdWant,$userIdBe);
        return $unFriend;
    }
    public function addFriend(Request $request)
    {
        $userWantAdd = $request->input("userWantAdd");
        $userBeAdded = $request->input('userBeAdded');

        if($this->friendService->addFriend($userWantAdd,$userBeAdded)){
            return $this->responseSuccess(
                "Add successfully!",
                Response::HTTP_CREATED
            );
        }
        return  $this->responseError("We are a friend",  $status = Response::HTTP_BAD_REQUEST);



    }


}
