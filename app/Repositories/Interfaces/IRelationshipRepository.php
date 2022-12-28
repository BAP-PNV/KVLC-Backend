<?php
namespace App\Repositories\Interfaces;
interface IRelationshipRepository extends IRepository {
    public function blockFriend($user_isBlocked,$relaID): mixed;
    public function addFriend($userWantAdd,$userBeAdded): mixed;
    public function unFriend($relaID):mixed;
    public  function findFriends($userId):mixed;
    public  function isfriend($userId1,$userId2):mixed;
}
