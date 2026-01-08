<?php

namespace App\Enums\Enums;

enum IDType: string
{
    case Passport = 'passport';
    case NationalID = 'national_id';

    public function label (): string
    {
        return match ($this) {
            self::Passport => 'Passaporte',
            self::NationalID => 'Bilhete de Identidade',
        };
    }
}
