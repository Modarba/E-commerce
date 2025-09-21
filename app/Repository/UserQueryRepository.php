<?php

namespace App\Repository;

use App\BaseFilter;
use App\Enum\UserEnum;
use App\Models\User;

class UserQueryRepository extends BaseFilter
{
    public function getQuery()
    {
        return User::query();
    }
    public function getFilterableFields():array
    {
        return  UserEnum::cases();
    }
    public function getRelationshipMap():array
    {
        return [
            'user'=>['relation'=>UserEnum::ORDER->value,'column'=>UserEnum::NAME->value],
        ];
    }
}
