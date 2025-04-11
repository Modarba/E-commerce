<?php

namespace App\Actions;

use Illuminate\Support\Str;

abstract class BaseFilter
{
    abstract protected function getQuery();
    abstract protected function getFilterableFields(): array;
    public function getFilteredResults(array $data)
    {
        $query = $this->getQuery();
        foreach ($data as $key => $value) {
            $this->applyFilter($query, $key, $value);
        }
        return $query->paginate(20);
    }
    abstract protected function getRelationshipMap(): array;
    protected function applyFilter($query, $key, $value)
    {
        $method = 'apply' . Str::studly($key) . 'Filter';
        if (method_exists($this, $method)) {
            $this->$method($query, $value);
        } else {
            $relationshipMap = $this->getRelationshipMap();
            if (isset($relationshipMap[$key]) && $value) {
                $relation = $relationshipMap[$key]['relation'];
                $column   = $relationshipMap[$key]['column'];
                $this->applyRelationshipFilter($query, $relation, $column, $value);
            }
        }
    }
    protected function applyRelationshipFilter($query, $relation, $column, $value)
    {
        $query->whereHas($relation, function ($q) use ($column, $value) {
            $q->where($column, $value);
        });
    }
    public function applySearchFilter($query, $search)
    {
        if ($search) {
            $searchable = array_filter($this->getFilterableFields(), function ($field) {
                return in_array($field->value, ['name', 'description']);
            });
            $query->where(function ($q) use ($search, $searchable) {
                foreach ($searchable as $field) {
                    $q->orWhere($field->value, 'like', "%{$search}%");
                }
            });
        }
    }
    public function applyMinPriceFilter($query, $minPrice)
    {
        if ($minPrice) {
            $fields = $this->getFilterableFields();
            if (collect($fields)->pluck('value')->contains('price')) {
                $query->whereRaw('CAST(price AS DECIMAL) >= ?', [$minPrice]);
            }
        }
    }
    public function applyMaxPriceFilter($query, $maxPrice)
    {
        if ($maxPrice) {
            $fields = $this->getFilterableFields();
            if (collect($fields)->pluck('value')->contains('price')) {
                $query->whereRaw('CAST(price AS DECIMAL) <= ?', [$maxPrice]);
            }
        }
    }
    public function applySortFilter($query, $sort)
    {
        if ($sort) {
            $order = ($sort === 'price_asc' || $sort === 'newest') ? 'asc' : 'desc';
            $column = match($sort) {
                'price_asc', 'price_desc' => 'price',
                'newest' => 'created_at',
                default => 'created_at'
            };

            $fields = $this->getFilterableFields();
            if (collect($fields)->pluck('value')->contains($column)) {
                $query->orderBy($column, $order);
            }
        }
    }
    public function applyInStockFilter($query, $inStock)
    {
        if ($inStock) {
            $fields = $this->getFilterableFields();
            if (collect($fields)->pluck('value')->contains('quantity')) {
                $query->where('quantity', '>', 0);
            }
        }
    }
}
