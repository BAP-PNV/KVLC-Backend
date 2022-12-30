<?php

namespace App\Repositories\Implementations;

use App\Models\FriendRelationship;
use App\Repositories\Interfaces\IRelationshipRepository;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class RelationshipRepository extends BaseRepository implements IRelationshipRepository
{

    public function getModel(): string
    {
        return FriendRelationship::class;
    }

    function blockFriend(int $relaID, int $userIdIsBlocked): void
    {
        $this->model::where('id', $relaID)
            ->where("user_id", $userIdIsBlocked)
            ->update(["is_blocked" => 1]);
    }

    function addFriend(int $userIdWantAdd,int $userIdBeAdded): void
    {
        $randId = rand(0, 1000000);
        $this->model::create(array("id" => $randId, "user_id" => $userIdWantAdd));
        $this->model::create(array("id" => $randId, "user_id" => $userIdBeAdded));
    }

    function unFriend(int $relaId): void
    {
        $this->model::where('id', $relaId)->get()->delete();
    }

    function findFriends(int $userId, bool $toArray = false): Collection|array|null
    {
        $arrayRelaId = array_values($this->model::where("user_id", $userId)->get(['id'])->toArray());
        return $this->model::whereIn("id", $arrayRelaId)
            ->where('user_id', '!=', $userId)
            ->get();
    }

    function isFriend(int $userId1, int $userId2): bool
    {
        $arrayRelaId = $this->model::where('user_id', $userId1)->get(['id']);

        return
            $this->model::whereIn('id', $arrayRelaId)
                ->where('user_id', $userId2)
                ->exists();
    }
}
