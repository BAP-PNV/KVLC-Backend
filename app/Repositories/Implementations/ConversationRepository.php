<?php
namespace App\Repositories\Implementations;
use App\Models\Conversation;
use App\Repositories\Implementations\BaseRepository;
use App\Repositories\Interfaces\IConversationRepository;
use Exception;
class ConversationRepository extends BaseRepository implements IConversationRepository {

    public function getModel():string{
        return Conversation::class;
    }
}
