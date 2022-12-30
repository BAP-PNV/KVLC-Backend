<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait ApiResponse
{
    public function responseSuccess($message = "Successful!", $status = Response::HTTP_OK): JsonResponse
    {
        return response()->json(["message" => $message], $status);
    }

    public function responseSuccessWithData(mixed $data, string $message = "Successful!", int $status = Response::HTTP_OK): JsonResponse
    {
        return response()->json([
            "message" => $message,
            "data" => $data
        ], $status);
    }

    public function responseError(array $errors = [], int $status = Response::HTTP_BAD_REQUEST): JsonResponse
    {
        return response()->json(["errors" => $errors,], $status);
    }
}
