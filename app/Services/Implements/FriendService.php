<?php

namespace App\Services\Implements;
use App\Repositories\Interfaces\IRelationshipRepository;
use App\Services\Interfaces\IFriendService;

class FriendService implements IFriendService
{
    public function __construct(
        private readonly IRelationshipRepository $userRelationship
    ){}
    public function findFriend(int $userId,string $searText): mixed
    {

        $friend = $this->userRelationship->findFriend($userId,$searText);
        if ($friend){
            return $friend;
        }
        return [];


    }
   public function unFriend(int $userIdWant, int $userIdBe): mixed
   {
       $relaId = $this->userRelationship->findIdRelationship($userIdWant,$userIdBe);
       if($relaId){
           $this->userRelationship->unFriend($relaId);
           return ["message"=>"unfriend successfully"];
       }
       return ["message"=>"unfriend error"];
   }


    public function addFriend($userWantAdd, $useBeAdded): mixed
    {
        if(!$this->userRelationship->isFriend($userWantAdd,$useBeAdded)){
            $this->userRelationship->addFriend($userWantAdd,$useBeAdded);
            return true;
        }
        return false;

    }
}
