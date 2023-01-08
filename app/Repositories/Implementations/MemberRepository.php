<?php

namespace App\Repositories\Implementations;

use App\Models\MembersOfConversation;
use App\Repositories\Interfaces\IMemberRepository;
use Illuminate\Database\Eloquent\Collection;

class MemberRepository extends BaseRepository implements IMemberRepository
{

    public function getModel(): string
    {
        return MembersOfConversation::class;
    }

    public function getMembersByConversationId($id): Collection
    {
        return $this->model::where("con_id", $id)->get();
    }

    public function getDisplayName($conversationId, $memberId): ?string
    {
        $user = $this
                ->model
                ->where("con_id", $conversationId)
                ->where("user_id", $memberId)
                ->first();
        return is_null($user) ? null : $user->display_name;
    }

    public function isMemberInConversation($memberId, $conversationId): bool
    {
        $user = $this
                ->model
                ->where("user_id", $memberId)
                ->where("con_id", $conversationId)
                ->first();
        return !!$user;
    }
    public function hasConversation(int $userId1, int $userId2): bool
    {
        $conArr = $this->model::where("user_id", $userId1)->get(["con_id"])->toArray();
        return $this->model::where("user_id", $userId2)
            ->whereIn("con_id", $conArr)
            ->exists();
    }

    public function delete($id): mixed
    {
       return $this->model->where("con_id", $id)->delete();
    }

    public function deleteMemberFromConversation(int $memberId, int $conId): void
    {
        $this->model::where("con_id", $conId)
                    ->where("user_id", $memberId)
                    ->delete();
    }
}
