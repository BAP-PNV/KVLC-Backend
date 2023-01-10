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
    /**
     * @OA\Post(path="/api/messages", tags={"Messages"},operationId="getMessages",summary="get message with limit",
     *  @OA\RequestBody(@OA\MediaType(
     *          mediaType="multipart/form-data",
     *          @OA\Schema(required={"uid","conId","offset","limit"},
     *          @OA\Property(property="uid", type="integer"),
     *          @OA\Property(property="conId", type="integer"),
     *          @OA\Property(property="offset", type="integer"),
     *          @OA\Property(property="limit", type="integer"),))),
     * @OA\Response (response="200", description="Success"),
     * @OA\Response (response="404", description="Not Found"),
     * security={ {"passport":{}}}
     * )
     */
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
    /**
     * @OA\Post(path="/api/edit", tags={"Messages"},operationId="edit",summary="edit messages",
     *  @OA\RequestBody(@OA\MediaType(mediaType="multipart/form-data",
     *          @OA\Schema(required={"uid","conId","mesId","content"},
     *          @OA\Property(property="uid", type="integer"),
     *          @OA\Property(property="conId", type="integer"),
     *          @OA\Property(property="mesId", type="integer"),
     *          @OA\Property(property="content", type="integer"),))),
     * @OA\Response (response="200", description="Success"),
     * @OA\Response (response="404", description="Not Found"),
     * security={ {"passport":{}}}
     * )
     */
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
    /**
     * @OA\Delete(path="/api/delete", tags={"Messages"},operationId="delete",summary="delete messages",
     *  @OA\RequestBody(
     *       @OA\MediaType(
     *          mediaType="multipart/form-data",
     *          @OA\Schema(required={"uid","conId","mesId"},
     *          @OA\Property(property="uid", type="integer"),
     *          @OA\Property(property="conId", type="integer"),
     *          @OA\Property(property="mesId", type="integer"),))),
     * @OA\Response (response="200", description="Success"),
     * @OA\Response (response="404", description="Not Found"),
     * security={ {"passport":{}}}
     * )
     */
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
