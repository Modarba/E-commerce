<?php

namespace App\Actions\User;

use App\Actions\BaseAction;
use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Validator;

class RemoveProductOrderAction extends BaseAction
{
    public function validate(array $data)
    {
        Validator::make($data, [
            'id'=>'required|int',
        ])->validate();
    }
    public function execute(array $data)
    {
        $productOrder=OrderProduct::findorfail($data['id']);
            $productOrder->delete();
     $sum= $productOrder->where('order_id', $productOrder->order_id)->sum('price')*$productOrder->quantity;
       $order=Order::where('id',$productOrder->order_id)->update([
           'total_price'=>$sum,
       ]);
        return ['message'=>'success'];
    }
    public function resource($result):JsonResource
    {
        return new JsonResource($result);
    }
}
