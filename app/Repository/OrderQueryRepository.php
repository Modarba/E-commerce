<?php

namespace App\Repository;

use App\BaseFilter;
use App\Enum\OrderEnum;
use App\Models\Order;

class OrderQueryRepository extends BaseFilter
{
    public function getQuery()
    {
        return Order::query();
    }
    public function getFilterableFields():array
    {
        return  OrderEnum::cases();
    }
    public function getRelationshipMap():array
    {
        return  [
            'user'=>['relation'=>OrderEnum::USER->value,'column'=>OrderEnum::NAME->value],
            'product'=>['relation'=>OrderEnum::PRODUCT->value,'column'=>OrderEnum::NAME->value],
        ];
    }


}
