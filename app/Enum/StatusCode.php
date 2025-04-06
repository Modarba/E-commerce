<?php

namespace App\Enum;

use Illuminate\Validation\Rules\Enum;
enum  StatusCode:int
{
    case SUCCESS = 200;
    case CREATED = 201;
    case UNAUTHORIZED = 401;
    case FORBIDDEN = 403;
    case NOTFOUND = 404;
    case INTERNAL_SERVER_ERROR = 500;
    case  BAD_REQUEST = 400;
}
