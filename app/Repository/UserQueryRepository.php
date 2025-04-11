<?php

namespace App\Repository;

use App\Actions\BaseFilter;
use App\Enum\UserEnum;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Str;
use Mockery\Mock;

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
