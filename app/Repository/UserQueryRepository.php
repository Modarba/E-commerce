<?php

namespace App\Repository;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Str;
use Mockery\Mock;

class UserQueryRepository
{
    public function getUserQuery(array $data)
    {
        $query = \App\Models\User::query();
        foreach ($data as $key => $value) {
            $method = 'apply' . Str::studly($key) . 'Filter';
            if (method_exists($this, $method)) {
                $this->$method($query, $value);
            }
        }
        return $query->paginate(20);
    }
    public function applyUserHasOrderFilter($query, $Name)
    {
        if ($Name)
        {
            $query->where(function ($query) use ($Name) {
                $query->whereHas('order', function ($query) use ($Name) {
                    $query->where('name', 'like', "%{$Name}%");
                });
            });
        }
    }
}
