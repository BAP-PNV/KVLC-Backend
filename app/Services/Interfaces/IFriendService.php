<?php

namespace App\Services\Interfaces;

interface IFriendService
{
    public function addFriend($userWantAdd,$useBeAdded): mixed;
    public function findFriend(int $userId,string $searText):mixed;
    public function unFriend(int $userIdWant, int $userIdBe):mixed;
