<?php

namespace App\Services\Interfaces;

interface IConversationService
{
    public function addNewConversation(int $creatorId, int $memberId): ConversationCreationStatus;
    public function leaveConversation(int $userId, int $conId): bool;
}
