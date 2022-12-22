<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 
class Conversation extends Model
{
    use HasFactory;
    public function message()
    {
        return $this->hasMany(\App\Models\Message::class);
    }
    public function membersOfConversation()
    {
        return $this->hasMany(\App\Models\MembersOfConversation::class);
    }
}
