<?php

namespace App\Actions\User;

use App\Actions\BaseAction;
use App\Http\Resources\BrowseOrder;
use App\Models\Order;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class BrowseOrderWithProductAction extends  BaseAction
{
    public  function  execute(array $data=[])
    {
        $order=Order::with('user')
            ->with('products')
            ->where('user_id',Auth::id())
            ->get();
        return $order;
    }
    public function  resource($result):JsonResource
    {
        return   BrowseOrder::collection($result);
    }
}
