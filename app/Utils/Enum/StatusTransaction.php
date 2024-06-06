<?php

namespace App\Utils\Enum;

enum StatusTransaction: string
{
    case new = 'new';
    case cancelled = 'cancelled';
    case pending = 'pending';
    case failed = 'failed';
    case rejected = 'rejected';
    case success = 'success';
}