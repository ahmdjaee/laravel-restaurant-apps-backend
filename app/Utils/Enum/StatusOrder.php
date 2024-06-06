<?php

namespace App\Utils\Enum;

enum StatusOrder: string
{
    case new = 'new';
    case checkout = 'checkout';
    case paid = 'paid';
    case failed = 'failed';
    case completed = 'completed';
}