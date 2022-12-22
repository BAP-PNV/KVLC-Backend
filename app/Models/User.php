<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;
    protected $table = "users";
    protected $fillable = ['email', 'fullname', 'password','status'];
    public function friendRelationships()
    {
        return $this->hasMany(\App\Models\FriendRelationship::class);
    }
    public function membersOfConversation()
    {
        return $this->hasMany(\App\Models\MembersOfConversation::class);
    }
    public function messages()
    {
        return $this->hasMany(\App\Models\Message::class);
    }
}
