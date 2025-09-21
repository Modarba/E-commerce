<?php
namespace App\Actions\User;
use App\Actions\BaseAction;
use App\Exceptions\QuantityExceededException;
use App\Http\Resources\ProductOrderResource;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class MakeOrderAction extends BaseAction
{
    public function execute($dto)
    {
        return DB::transaction(function () use ($dto) {
            $product = Product::findOrFail($dto->productId);
            if ($product->quantity < $dto->quantity) {
                throw new QuantityExceededException();
            }
            $order = Order::firstOrCreate(['user_id' => Auth::id()]);
            $orderProduct = OrderProduct::create([
                'product_id' => $dto->productId,
                'order_id' => $order->id,
                'quantity' => $dto->quantity,
                'price' => $product->price * $dto->quantity,
            ]);
            $order->update(['total_price' => $this->sumTotalPrice($order->id)]);
         //   $product->decrement('quantity', $dto->quantity);

            $product->save();
            return $orderProduct;
        });
    }
    private function sumTotalPrice(int $data)
    {
        $sum=OrderProduct::
        where('order_id',$data)
            ->sum('price');
        return $sum;
    }
    public function resource($result)
    {
        return new ProductOrderResource($result);
    }
}
