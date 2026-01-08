<?php

namespace App\Enums\Enums;

enum MaritalStatus:string
{
    case Single = 'single';
    case Married = 'married';
    case Divorced = 'divorced';
    case Widowed = 'widowed';

    public function label (): string
    {
        return match ($this) {
            self::Single => 'Solteiro(a)',
            self::Married => 'Casado(a)',
            self::Divorced => 'Divorciado(a)',
            self::Widowed => 'Viúvo(a)',
        };
    }
}
