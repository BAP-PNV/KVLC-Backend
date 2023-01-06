<?php
namespace App\Repositories\Interfaces;
use Illuminate\Database\Eloquent\Collection;

interface IRelationshipRepository extends IRepository {
    public function blockFriend(int $user_isBlocked,int $relaID): void;
    public function addFriend(int $userWantAdd,int $userBeAdded): void;
    public function unFriend(int $relaID): void;
    public  function getAllFriends(int $userId, bool $toArray): Collection|array|null;
    public  function isFriend(int $userId1, int $userId2): bool;
    public function findFriend(int$userId,string $searchText):mixed;
    public function findIdRelationship (int $userIdFind, int $userIdBeFind): ?int;

}
