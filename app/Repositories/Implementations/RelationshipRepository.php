<?php

namespace App\Repositories\Implementations;

use App\Models\FriendRelationship;
use App\Repositories\Interfaces\IRelationshipRepository;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

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
        $this->model::where('id', $relaId)->delete();
    }

    function getAllFriends(int $userId): Collection
    {
        $arrayRelaId = $this->model::where("user_id", $userId)->get(['id'])->toArray();
        return $this->model::join("users as u", "u.id", "=", "friend_relationships.user_id")
                            ->whereIn("friend_relationships.id", $arrayRelaId)
                            ->where('user_id', '!=', $userId)
                            ->get(["u.id", "u.full_name", "is_blocked"]);
    }

    function isFriend(int $userId1, int $userId2): bool
    {
        $arrayRelaId = $this->model::where('user_id', $userId1)->get(['id']);

        return
            $this->model::whereIn('id', $arrayRelaId)
                ->where('user_id', $userId2)
                ->exists();
    }
    public function findFriend(int $userId,string $searchText): mixed
    {
        $arrayRelaId = array_values($this->model::where("user_id", $userId)->get(['id'])->toArray());
        return $this->model::join("users as u", "u.id", "=" , "friend_relationships.user_id")
            ->whereIn("friend_relationships.id", $arrayRelaId)
            ->where('u.id', '!=', $userId)
            ->whereRaw("(u.full_name LIKE '%$searchText%' or u.email LIKE '%$searchText%')")
            ->get(['user_id','full_name','email']);
    }
    public function findIdRelationship(int $userIdFind, int $userIdBeFind): ?int
    {
        $arrayRelaId = $this->model::where('user_id', $userIdFind)->get(['id'])->toArray();
        $rel = $this->model::whereIn('id', $arrayRelaId)->where('user_id', $userIdBeFind)->first(['id']);
        return $rel ? $rel->id : null;
    }
}
