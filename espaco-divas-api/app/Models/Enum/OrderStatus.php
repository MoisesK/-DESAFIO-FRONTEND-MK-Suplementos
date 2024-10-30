<?php

namespace App\Models\Enum;

enum OrderStatus: int
{
    case PENDING = 1;
    case PROOF_FILE_APPROVED = 2;
    case CONFIRMED = 3;
    case CANCELLED = 4;
    case PROOF_FILE_NOT_APPROVED = 5;
}
