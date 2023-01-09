<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface IMessagesRepository extends IRepository
{
    public function findMessagesByContent(int $conversationId, string $content): Collection|array|null;
    public function getMessagesBy(int $conversationId, array $filter = ["offset" => 0, "limit" => 10], bool $toArray = false): Collection|array|null;

}
