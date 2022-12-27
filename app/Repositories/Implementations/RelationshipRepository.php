<?php

namespace App\Repositories\Implementations;

use App\Models\FriendRelationship;
use App\Repositories\Interfaces\IRelationshipRepository;
use Exception;

class RelationshipRepository extends BaseRepository implements IRelationshipRepository
{

    public function getModel(): string
    {
        return FriendRelationship::class;
    }
    function blockFriend($relaID,$userIdIsBlocked):mixed {
        try {
            $this->model::where('id', $relaID)
            ->where("user_id", $userIdIsBlocked)
            ->update(["is_blocked" => 1]);
            return true;
        }
        catch (Exception $e) {
            return false;        
        }
       
    }

    function addFriend($userIdWantAdd, $userIdBeAdded): mixed
    {
        try{
            $randId = rand(0,1000000);

            $this->model::create(array("id" => $randId, "user_id" => $userIdWantAdd));
            $this->model::create(array("id" => $randId, "user_id" => $userIdBeAdded));
            return true;
        }
        catch(Exception $e){
            return false;
        }
    }
    
    function unFriend($relaId): mixed
    {
        try{
             $this->model::where('id', $relaId)->get()->delete();
            return true;

        }
        catch(Exception $e){
            throw $e;
        }
    }
    
}