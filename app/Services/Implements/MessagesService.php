<?php

namespace App\Services\Implements;

use App\Models\Message;
use App\Repositories\Interfaces\IMemberRepository;
use App\Repositories\Interfaces\IMessagesRepository;
use App\Services\Interfaces\IMessagesService;
use Illuminate\Database\Eloquent\Collection;

class MessagesService implements IMessagesService
{
    public function __construct(
        private readonly IMessagesRepository $messagesRepository,
        private readonly IMemberRepository $memberRepository
    )
    {}

    public function save(int $userId, int $conId, string $content): void {
        if ($this->memberRepository->isMemberInConversation($userId, $conId)) {
            $this->messagesRepository->create(["con_id" => $conId, "user_id" => $userId, "content" => $content]);
        }
    }
    public function edit(int $userId, int $conId, int $mesId, string $content): bool
    {
        $message = $this->getOneMessageInConversation($mesId, $conId);
        if ($message&&$this->isMessageOfUser($message, $userId)) {
            $message->content = $content;
            return $message->save();
        }
        return false;
    }

    public function delete(int $userId, int $conId, int $mesId): bool
    {
        $message = $this->getOneMessageInConversation($mesId, $conId);
        if ($message&&$this->isMessageOfUser($message, $userId)) {
            return $message->delete();
        }
        return false;
    }

    public function getMessageFromConversation(int $userId, int $conId, array $filter = ["limit" => 10, "offset" => 0], bool $toArray = false): Collection|array|null
    {
        if ($this->memberRepository->isMemberInConversation($userId, $conId)) {
            $messages = $this->messagesRepository->getMessagesBy($conId, $filter, $toArray);
            return $toArray ? $messages->toArray() : $messages;
        }
        return null;
    }

    public function getOneMessageInConversation(int $messId, int $conId): ?Message
    {
        return $this->messagesRepository->findOneBy(["id" => $messId, "con_id" => $conId]);
    }

    public function search(int $conId, array $filter, $toArray = false): Collection|array|null
    {
        return $this->messagesRepository->getMessagesBy($conId, $filter, $toArray);
    }
    private function isMessageOfUser(Message $mes, int $userId): bool
    {
        return $mes->user_id == $userId;
    }
}
