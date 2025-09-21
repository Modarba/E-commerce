<?php
namespace App\Repository;
use App\BaseFilter;
use App\Enum\OrderProductEnum;
use App\Models\OrderProduct;

class OrderProductQueryRepository extends  BaseFilter
{
    protected function getQuery()
    {
       return OrderProduct::query();
    }
    protected function getFilterableFields(): array
    {
        return  OrderProductEnum::cases();
    }
    protected function getRelationshipMap(): array
    {
        return [
            'order'=>['relation' => OrderProductEnum::ORDER->value, 'column' => OrderProductEnum::ID->value],
            'product' => ['relation' => OrderProductEnum::PRODUCT->value,'column' => OrderProductEnum::ID->value],
        ];
    }
}
