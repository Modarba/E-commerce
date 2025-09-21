<?php

namespace App\Exceptions;

class QuantityExceededException extends BaseBusinessException
{
    protected int $statusCode = 400;

    public function __construct(string $message = "الكمية المطلوبة أكبر من المتوفرة")
    {
        parent::__construct($message, $this->statusCode);
    }
}
