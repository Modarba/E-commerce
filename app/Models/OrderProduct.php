<?php

namespace App\Models;

use App\Exceptions\QuantityExceededException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory;

    protected $table = 'order_product';
    public $timestamps = true;

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function updateQuantity(int $quantity)
    {
        $product = $this->product;
        if ($product->quantity < $quantity) {
            throw new QuantityExceededException();
        }

        $this->update([
            'quantity' => $quantity,
            'price' => $quantity * $product->price,
        ]);

        $this->order->save();
        return $this;
    }
}
