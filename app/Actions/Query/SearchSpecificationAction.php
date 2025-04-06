<?php

namespace App\Actions\Query;

use App\Actions\FilterSpecification;

class SearchSpecificationAction extends FilterSpecification
{
    private array $searchableColumns;

    public function __construct(array $searchableColumns)
    {
        $this->searchableColumns = $searchableColumns;
    }
    public function apply($query, $value)
    {
        return $query->where(function($q) use ($value) {
            foreach ($this->searchableColumns as $column) {
                $q->orWhere($column, 'like', "%{$value}%");
            }
        });
    }
}
