<?php
namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface IMemberRepository extends IRepository {
    public function getMembersByConversationId($id): Collection;
    public function getDisplayName($conversationId, $memberId): string|null;
    public function isMemberInConversation($memberId, $conversationId): bool;
}
