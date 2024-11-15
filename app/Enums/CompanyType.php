<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum CompanyType: string implements HasLabel
{
    case Customer = 'customer';
    case Service = 'service';

    public function getLabel(): ?string
    {

        return match ($this) {
            self::Customer => 'Customer',
            self::Service => 'Service',

        };
    }
}


