<?php

namespace App\Actions\User;

use App\Actions\BaseAction;
use App\Http\Resources\ProductOrderResource;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Validator;

class UpdateOrderAction extends  BaseAction
{
    public function validate(array $data)
    {
        Validator::make($data,[
            'quantity'=>'required|integer|min:1',
        ]);
    }
    public  function  execute(array $data)
    {
        $order=OrderProduct::findorfail($data['id']);
        $product=Product::findorfail($order->product_id);
        $order->update([
                'quantity'=>$data['quantity'],
                'price'=>$data['quantity']*$product->price,
            ]);
        $sum=OrderProduct::where('order_id',$data['id'])->sum('price');
        Order::where('id',$data['id'])->update(['total_price'=>$sum]);
        return $order;
    }
    public  function  resource($result):JsonResource
    {
        return  new ProductOrderResource($result);
    }
}
