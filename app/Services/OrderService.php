<?php
namespace App\Services;
use App\Exceptions\QuantityExceededException;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class OrderService
{
    public function __construct(
    protected    Order $orderModel,
    protected  OrderProduct $orderProductModel,
    protected  Product $productModel
    )
    {
    }
    public function makeOrder(int $productId, int $quantity)
    {
        return DB::transaction(function () use ($productId, $quantity) {
            $product = $this->productModel->findOrFail($productId);
            if ($product->quantity < $quantity) {
                throw new QuantityExceededException();
            }
            $order = $this->orderModel->firstOrCreate(['user_id' => Auth::id()]);
            $orderProduct = $this->orderProductModel->create([
                'product_id' => $productId,
                'order_id' => $order->id,
                'quantity' => $quantity,
                'price' => $product->price * $quantity,
            ]);
            $order->save();
            return $orderProduct;
        });
    }
    public function browseOrders()
    {
        return $this->orderModel->with('products')->where('user_id', Auth::id())->get();
    }

    public function removeProductFromOrder(int $id)
    {
        $orderProduct = $this->orderProductModel->findOrFail($id);
        $order = $orderProduct->order;
        $orderProduct->delete();
        $order->save();
        return ['message' => 'success'];
    }
}
