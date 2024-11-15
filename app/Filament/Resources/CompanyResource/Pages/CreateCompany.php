<?php

namespace App\Filament\Resources\CompanyResource\Pages;

use App\Filament\Resources\CompanyResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCompany extends CreateRecord
{
    protected static string $resource = CompanyResource::class;

    protected function getRedirectUrl(): string
    {
        return route('filament.admin.resources.companies.index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Company has been created successfully';
    }
}
