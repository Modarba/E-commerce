<?php

namespace App\Enum;

enum ProductEnum: string
{
    case ID='id';
    case NAME = 'name';
    case ORDER = 'orders';
    case CATEGORY = 'categories';
    case DESCRIPTION = 'description';
    case PRICE = 'price';
    case QUANTITY = 'quantity';
    
    case CREATED_AT = 'created_at';
}
