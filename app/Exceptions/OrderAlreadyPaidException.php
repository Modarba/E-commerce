<?php

namespace App\Exceptions;

class OrderAlreadyPaidException extends BaseBusinessException
{
    public function __construct(string $message = "هذا الطلب مدفوع بالفعل")
    {
        parent::__construct($message, 400);
    }
}
