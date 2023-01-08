<?php

namespace App\Services\Implements;

use App\Repositories\Interfaces\IConversationRepository;
use App\Repositories\Interfaces\IMemberRepository;
use App\Repositories\Interfaces\IRelationshipRepository;
use App\Repositories\Interfaces\IUserRepository;
use App\Services\Interfaces\ConversationCreationStatus;
use App\Services\Interfaces\IConversationService;
use App\Services\Interfaces\IFriendService;

class ConversationService implements IConversationService
{
    public function __construct(
        private readonly IRelationshipRepository $relationshipRepository,
        private readonly IConversationRepository $conversationRepository,
        private readonly IMemberRepository $memberRepository,
        private readonly IUserRepository $userRepository
    )
    {}

    public function addNewConversation(int $creatorId, int $memberId): ConversationCreationStatus
    {
        if ($this->relationshipRepository->isFriend($creatorId, $memberId)) {
            if (!$this->memberRepository->hasConversation($creatorId, $memberId)) {
                $newCon = $this->conversationRepository->create();
                $newConId = $newCon->id;
                $this->memberRepository->create(["con_id" => $newConId, "user_id" => $creatorId, "display_name" => $this->userRepository->findById($creatorId)->full_name]);
                $this->memberRepository->create(["con_id" => $newConId, "user_id" => $memberId, "display_name" => $this->userRepository->findById($memberId)->full_name]);

                return ConversationCreationStatus::SUCCESSFUL;
            };
            return ConversationCreationStatus::EXISTED;
        }
        return ConversationCreationStatus::FAILED;
    }

    public function leaveConversation(int $userId, int $conId): bool
    {
        if ($this->memberRepository->isMemberInConversation($userId, $conId)) {
            $this->memberRepository->deleteMemberFromConversation($userId, $conId);
            return true;
        }
        return false;
    }
}
