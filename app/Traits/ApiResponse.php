<?php
namespace App\Traits;

use Symfony\Component\HttpFoundation\Response;

trait ApiResponse {
    public function responseSuccess($message = "Successful!", $status=Response::HTTP_OK): array {
        return [
            "message" => $message,
            "status" => $status
        ];
    }
    public function responseSuccessWithData(mixed $data, string $message = "Successful!", int $status=Response::HTTP_OK): array
    {
        return [
            "message" => $message,
            "status" => $status,
            "data" => $data
        ];
    }
    public function responseError(array $errors = [], int $status=Response::HTTP_BAD_REQUEST): array
    {
        return [
            "errors" => $errors,
            "status" => $status
        ];
    }
}
