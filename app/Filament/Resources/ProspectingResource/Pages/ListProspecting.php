<?php

namespace App\Filament\Resources\ProspectingResource\Pages;

use App\Filament\Resources\ProspectingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProspecting extends ListRecords
{
    protected static string $resource = ProspectingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
