<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum MediaType: string implements HasLabel
{
    case Resume = 'resume';
    case Contract = 'contract';
    case Other = 'other';

    public function getLabel(): ?string
    {

        return match ($this) {
            self::Resume => 'Resume',
            self::Contract => 'Contract',
            self::Other => 'Other',

        };
    }
}
