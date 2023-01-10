<?php

namespace App\Services\Implements;
use App\Repositories\Interfaces\IRelationshipRepository;
use App\Repositories\Interfaces\IUserRepository;
use App\Services\Interfaces\IFriendService;
use Illuminate\Database\Eloquent\Collection;

class FriendService implements IFriendService
{
    public function __construct(
        private readonly IRelationshipRepository $userRelationship,
        private readonly IUserRepository $userRepository
    ){}
    public function findPeople(string $searchText, bool $toArray = false): Collection|array{
        $users = $this->userRepository->findUser($searchText);
        return $toArray ? $users->toArray() : $users;
    }
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
           return true;
       }
       return false;
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
