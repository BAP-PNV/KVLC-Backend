<?php
namespace App\Services\Interfaces;

use App\Models\Message;
use Illuminate\Database\Eloquent\Collection;

interface IMessagesService {
    public function save(int $userId, int $conversationId, string $content): void;
    public function edit(int $userId, int $conId, int $mesId, string $content): bool;
    public function delete(int $userId, int $conId, int $mesId): bool;
    public function getMessageFromConversation(int $userId, int $conId, array $filter = ["limit" => 10, "offset" => 0], bool $toArray = false): Collection|array|null;
    public function getOneMessageInConversation(int $conId, int $messId): ?Message;
    public function search(int $conId, array $filter, $toArray = false): Collection|array|null;
}
