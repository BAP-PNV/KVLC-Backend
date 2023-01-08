<?php

namespace App\Services\Interfaces;

enum ConversationCreationStatus
{
    case SUCCESSFUL;
    case EXISTED;
    case FAILED;
}
