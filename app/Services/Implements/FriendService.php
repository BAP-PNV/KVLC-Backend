<?php
namespace App\Services\Implements;
use App\Repositories\Interfaces\IRelationshipRepository;
use App\Repositories\Interfaces\IUserRepository;
use App\Services\Interfaces\IFriendService;
use Illuminate\Database\Eloquent\Collection;
use function React\Promise\all;

class FriendService implements IFriendService
{
    public function __construct(
        private readonly IRelationshipRepository $relationshipRepository,
        private readonly IUserRepository $userRepository
    ){}

    public function getFriends(int $userId, bool $toArray = false): Collection|array
    {
        $friends = $this->relationshipRepository->getAllFriends($userId);
        return $toArray ? $friends->toArray() : $friends;
    }

    public function findPeople(string $searchText, bool $toArray = false): Collection|array{
        $users = $this->userRepository->findUser($searchText);
        return $toArray ? $users->toArray() : $users;
    }
    public function findFriend(int $userId,string $searText): mixed
    {
        return $this->relationshipRepository->findFriend($userId,$searText);
    }
   public function unFriend(int $userIdWant, int $userIdBe): bool
   {
       $relaId = $this->relationshipRepository->findIdRelationship($userIdWant,$userIdBe);
       if($relaId){
           $this->relationshipRepository->unFriend($relaId);
           return true;
       }
       return false;
   }


    public function addFriend($userWantAdd, $useBeAdded): mixed
    {
        if(!$this->relationshipRepository->isFriend($userWantAdd,$useBeAdded)){
            $this->relationshipRepository->addFriend($userWantAdd,$useBeAdded);
            return true;
        }
        return false;

    }
    public function findAllUser($userId, $textSearch, $toArray = false): mixed
    {
        $allUsers = $this->userRepository->findUser($textSearch);
        foreach ($allUsers as $user){
            $user->isFriend = $this->relationshipRepository->isFriend($userId,$user->id);
        }
        return $toArray ? $allUsers->toArray() : $allUsers;
    }
}
