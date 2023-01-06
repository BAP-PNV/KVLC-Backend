<?php

namespace App\Repositories\Implementations;

use App\Models\User;

class UserRepository extends BaseRepository implements \App\Repositories\Interfaces\IUserRepository
{

    public function getModel(): string
    {
        return User::class;
    }

    public function ban(string $userId): mixed
    {
        return $this->model->find($userId)->trashed();
    }

    public function getInfo(string $userId): mixed
    {
        $info = $this->model->find($userId, ["id", "full_name", "email"]);
        return $info ? $info : null;
    }
    public function findUser(string $searchText): mixed
    {

        $user_id = User::select("id", "full_name", "email")
        ->Where("full_name", "LIKE","%$searchText%")
        ->orWhere("email", "LIKE","%$searchText%")->get()->toArray();
        return $user_id;
    }
}
