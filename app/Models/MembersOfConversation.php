<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembersOfConversation extends Model
{
    use HasFactory;
    
    public function conversation()
    {
        return $this->belongsTo(\App\Models\Conversation::class);
    }
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
