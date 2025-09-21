<?php

namespace App\Exceptions;

class InvalidPaymentAmountException extends BaseBusinessException
{
    public function __construct(string $message = "المبلغ غير صحيح")
    {
        parent::__construct($message, 400);
    }
}
