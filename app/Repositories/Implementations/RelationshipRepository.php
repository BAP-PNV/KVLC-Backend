<?php

namespace App\Repositories\Implementations;

use App\Models\FriendRelationship;
use App\Repositories\Interfaces\IRelationshipRepository;
use Exception;

class RelationshipRepository extends BaseRepository implements IRelationshipRepository
{

    public function getModel(): string
    {
        return FriendRelationship::class;
    }

    function blockFriend($relaID, $userIdIsBlocked): mixed
    {
        try {
            $this->model::where('id', $relaID)
                ->where("user_id", $userIdIsBlocked)
                ->update(["is_blocked" => 1]);
            return true;
        } catch (Exception $e) {
            return false;
        }

    }

    function addFriend($userIdWantAdd, $userIdBeAdded): mixed
    {
        try {
            $randId = rand(0, 1000000);

            $this->model::create(array("id" => $randId, "user_id" => $userIdWantAdd));
            $this->model::create(array("id" => $randId, "user_id" => $userIdBeAdded));
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    function unFriend($relaId): mixed
    {
        try {
            $this->model::where('id', $relaId)->get()->delete();
            return true;

        } catch (Exception $e) {
            throw $e;
        }
    }

    function findFriends($userId): mixed
    {
        $arrayRelaId = $this->model::where("user_id", $userId)->get(['id']);
        $arrayFriends = [];
        foreach ($arrayRelaId as $value) {
            $friend =
                $this->model::where("id", $value->id)
                    ->where('user_id', '!=', $userId)
                    ->first();
            $arrayFriends[] = $friend;
        }
        return $arrayFriends;
    }

    function isfriend($userId1, $userId2): mixed
    {
        $arrayRelaId = $this->model::where('user_id', $userId1)->get(['id']);

        $isFriend =
            $this->model::whereIn('id', $arrayRelaId)
                        ->where('user_id', $userId2)
                        ->exists();
        if ($isFriend) {
            return ["status" => true];
        }
        return ["status" => false];
    }
}
