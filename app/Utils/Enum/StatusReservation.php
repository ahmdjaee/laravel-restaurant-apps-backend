<?php

namespace App\Utils\Enum;

enum StatusReservation: string
{
    case pending = 'pending';
    case confirmed = 'confirmed';
    case canceled = 'canceled';
    case completed = 'completed';
}
