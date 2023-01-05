<?php
namespace App\Services\Interfaces;


interface  IFriendService{
    public function addFriend($userWantAdd,$useBeAdded): mixed;
}
