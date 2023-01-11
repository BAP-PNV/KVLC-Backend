<?php

namespace App\Http\Controllers;

use App\Services\Interfaces\IFriendService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FriendController extends Controller
{
    public function __construct(
        private readonly IFriendService $friendService
    )
    {}

    public function getFriends(Request $request): JsonResponse {
        $userId = $request->input("uid");
        $friends = $this->friendService->getFriends($userId, true);
        return $this->responseSuccessWithData(
            "friend.get.successful",
            $friends
        );
    }
    public function findPeople(Request $request): JsonResponse
    {
        $userId = $request->input("uid");
        $textSearch = $request->input("q");
        $allUsers = $this->friendService->findAllUser($userId, $textSearch, true);
        return $this->responseSuccessWithData(
            "Find Successfully",
            $allUsers
        );

    }
    public function findFriend(Request $request): JsonResponse
    {
        $userId = $request->input('id');
        $search = $request->input('q');
        $friends = $this->friendService->findFriend($userId,$search);
        return $this->responseSuccessWithData(
            "friend.find.successful",
            $friends
        );
    }
    public function unFriend(Request $request): JsonResponse
    {
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
    public function addFriend(Request $request): JsonResponse
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
