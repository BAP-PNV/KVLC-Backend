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

    public function findPeople(Request $request) {
        $userId = $request->input("uid");
        $textSearch = $request->input("textSearch");

        $allUsers = $this->friendService->findAllUser($userId,$textSearch);

        return $this->responseSuccessWithData("Find Successfully",$allUsers->toArray());

    }
    public function findFriend(Request $request){
        $userId = $request->input('id');
        $search = $request->input('q');
        return $this->friendService->findFriend($userId,$search);
    }
    public function unFriend(Request $request){
        $userIdWant = $request->input('userIdWant');
        $userIdBe = $request ->input('userIdBe');
        if($this->friendService->unFriend($userIdWant,$userIdBe)){
            return $this->responseSuccess(
                "unFriend successfully!",
                Response::HTTP_OK
            );
        };
        return $this->responseError("We are not friend",  $status = Response::HTTP_BAD_REQUEST);
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
