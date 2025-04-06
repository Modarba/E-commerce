<?php

namespace App\Actions\User;

use App\Actions\BaseAction;
use App\Models\Order;
use Faker\Provider\Base;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Validation\Validator;

class DeleteOrderAction extends  BaseAction
{
    public function validate(array $data)
    {
        \Illuminate\Support\Facades\Validator::make($data,[
            'id' => 'required',
        ])->validate();
    }
    public function execute(array $data)
    {
        $data=[
            'id'=>$data['id'],
        ];
        $order=Order::findorfail($data['id']);
        $order->delete();
        return ['message'=>'success'];
    }
    public function resource($result):JsonResource
    {
        return  new JsonResource($result);
    }
}
