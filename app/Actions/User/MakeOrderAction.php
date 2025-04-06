<?php

namespace App\Actions\User;

use App\Actions\BaseAction;
use App\Enum\StatusCode;
use App\Http\Resources\ProductOrderResource;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class MakeOrderAction extends  BaseAction
{
    public  function validate(array $data)
    {
        Validator::make($data, [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ])->validate();
    }
    private function sumTotalPrice(int $data)
    {
        $sum=OrderProduct::
            where('order_id',$data)
            ->sum('price');
        return $sum;
    }
    /**
     * @throws \Exception
     */
    public function execute(array $data)
    {
        $product = Product::findOrFail($data['product_id']);
        if ($product->quantity < $data['quantity']) {
            throw new \Exception('Insufficient product quantity available', StatusCode::BAD_REQUEST->value);
        }
        $order = Order::firstOrCreate([
            'user_id' => Auth::id(),
        ]);
      $create=  OrderProduct::create([
            'product_id' => $data['product_id'],
            'order_id' => $order->id,
            'quantity' => $data['quantity'],
            'price' => $product->price*$data['quantity'],
        ]);
        $order->update(['total_price' => $this->sumTotalPrice($order->id)]);
        $product->decrement('quantity', $data['quantity']);
       return $create;
    }
    public function resource($result):JsonResource
    {
        return  new ProductOrderResource($result);
    }
}
