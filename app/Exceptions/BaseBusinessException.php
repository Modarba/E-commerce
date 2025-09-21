<?php

namespace App\Exceptions;
use Exception;

class BaseBusinessException extends Exception
{
    protected int $statusCode = 400;
    public function __construct(string $message = "", int $statusCode = 0)
    {
        parent::__construct($message);

        if ($statusCode > 0) {
            $this->statusCode = $statusCode;
        }
    }
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}
