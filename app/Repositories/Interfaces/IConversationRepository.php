<?php
namespace App\Repositories\Interfaces;
use Illuminate\Database\Eloquent\Collection;

interface IConversationRepository extends IRepository {
    public function getMembersByConversationId(int $id): Collection;
}
