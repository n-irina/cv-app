<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum ProspectingType: string implements HasLabel
{
    case Email = 'email';
    case Call = 'call';
    case Meeting = 'meeting';

    public function getLabel(): ?string
    {

        return match ($this) {
            self::Email => 'Email',
            self::Call => 'Call',
            self::Meeting => 'Meeting',

        };
    }
}
