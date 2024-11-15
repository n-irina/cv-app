<?php

namespace App\Filament\Resources\ProspectingResource\Pages;

use App\Filament\Resources\ProspectingResource;
use App\Models\Contact;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditProspecting extends EditRecord
{
    protected static string $resource = ProspectingResource::class;

    protected function getRedirectUrl(): string
    {
        return route('filament.admin.resources.prospectings.index');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    public function mutateFormDataBeforeSave(array $data): array
    {

        $contacts = Contact::whereIn('id', $data['contacts'])->get();

        $data['contacts'] = $contacts->map(function ($contact) {
            $label = "{$contact->lastname} {$contact->firstname}";
            if (!empty($contact->email)) {
                $label .= " ({$contact->email})";
            }
            return $label;
        })->implode(', ');

        $data['createdBy'] = Auth::user()->name;

        return $data;
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Prospecting has been modified successfully';
    }
}
