<?php

namespace App\Filament\Resources\MediaResource\Pages;

use App\Filament\Resources\MediaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMedia extends EditRecord
{
    protected static string $resource = MediaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return route('filament.admin.resources.media.index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Media has been modified successfully';
    }

    // public function mutateFormDataBeforeSave(array $data): array
    // {
    //     $pdfPath = storage_path('app/public/' . $data['media_path'][0]);
    //     $imagePath = storage_path('app/public/thumbnails/' . Auth::id() . '.jpg');



    //     $data['imagePath'] = 'thumbnails/' . Auth::id() . '.jpg';

    //     return $data;


    // }
}
