<?php
namespace App\Repository;
use App\Models\OrderProduct;
use Illuminate\Support\Str;
class OrderProductQueryRepository
{
    public function getOrderFilter(array $data)
    {
        $query= OrderProduct::query();
        foreach ($data as $key => $value) {
            $method='apply'.Str::studly($key).'Filter';
            if (method_exists($this, $method)) {
                $this->$method($query,$value);
            }
        }
    }
    public function applyPriceMaxFilter($query,$price)
    {
        if ($price)
        {
            $query->where('price','>=',$price);
        }
    }
    public function applyPriceMinFilter($query,$price)
    {
        if ($price)
        {
            $query->where('price','<=',$price);
        }
    }
    public function applyQuantityFilter($query,$quantity)
    {
        if ($quantity) {
            $query->where('quantity', '>=', 0);
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
}
