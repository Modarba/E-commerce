<?php

namespace App\Enum;

enum OrderProductEnum:string
{
    case ID='id';
    case QUANTITY='quantity';
    case PRICE='price';
    case ORDER='order';
    case PRODUCT='product';
}
