<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getActions(): array
    {
        return [
            // Actions\Action::make('impersonate')->action('impersonate'),
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),

        ];
    }
    // Customizing data before filling the form
    protected function mutateFormDataBeforeFill(array $data): array
    {
        // $data['is_admin'] = false;
        return $data;
    }
    // Customizing data before saving
    protected function mutateFormDataBeforeSave(array $data): array
    {
        // $data['is_admin'] = true;
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
