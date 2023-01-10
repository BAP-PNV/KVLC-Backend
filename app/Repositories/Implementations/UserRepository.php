<?php

namespace App\Repositories\Implementations;

use App\Models\User;

class UserRepository extends BaseRepository implements \App\Repositories\Interfaces\IUserRepository
{

    public function getModel(): string
    {
        return User::class;
    }

    public function ban(int $userId): mixed
    {
        return $this->model->find($userId)->trashed();
    }

    public function getInfo(int $userId): mixed
    {
        $info = $this->model->find($userId, ["id", "full_name", "email"]);
        return $info ? : null;
    }

    public function findUser(string $searchText): mixed
    {
        $listUser =$this->model->select("id", "full_name", "email")
            ->Where("full_name", "LIKE","%$searchText%")
            ->orWhere("email", "LIKE","%$searchText%")->get();
        return sizeof($listUser)!=0 ? $listUser : [];
    }
}
