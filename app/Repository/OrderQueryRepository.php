<?php

namespace App\Repository;

use App\Console\Commands\Query;
use App\Models\Order;
use Illuminate\Support\Str;
use PHPUnit\TextUI\Output\SummaryPrinter;

class OrderQueryRepository
{
    public function getFilteredOrders(array $data)
    {
        $query = Order::query();
        foreach ($data as $key => $value) {
            $method = 'apply' . Str::studly($key) . 'Filter';
            if (method_exists($this, $method)) {
                $this->$method($query, $value);
            }
        }
        return $query->paginate(20);
    }
    public function applyStatusFilter($query, $status){
    if ($status) {
        $query->where('status', $status);
    }}
    public function applyPaymentStatusFilter($query, $paymentStatus)
    {
        if ($paymentStatus) {
            $query->where('payment_status', $paymentStatus);
        }
    }

    public function applyPaymentMethodFilter($query, $paymentMethod)
    {
        if ($paymentMethod) {
            $query->where('payment_method', $paymentMethod);
        }
    }
    public function applyUserFilter($query, $userId)
    {
        if ($userId) {
            $query->where('user_id', $userId);
        }
    }
    public function applyFromDateFilter($query, $fromDate)
    {
        if ($fromDate) {
            $query->whereDate('created_at', '>=', $fromDate);
        }
    }
    public function applyToDateFilter($query, $toDate)
    {
        if ($toDate) {
            $query->whereDate('created_at', '<=', $toDate);
        }
    }

    public function applySearchFilter($query, $search)
    {
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('transaction_id', 'like', "%$search%");
            });
        }
    }
}
