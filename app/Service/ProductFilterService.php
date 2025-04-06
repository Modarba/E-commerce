<?php

namespace App\Service;

use App\Actions\Query\CategorySpecificationAction;
use App\Actions\Query\PriceRangeSpecificationAction;
use App\Actions\Query\SearchSpecificationAction;
use App\Actions\Query\SortStrategy;
use App\Actions\Query\StockSpecificationAction;
use App\Http\Controllers\Query\QueryController;
use App\Models\Product;

class ProductFilterService
{
    private array $specifications;
    private SortStrategy $sortStrategy;
    public function __construct()
    {
        $this->specifications = [
            'search' => new SearchSpecificationAction(['name', 'description']),
            'category' => new CategorySpecificationAction(),
            'min_price' => new PriceRangeSpecificationAction('>='),
            'max_price' => new PriceRangeSpecificationAction('<='),
            'in_stock' => new StockSpecificationAction()
        ];
        $this->sortStrategy = new SortStrategy([
            'price_asc' => ['price', 'asc'],
            'price_desc' => ['price', 'desc'],
            'newest' => ['created_at', 'asc'],
            'default' => ['created_at', 'desc']
        ]);
    }
    public function execute(array $data)
    {
        $query = Product::query();
        foreach ($this->specifications as $key => $specification)
        {
            if (isset($data[$key])) {
                $specification->apply($query, $data[$key]);
            }
        }
        if (isset($data['sort'])) {
            $this->sortStrategy->apply($query, $data['sort']);
        }
        return $query->paginate(20);
    }
}
