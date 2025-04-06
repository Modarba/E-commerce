<?php

namespace App\Actions\Admin;

use App\Actions\BaseAction;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Validator;

class UpdateStatusOrderAction extends  BaseAction
{
    public function validate(array $data)
    {
        Validator::make($data, [
            'id'=>'required',
            'status'=>'required',
        ])->validate();
    }
    public  function  execute(array $data)
    {
        $order=Order::findorfail($data['id']);
        $order->update(['status' => $data['status']]);
        return $order;
    }
    public  function  resource($result):JsonResource
    {
        return new OrderResource($result);
    }
}
