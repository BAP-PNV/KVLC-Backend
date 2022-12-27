<?php
namespace App\Services\Interfaces;
interface IMessageService {
    public function send(int $conversationId, string $receiverId, string $content);
    public function edit(int $conversationId, int $mesId, string $content);
    public function delete(int $conversationId, int $mesId);
}
