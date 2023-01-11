<?php

namespace App\Services\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface IConversationService
{
    public function addNewConversation(int $creatorId, int $memberId): ConversationCreationStatus;
    public function leaveConversation(int $userId, int $conId): bool;
    public function getConversationsByUser(int $userId, bool $toArray = false): Collection|array;
}
