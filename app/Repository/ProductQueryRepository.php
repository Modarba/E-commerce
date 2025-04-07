<?php

namespace App\Repository;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Str;
class ProductQueryRepository
{
    public function getFilteredProducts(array $data)
    {
        $query = Product::query();
        foreach ($data as $key => $value) {
            $method = 'apply' . Str::studly($key) . 'Filter';
            if (method_exists($this, $method)) {
                $this->$method($query, $value);
            }
        }

        return $query->paginate(20);
    }
    public function applySearchFilter($query, $search)
    {
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }
    }
    public function applyCategoryFilter($query, $category)
    {
        if ($category) {
            $query->whereHas('categories', function ($q) use ($category) {
                $q->where('name', 'like', "%{$category}%");
            });
        }
    }
    public function applyMinPriceFilter($query, $minPrice)
    {
        if ($minPrice) {
            $query->whereRaw('CAST(price AS DECIMAL) >= ?', [$minPrice]);
        }
    }
    public function applyMaxPriceFilter($query, $maxPrice)
    {
        if ($maxPrice) {
            $query->whereRaw('CAST(price AS DECIMAL) <= ?', [$maxPrice]);
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

            $query->orderBy($column, $order);
        }
    }
    public function applyInStockFilter($query, $inStock)
    {
        if ($inStock) {
            $query->where('quantity', '>', 0);
        }
    }
}
