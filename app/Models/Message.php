<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $fillable = ["id", "con_id", "user_id", "content", "type", "created_at", "updated_at"];
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
    public function conversation()
    {
        return $this->belongsTo(\App\Models\Conversation::class);
    }

}
