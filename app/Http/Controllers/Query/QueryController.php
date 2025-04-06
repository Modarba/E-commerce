<?php

namespace App\Http\Controllers\Query;
use App\Actions\Query\ProductQueryAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Repository\ProductQueryRepository;
use App\Service\ProductFilterService;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QueryController extends Controller
{
    protected $productRepository;
    public function __construct(ProductQueryRepository $productRepository)
    {
        $this->productRepository=$productRepository;
    }
    public function query(Request $request)
    {
        return $this->productRepository->getFilteredProducts($request->query());
    }
}
