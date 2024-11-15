<?php

namespace App\Filament\Resources\ProspectingResource\Pages;

use App\Filament\Resources\ProspectingResource;
use App\Models\Contact;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateProspecting extends CreateRecord
{
    protected static string $resource = ProspectingResource::class;

    protected function getRedirectUrl(): string
    {
        return route('filament.admin.resources.prospectings.index');
    }

    public function mutateFormDataBeforeCreate(array $data): array
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

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Prospecting has been created successfully';
    }
}
