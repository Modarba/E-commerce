<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
          'order_id'=>$this->order_id,
            'status'=>$this->status,
            'total_price'=>$this->total_price,
            'payment_status'=>$this->payment_status,
            'payment_method'=>$this->payment_method,
            'transaction_id'=>$this->transaction_id,
        ];
    }
}
