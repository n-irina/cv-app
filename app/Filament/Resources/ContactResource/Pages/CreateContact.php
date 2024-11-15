<?php

namespace App\Filament\Resources\ContactResource\Pages;

use App\Filament\Resources\ContactResource;
use Filament\Resources\Pages\CreateRecord;

class CreateContact extends CreateRecord
{
    protected static string $resource = ContactResource::class;

    protected function getRedirectUrl(): string
    {
        return route('filament.admin.resources.contacts.index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Contact has been created successfully';
    }
}
