<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FriendRelationship extends Model
{
    use HasFactory;
    protected $table = 'friend_relationships';
    protected $fillable = ['id','user_id'];
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

}
