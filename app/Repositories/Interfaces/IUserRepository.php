<?php

namespace App\Repositories\Interfaces;

interface IUserRepository extends IRepository
{
    public function ban(int $userId): mixed;
    public function getInfo(int $userId): mixed;
    public function findUser(string $searchText):mixed;
}
