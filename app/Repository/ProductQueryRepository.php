<?php
namespace App\Repository;
use App\Actions\BaseFilter;
use App\Enum\ProductEnum;
use App\Enum\StatusCode;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
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
