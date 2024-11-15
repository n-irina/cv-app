<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function getRedirectUrl(): string
    {
        return route('filament.admin.resources.users.index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'User has been created successfully';
    }
}
