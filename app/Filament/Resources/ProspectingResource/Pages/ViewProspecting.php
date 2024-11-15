<?php

namespace App\Filament\Resources\ProspectingResource\Pages;

use App\Filament\Resources\ProspectingResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions;

class ViewProspecting extends ViewRecord
{
    protected static string $resource = ProspectingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
