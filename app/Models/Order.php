<?php

namespace App\Models;

use App\Exceptions\InvalidPaymentAmountException;
use App\Exceptions\OrderAlreadyPaidException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_price',
        'status',
        'payment_status',
        'payment_method',
        'transaction_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_product')
            ->withPivot('quantity', 'price')
            ->withTimestamps();
    }
    protected static function booted()
    {
        static::saving(function ($order) {
            $order->total_price = $order->products->sum(function ($product) {
                return $product->pivot->price * $product->pivot->quantity;
            });
        });
    }
    public function updateStatus(string $status)
    {
        $this->status = $status;
        $this->save();
        return $this;
    }
    public function processPayment(float $amount, string $method)
    {
        if ($this->payment_status === 'paid') {
            throw new OrderAlreadyPaidException();
        }

        if ($this->total_price != $amount) {
            $this->payment_status = 'failed';
            $this->save();
            throw new InvalidPaymentAmountException();
        }

        $transactionId = $this->simulatePaymentGateway($amount, $method);

        $this->update([
            'payment_status' => 'paid',
            'payment_method' => $method,
            'transaction_id' => $transactionId,
        ]);

        return $this;
    }

    private function simulatePaymentGateway(float $amount, string $method): string
    {
        return 'TXN_' . strtoupper($method) . '_' . uniqid();
    }
    public static function deleteOrder(int $id)
    {
        $order = self::findOrFail($id);
        $order->delete();
        return ['message' => 'success'];
    }
}
