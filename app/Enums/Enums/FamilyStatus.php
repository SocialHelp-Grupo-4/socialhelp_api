<?php

namespace App\Enums\Enums;

enum FamilyStatus: int
{
    case PENDING = 0;
    case APPROVED = 1;
    case REJECTED = 2;
}
