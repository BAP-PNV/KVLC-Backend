<?php

namespace App\Http\Controllers;

use App\Services\Interfaces\ConversationCreationStatus;
use App\Services\Interfaces\IConversationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ConversationController extends Controller
{
    public function __construct(
        private readonly IConversationService $conversationService
    ){}
    public function addNewConversation(Request $request): JsonResponse
    {
        $creatorId = $request->input("creator");
        $memberId = $request->input("member");
        $result = $this->conversationService->addNewConversation($creatorId, $memberId);
        $response = null;
        switch ($result) {
            case ConversationCreationStatus::SUCCESSFUL: {
                $response = $this->responseSuccess("conversation.create.successful", Response::HTTP_CREATED);
                break;
            }
            case ConversationCreationStatus::EXISTED: {
                $response = $this->responseSuccess("conversation.create.exists");
                break;
            }
            case ConversationCreationStatus::FAILED: {
                $response = $this->responseErrorWithDetails(
                    "conversation.create.failed",
                    ["error" => "Friend relationship not found!"]
                );
                break;
            }
        }
        return $response?:
            $this->responseErrorWithDetails(
                "conversation.create.failed",
                ["error" => "Has some errors, please try again!"]
            );
    }
    public function leaveConversation(Request $request): JsonResponse {
        $conId = $request->input("conId");
        $userId = $request->input("uid");

        $result = $this->conversationService->leaveConversation($userId, $conId);
        if ($result) {
            return $this->responseSuccess("conversation.leave.successful");
        }
        return $this->responseErrorWithDetails(
            "conversation.leave.successful",
            ["error" => "Your are not in this conversation!"]
        );
    }
}
