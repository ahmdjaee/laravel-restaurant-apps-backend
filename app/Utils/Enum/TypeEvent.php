<?php

namespace App\Utils\Enum;

enum TypeEvent: string
{
    case promo = 'Promo';
    case concert = 'Concert';
    case flashSale = 'Flash Sale';
    case workshop = 'Workshop';
    case festival = 'Festival';
}
