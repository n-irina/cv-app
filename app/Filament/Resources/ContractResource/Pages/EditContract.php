<?php

namespace App\Filament\Resources\ContractResource\Pages;

use App\Filament\Resources\ContractResource;
use App\Models\Contact;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditContract extends EditRecord
{
    protected static string $resource = ContractResource::class;

    protected function getRedirectUrl(): string
    {
        return route('filament.admin.resources.contracts.index');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    public function mutateFormDataBeforeSave(array $data): array
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

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Contract has been modified successfully';
    }
}
