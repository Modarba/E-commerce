<?php

namespace App\Enum;

enum OrderEnum :string
{
    case ID='id';
    case TOTAL_PRICE = 'total_price';
    case STATUS = 'status';
    case PAYMENT_STATUS = 'payment_status';
    case  payment_method = 'payment_method';
    case USER='user';
    case PRODUCT='products';
    case NAME='name';

}
