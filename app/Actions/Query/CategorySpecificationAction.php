<?php

namespace App\Actions\Query;

use App\Actions\FilterSpecification;

class CategorySpecificationAction extends  FilterSpecification
{
    public function apply($query, $value)
    {
        return $query->whereHas('categories', fn($q) =>
        $q->where('name', 'like', "%{$value}%")
        );
    }
}
