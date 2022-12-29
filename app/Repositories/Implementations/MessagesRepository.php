<?php

namespace App\Repositories\Implementations;

use App\Models\Message;
use App\Repositories\Interfaces\IMessagesRepository;
use Illuminate\Database\Eloquent\Collection;

class MessagesRepository extends BaseRepository implements IMessagesRepository
{

    public function getModel(): string
    {
        return Message::class;
    }

    public function all($toArray = false): Collection|array|null
    {
        return null;
    }

    public function findMessagesByContent(int $conversationId, string $content, bool $toArray = false): Collection|array|null
    {
        $messages =
            $this->model
                ->where("con_id", $conversationId)
                ->where("content","LIKE", "%$content%")
                ->orderBy("created_at", "asc")
                ->get();
        return ($messages ? null : $toArray) ? $messages->toArray() : $messages;
    }

    public function nLatestMessagesOfConversation(int $conversationId, int $offset = 0, int $limit = 10, bool $toArray = false): Collection|array|null
    {
        $messages =
            $this->model
                ->where("con_id", $conversationId)
                ->skip($offset)
                ->take($limit)
                ->orderBy("created_at", "asc")
                ->get();
        return ($messages ? null : $toArray) ? $messages->toArray() : $messages;
    }
}
