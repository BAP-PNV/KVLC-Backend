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
    /**
     * @OA\Get( path="/api/friend/people",tags={"Friend"},summary="search friend user added",operationId="findPeople",
     *       @OA\Parameter(
     *         name="uid",
     *         in="query",
     *         description="Status values that needed to be considered for filter",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="q",
     *         in="query",
     *         description="Status values that needed to be considered for filter",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="OK",
     *      ),
     * security={ {"passport":{}}}
     *
     * )
     */


    public function findPeople(Request $request) {
        $userId = $request->input("uid");
        $textSearch = $request->input("q");

        $allUsers = $this->friendService->findAllUser($userId,$textSearch);

        return $this->responseSuccessWithData("Find Successfully",$allUsers->toArray());

    }

    public function findFriend(Request $request){
        $userId = $request->input('id');
        $search = $request->input('q');
        $allFriends = $this->friendService->findFriend($userId,$search);
        return $this->responseSuccessWithData("Find Successfully",$allFriends->toArray());
    }
    /**
     * @OA\Post (path="/api/friend/un-friend", tags={"Friend"},operationId="unFriend",summary="un friend ",
     *  @OA\RequestBody(
     *       @OA\MediaType(
     *          mediaType="multipart/form-data",
     *          @OA\Schema(required={"userIdWant","userIdBe"},
     *          @OA\Property(property="userIdWant", type="integer"),
     *          @OA\Property(property="userIdBe", type="integer"),
     *     )
     *       )
     *   ),
     * @OA\Response (response="200", description="Success"),
     * @OA\Response (response="404", description="Not Found"),
     * security={ {"passport":{}}}
     * )
     */
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
    /**
     * @OA\Post(path="/api/friend/add", tags={"Friend"},operationId="addFriend",summary="add friend",
     *  @OA\RequestBody(
     *       @OA\MediaType(
     *          mediaType="multipart/form-data",
     *          @OA\Schema(required={"userWantAdd","userBeAdded"},
     *          @OA\Property(property="userWantAdd", type="integer"),
     *          @OA\Property(property="userBeAdded", type="integer"),
     *     )
     *       )
     *   ),
     * @OA\Response (response="200", description="Success"),
     * @OA\Response (response="404", description="Not Found"),
     * security={ {"passport":{}}}
     * )
     */
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
