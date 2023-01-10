<?php

namespace App\Services\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface IFriendService
{
    public function findPeople(string $searchText): Collection|array;
    public function addFriend($userWantAdd, $useBeAdded): mixed;

    public function findFriend(int $userId, string $searText): mixed;

    public function unFriend(int $userIdWant, int $userIdBe): mixed;
}
