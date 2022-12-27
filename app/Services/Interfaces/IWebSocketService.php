<?php

namespace App\Services\Interfaces;
interface IWebSocketService
{
    public function createChannel();
    public function connectToChannel($channelId);
    public function destroyChannel($channelId);
}
