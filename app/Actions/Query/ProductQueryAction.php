<?php
namespace App\Actions\Query;
use App\Actions\BaseAction;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Validator;

class ProductQueryAction extends BaseAction
{
    public function execute(array $data)
    {
        return Product::query()
            ->when($data['search'] ?? null, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->when($data['category'] ?? null, function ($query, $category) {
                $query->whereHas('categories', function ($q) use ($category) {
                    $q->where('name', 'like', "%{$category}%");
                });
            })
            ->when($data['min_price'] ?? null,
                fn ($query, $minPrice) => $query->whereRaw('CAST(price AS DECIMAL) >= ?', [$minPrice])
            )
            ->when($data['max_price'] ?? null,
                fn ($query, $maxPrice) => $query->whereRaw('CAST(price AS DECIMAL) <= ?', [$maxPrice])
            )
            ->when($data['sort'] ?? null,
                fn ($query, $sort) => $query->orderBy(
                    match($sort) {
                        'price_asc' => 'price',
                        'price_desc' => 'price',
                        'newest' => 'created_at',
                        default => 'created_at'
                    },
                    $sort === 'price_asc' || $sort === 'newest' ? 'asc' : 'desc'
                )
            )
            ->when($data['in_stock'] ?? null,
                fn ($query, $inStock) => $query->where('quantity', '>', 0)
            )
            ->paginate(20);
    }
    public function resource($result):JsonResource
    {
        return ProductResource::collection($result);
    }
}
