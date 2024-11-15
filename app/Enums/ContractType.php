<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum ContractType: string implements HasLabel
{
    case Long = 'long';
    case Short = 'short';
    case Ponctual = 'ponctual';

    public function getLabel(): ?string
    {

        return match ($this) {
            self::Long => 'Long',
            self::Short => 'Short',
            self::Ponctual => 'Ponctual',

        };
    }
}
