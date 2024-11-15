<?php

namespace App\Filament\Resources\CvResource\Pages;

use App\Filament\Resources\CvResource;
use App\Models\Cv;
use Drenso\PdfToImage\Pdf;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateCv extends CreateRecord
{
    protected static string $resource = CvResource::class;

    protected function getRedirectUrl(): string
    {
        return route('filament.admin.resources.cvs.index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'CV has been created successfully';
    }


}
