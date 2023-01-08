<?php

namespace App\Repositories\Implementations;

use App\Models\Conversation;
use App\Repositories\Interfaces\IConversationRepository;
use Illuminate\Database\Eloquent\Collection;

class ConversationRepository extends BaseRepository implements IConversationRepository
{

    public function getModel(): string
    {
        return Conversation::class;
    }

    public function getMembersByConversationId(int $id): Collection
    {
        return $this->findById($id)->membersOfConversation;
    }
}
