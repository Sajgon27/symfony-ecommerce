<?php

namespace App\Enum;

enum AddressesType: string
{
    case BILLING = 'billing';
    case SHIPPING = 'shipping';
   
}