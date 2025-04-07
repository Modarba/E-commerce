<?php

namespace App\Actions\Query;

use App\Actions\FilterSpecification;

class StockSpecificationAction extends FilterSpecification
{
    public function apply($query, $value)
    {
        return $query->where('quantity', '>', 0);
    }
}
