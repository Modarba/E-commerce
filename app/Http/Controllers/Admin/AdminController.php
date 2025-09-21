<?php
namespace App\Http\Controllers\Admin;
use App\Enum\StatusCode;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Requests\UpdateStatusRequest;
use App\Http\Resources\OrderResource;
use App\Http\Resources\ProductResource;
use App\Models\Order;
use App\Models\Product;
use App\Services\ProductService;
class AdminController extends Controller
{
    public function __construct(
        protected ProductService $productService,
        protected Order $orderModel,
        protected Product $productModel,
    )
    {
    }

    public function addProduct(AddProductRequest $request)
    {
        $product = $this->productService->addProduct($request->validated(), $request->file('image'));
        return $this->successResponse(new ProductResource($product), StatusCode::SUCCESS->value);
    }

    public function deleteProduct($id)
    {
        $this->productModel->deleteProduct($id);
        return $this->successResponse(['message' => 'success'],  StatusCode::SUCCESS->value);
    }

    public function showProducts()
    {
        $products = $this->productModel->showProducts();
        return $this->successResponse(ProductResource::collection($products),  StatusCode::SUCCESS->value);
    }

    public function updateProduct(UpdateProductRequest $request, $id)
    {
        $product = $this->productModel->updateProduct($id, $request->validated()['price']);
        return $this->successResponse(new ProductResource($product),  StatusCode::SUCCESS->value);
    }

    public function updateStatus(UpdateStatusRequest $request, $id)
    {
        $order = $this->orderModel->findOrFail($id);
        $order = $order->updateStatus($request->validated()['status']);
        return $this->successResponse(new OrderResource($order),  StatusCode::SUCCESS->value);
    }
}
