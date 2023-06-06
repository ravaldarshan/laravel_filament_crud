<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Pages\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Str;

class ViewTest extends ViewRecord
{
    protected static string $resource = UserResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),

            Action::make('update user')
                ->action(function (array $data): void {
                    // dump($data);
                    // dd($this);
                    $this->record->name = $data['name'];
                    $this->record->email = $data['email'];
                    $this->record->is_admin = $data['is_admin'];
                    $this->record->save();
                    $this->refreshFormData([
                        'name',
                        'email',
                        'is_admin'
                    ]);
                })
                ->form([
                    TextInput::make('name')
                        ->required(),
                    TextInput::make('email')
                        ->email()
                        ->required()
                        ->maxLength(191),
                    Toggle::make('is_admin')
                        ->required(),
                ]),
        ];
    }
}
