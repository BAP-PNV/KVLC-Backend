<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface IMessagesRepository extends IRepository
{
    public function findMessagesByContent(int $conversationId, string $content): Collection|array|null;
    public function nLatestMessagesOfConversation(int $conversationId, int $start = 0, int $end = 10): Collection|array|null;

}
