<?php

namespace App\Filament\Resources\ContractResource\Pages;

use App\Filament\Resources\ContractResource;
use App\Models\Contact;
use Filament\Resources\Pages\CreateRecord;

class CreateContract extends CreateRecord
{
    protected static string $resource = ContractResource::class;

    protected function getRedirectUrl(): string
    {
        return route('filament.admin.resources.contracts.index');
    }

    public function mutateFormDataBeforeCreate(array $data): array
    {

        $contacts = Contact::whereIn('id', $data['signatories'])->get();


        $data['signatories'] = $contacts->map(function ($contact) {
            $label = "{$contact->lastname} {$contact->firstname}";
            if (!empty($contact->email)) {
                $label .= " ({$contact->email})";
            }
            return $label;
        })->implode(', ');

        return $data;
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Contract has been created successfully';
    }
}
