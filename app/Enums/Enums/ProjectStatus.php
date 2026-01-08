<?php

namespace App\Enums\Enums;

enum ProjectStatus: int
{
    case PLANNED = 0;
    case ONGOING = 1;
    case COMPLETED = 2;
    case ON_HOLD = 3;
    case CANCELLED = 4;

    public function label(): string
    {
        return match ($this) {
            self::PLANNED => 'Planeado',
            self::ONGOING => 'Em andamento',
            self::COMPLETED => 'Concluído',
            self::ON_HOLD => 'Em espera',
            self::CANCELLED => 'Cancelado',
        };
    }
}
