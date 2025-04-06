<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'price', 'quantity', 'image'];

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_product')
            ->withPivot('quantity', 'price')
            ->withTimestamps();
    }

    public function categories()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public static function applyFilters(array $filters)
    {
        $query = self::query();
        foreach ($filters as $key => $value) {
            if ($value !== null && $value !== '') {
                $scopeMethod = lcfirst($key);
                if (method_exists(new self, 'scope' . ucfirst($key))) {
                    $query->{$scopeMethod}($value);
                }
            }
        }
        return $query->paginate(20);
    }
    public function scopeSearch(Builder $query, $search)
    {
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }
    }
    public function scopeCategory(Builder $query, $category)
    {
        if ($category) {
            $query->whereHas('categories', function ($q) use ($category) {
                $q->where('name', 'like', "%{$category}%");
            });
        }

    }
    public function scopeMinPrice(Builder $query, $minPrice)
    {
        if ($minPrice) {
            $query->whereRaw('CAST(price AS DECIMAL) >= ?', [$minPrice]);
        }
    }
    public function scopeMaxPrice(Builder $query, $maxPrice)
    {
        if ($maxPrice) {
            $query->whereRaw('CAST(price AS DECIMAL) <= ?', [$maxPrice]);
        }
    }
    public function scopeSort(Builder $query, $sort)
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
    public function scopeInStock(Builder $query, $inStock)
    {
        if ($inStock) {
            $query->where('quantity', '>', 0);
        }
    }
}
