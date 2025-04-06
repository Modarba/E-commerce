<?php

namespace App\Actions\User;

use App\Actions\BaseAction;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Exception;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Validator;

class PaymentAction extends  BaseAction
{
    public  function validate(array $data)
    {
        Validator::make($data,[
            'order_id' => 'required|exists:orders,id',
            'amount'   => 'required|numeric|min:1',
            'method'   => 'required|in:wallet,card,cash',
        ])->validate();
    }
    public function processPayment(int $orderId, float $amount, string $method): Order
    {
        $order = Order::findOrFail($orderId);
        if ($order->payment_status === 'paid') {
            throw new Exception('This order is already paid.');
        }
        if ($order->total_price !=$amount) {
            $order->update(['payment_status' => 'failed']);
            throw new Exception('invalid amount');
        }
        $transactionId = $this->simulatePaymentGateway($amount, $method);
        $order->update([
            'payment_status' => 'paid',
            'payment_method' => $method,
            'transaction_id' => $transactionId,
            'total_price'    => $amount,
        ]);

        return $order->refresh();
    }
    private function simulatePaymentGateway(float $amount, string $method): string
    {
        return 'TXN_' . strtoupper($method) . '_' . uniqid();
    }
    public  function  execute(array $data)
    {
        $order=$this->processPayment($data['order_id'],$data['amount'],$data['method']);
        return $order;
    }
    public  function  resource($result):JsonResource
    {
        return new OrderResource($result);
    }
}
