<?php
namespace App\Http\Controllers\Query;
use App\Actions\Query\ProductQueryAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Repository\OrderProductQueryRepository;
use App\Repository\OrderQueryRepository;
use App\Repository\ProductQueryRepository;
use App\Repository\UserQueryRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class QueryController extends Controller
{
    public function __construct(
        protected ProductQueryRepository $productRepository,
        protected OrderQueryRepository $orderRepository,
        protected UserQueryRepository $userRepository,
        protected OrderProductQueryRepository $productOrderRepository
    ) {
    }

    public function queryProduct(Request $request)
    {
        return $this->productRepository->getFilteredResults($request->query());
    }
    public function queryOrder(Request $request)
    {
        return $this->orderRepository->getFilteredResults($request->query());
    }
    public function queryUser(Request $request)
    {
        return $this->userRepository->getFilteredResults($request->query());
    }
    public function queryOrderProduct(Request $request)
    {
        return $this->productOrderRepository->getFilteredResults($request->query());
    }
}
