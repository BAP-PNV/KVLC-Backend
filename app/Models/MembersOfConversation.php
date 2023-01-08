<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MembersOfConversation extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ["con_id", "user_id", "display_name", "created_at", "updated_at"];
    public function conversation()
    {
        return $this->belongsTo(\App\Models\Conversation::class);
    }
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
