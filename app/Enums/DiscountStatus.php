<?php

namespace App\Enums;

enum DiscountStatus:int
{
    case Scheduled = 0;
    case Active = 1;
    case Inactive = 2;
    case Expired = 3;
}
