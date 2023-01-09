<?php

namespace App\Http\Controllers;

use App\Services\Interfaces\IMessagesService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MessagesController extends Controller
{
    public function __construct(
        private readonly IMessagesService $messageService
    )
    {}

    public function getMessages(Request $request): JsonResponse
    {
        $userId = $request->input("uid");
        $conId = $request->input("conId");
        $offset = $request->input("offset") ?: 0;
        $limit = $request->input("limit") ?: 10;

        $messages = $this->messageService->getMessageFromConversation($userId, $conId, compact("offset", "limit"));
        if ($messages) {
            return $this->responseSuccessWithData(
                "messages.get.successful",
                $messages
            );
        }
        return $this->responseError("messages.get.failed");
    }
    public function edit(Request $request): JsonResponse {
        $userId = $request->input("uid");
        $conId = $request->input("conId");
        $mesId = $request->input("mesId");
        $content = $request->input("content");
        if ($this->messageService->edit($userId, $conId, $mesId, $content)) {
            return $this->responseSuccess("messages.edit.successful");
        }
        return $this->responseError("messages.edit.failed");
    }
    public function delete(Request $request): JsonResponse
    {
        $userId = $request->input("uid");
        $conId = $request->input("conId");
        $mesId = $request->input("mesId");
        if ($this->messageService->delete($userId, $conId, $mesId)) {
            return $this->responseSuccess("messages.delete.successful");
        }
        return $this->responseError("messages.delete.failed");
    }
}
