<?php
namespace App\Repository;
use App\BaseFilter;
use App\Enum\ProductEnum;
use App\Models\Product;

class ProductQueryRepository extends BaseFilter
{
    protected function getQuery()
    {
        return Product::query();
    }
    protected function getFilterableFields(): array
    {
        return ProductEnum::cases();
    }
    protected function getRelationshipMap(): array
    {
        return [
            'category'=>['relation' => ProductEnum::CATEGORY->value, 'column' =>ProductEnum::NAME->value],
        ];
    }

}
