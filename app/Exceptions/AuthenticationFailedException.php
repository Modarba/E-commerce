<?php
namespace App\Exceptions;
class AuthenticationFailedException extends BaseBusinessException
{
    public function __construct(string $message = "فشل في التحقق من الهوية")
    {
        parent::__construct($message, 401);
    }
}
