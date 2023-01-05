<?php
namespace App\Services\Implements;

use App\Repositories\Interfaces\IRelationshipRepository;
use App\Services\Interfaces\IFriendService;

class FriendService implements IFriendService{
    public function __construct(
        private readonly IRelationshipRepository $relationshipRepository
    )
    {}
    public function addFriend($userWantAdd, $useBeAdded): mixed
    {
        if(!$this->relationshipRepository->isFriend($userWantAdd,$useBeAdded)){
            $this->relationshipRepository->addFriend($userWantAdd,$useBeAdded);
            return true;
        }
        return false;

    }
}
