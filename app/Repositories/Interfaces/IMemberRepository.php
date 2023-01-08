<?php
namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface IMemberRepository extends IRepository {
    public function getDisplayName($conversationId, $memberId): string|null;
    public function isMemberInConversation($memberId, $conversationId): bool;
    public function hasConversation(int $userId1, int $userId2): bool;
    public function deleteMemberFromConversation(int $memberId, int $conId): void;
}
