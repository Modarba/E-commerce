<?php

namespace App\Http\Controllers\Query;
use App\Actions\Query\ProductQueryAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Service\ProductFilterService;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QueryController extends Controller
{

   protected $filterService ;
   public function __construct()
   {
       $this->filterService=new ProductFilterService();
   }
    public function query()
    {
        $data=$this->filterService->execute([
            'search'=>request()->query('search'),
            'min_price'=>request()->query('min_price'),
            'max_price'=>request()->query('max_price'),
            'sort'=>request()->query('sort'),
            'category'=>request()->query('category'),
            'in_stock'=>request()->query('in_stock'),
        ]);
        return ProductResource::collection($data);
    }
}
