<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum ContactProfil: string implements HasLabel
{
    case Candidate = 'candidate';
    case Headhunter = 'headhunter';
    case Salesman = 'salesman';

    public function getLabel(): ?string
    {

        return match ($this) {
            self::Candidate => 'Candidate',
            self::Headhunter => 'Headhunter',
            self::Salesman => 'Salesman',

        };
    }
}
