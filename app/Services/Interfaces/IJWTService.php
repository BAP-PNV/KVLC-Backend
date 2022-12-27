<?php
namespace App\Services\Interfaces;

interface IJWTService {
    public function generateAccessToken(int $userId);
    public function generateRefreshToken(int $userId);
    public function verifyToken(string $token, string $secret);
}
