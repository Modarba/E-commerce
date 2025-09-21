<?php
namespace App\Http\Controllers\User;
use App\Enum\StatusCode;
use App\Http\Controllers\Controller;
use App\Http\Requests\MakeOrderRequest;
use App\Http\Requests\PaymentRequest;
use App\Http\Requests\SearchProductRequest;
use App\Http\Requests\UpdateProductOrderRequest;
use App\Http\Resources\OrderResource;
use App\Http\Resources\ProductOrderResource;
use App\Http\Resources\ProductResource;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Services\OrderService;
class UserController extends Controller
{
    public function __construct(
        protected Product $productModel,
        protected OrderService $orderService,
        protected Order $orderModel,
        protected OrderProduct $orderProductModel
    )
    {
    }

    public function searchProduct(SearchProductRequest $request)
    {
        $products = $this->productModel::searchByName($request->validated()['name']);
        return $this->successResponse(ProductResource::collection($products),  StatusCode::SUCCESS->value);
    }

    public function makeOrder(MakeOrderRequest $request)
    {
        $orderProduct = $this->orderService->makeOrder($request->validated()['product_id'], $request->validated()['quantity']);
        return $this->successResponse(new ProductOrderResource($orderProduct),  StatusCode::CREATED->value);
    }

    public function payment(PaymentRequest $request)
    {
        $order = $this->orderModel->findOrFail($request->validated()['order_id']);
        $order = $order->processPayment($request->validated()['amount'], $request->validated()['method']);
        return $this->successResponse(new OrderResource($order),  StatusCode::SUCCESS->value);
    }

    public function ordersForUser()
    {
        $orders = $this->orderService->browseOrders();
        return $this->successResponse(OrderResource::collection($orders),  StatusCode::SUCCESS->value);
    }

    public function cancelOrder($id)
    {
        $this->orderModel::deleteOrder($id);
        return $this->successResponse(['message' => 'success'],  StatusCode::SUCCESS->value);
    }

    public function updateProductOrder(UpdateProductOrderRequest $request, $id)
    {
        $orderProduct = $this->orderProductModel->findOrFail($id);
        $orderProduct = $orderProduct->updateQuantity($request->validated()['quantity']);
        return $this->successResponse(new ProductOrderResource($orderProduct),  StatusCode::SUCCESS->value);
    }

    public function removeProductOrder($id)
    {
        $this->orderService->removeProductFromOrder($id);
        return $this->successResponse(['message' => 'success'],  StatusCode::SUCCESS->value);
    }
}
