<?php

namespace App\Actions\Query;

use App\Actions\FilterSpecification;

class PriceRangeSpecificationAction extends  FilterSpecification
{
    private string $operator;
    public function __construct(string $operator)
    {
        $this->operator = $operator;
    }
    public function apply($query, $value)
    {
        return $query->whereRaw("CAST(price AS DECIMAL) {$this->operator} ?", [$value]);
    }
}
