<?php

namespace App\Repository;

use App\Actions\BaseFilter;
use App\Console\Commands\Query;
use App\Enum\OrderEnum;
use App\Models\Order;
use Illuminate\Support\Str;
use PHPUnit\TextUI\Output\SummaryPrinter;

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
