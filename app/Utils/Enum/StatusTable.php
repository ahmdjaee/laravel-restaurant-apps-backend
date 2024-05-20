<?php

namespace App\Utils\Enum;

enum StatusTable: string
{
    case available = 'available';
    case booked = 'booked';
    case used = 'used';
}
