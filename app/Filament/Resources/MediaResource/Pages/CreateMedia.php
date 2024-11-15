<?php

namespace App\Filament\Resources\MediaResource\Pages;

use App\Filament\Resources\MediaResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMedia extends CreateRecord
{
    protected static string $resource = MediaResource::class;

    protected function getRedirectUrl(): string
    {
        return route('filament.admin.resources.media.index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Media has been created successfully';
    }

    // public function mutateFormDataBeforeCreate(array $data): array
    // {


    //     $pdfPath = storage_path('app/public/' . $data['media_path'][0]);


    //     if (!file_exists($pdfPath)) {
    //         abort(404, 'PDF non trouvé.');
    //     }

    //     $pdf = new Pdf($pdfPath);


    //     $imagePath = storage_path('app/public/thumbnails/' . $data['type'] . Auth::id() . '.jpg');

    //     $image = 'thumbnails/' . $data['type'] . Auth::id() . '.jpg';

    //     $data['imagePath'] = $image;

    //     $pdf->saveImage($imagePath);

    //     return $data;
    // }
}
