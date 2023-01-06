<?php

namespace App\Repositories\Interfaces;

interface IUserRepository extends IRepository
{
    public function ban(string $userId): mixed;
    public function getInfo(string $userId): mixed;
    public function findUser(string $searchText):mixed;
}
