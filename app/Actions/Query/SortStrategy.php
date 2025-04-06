<?php

namespace App\Actions\Query;

class SortStrategy
{
    private array $sortMappings;

    public function __construct(array $sortMappings)
    {
        $this->sortMappings = $sortMappings;
    }
    public function apply($query, $sort)
    {
        [$column, $direction] = $this->sortMappings[$sort] ?? $this->sortMappings['default'];
        return $query->orderBy($column, $direction);
    }
}
