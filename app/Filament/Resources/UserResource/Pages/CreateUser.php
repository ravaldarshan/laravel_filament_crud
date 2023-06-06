<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard\Step;
use Filament\Resources\Pages\CreateRecord;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Toggle;
use Illuminate\Support\Str;
use Filament\Forms;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Hash;

class CreateUser extends CreateRecord
{
    use CreateRecord\Concerns\HasWizard;
    protected static string $resource = UserResource::class;

    protected function getSteps(): array
    {
        return [
            Step::make('Name')
                ->description('Add user name and email')
                ->schema([
                    TextInput::make('name')
                        ->required()
                        ->reactive()
                        ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),
                    Forms\Components\TextInput::make('slug')
                        ->required()
                        ->maxLength(191),
                    Forms\Components\TextInput::make('email')
                        ->email()
                        ->required()
                        ->maxLength(191),
                    Forms\Components\Toggle::make('is_admin')
                        ->required(),
                ]),
            Step::make('Profile')
                ->description('Add profile Pic and password ')
                ->schema([
                    Forms\Components\FileUpload::make('profile_photo_path')
                        ->image()
                        ->label('Profile Pic')
                        ->directory('profile_pic')
                        ->disk('public')
                        ->imagePreviewHeight('200')
                        ->enableOpen()
                        ->minSize(1)
                        ->maxSize(1024),
                    Forms\Components\TextInput::make('password')
                        ->password()
                        ->maxLength(191)
                        ->hiddenOn('edit')
                        ->dehydrateStateUsing(static fn (null|string $state): null|string => filled($state) ? Hash::make($state) : null)
                        ->dehydrated(static fn (null|string $state): bool => filled($state))
                        ->required(static fn (Page $livewire): string => $livewire instanceof CreateUser)
                        ->label(static fn (Page $livewire): string => ($livewire instanceof EditUser) ? 'New Password' : 'Password'),
                ]),
            Step::make('Role')
                ->description('Assgin the role')
                ->schema([
                    Forms\Components\CheckboxList::make('roles')
                        ->relationship('roles', 'name')
                        ->columns(2)
                        ->helperText('only choose one!')
                        ->required(),
                ]),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'User registered';
    }


    //lifecical hook
    protected function beforeFill(): void
    {
        // dump('beforeFill');
        // Runs before the form fields are populated with their default values.
    }

    protected function afterFill(): void
    {
        // dump('afterFill');
        // Runs after the form fields are populated with their default values.
    }

    protected function beforeValidate(): void
    {
        //  dump('beforeValidate');
        //  $tast = array(
        //     'test'=> 'testtext',
        //  );
        //  $this->data = array_merge($this->data, $tast);
        //  dd($this->data);
        // Runs before the form fields are validated when the form is submitted.
    }

    protected function afterValidate(): void
    {
        //  dump('afterValidate');
        // Runs after the form fields are validated when the form is submitted.
    }

    protected function beforeCreate(): void
    {
        //  dump('beforeCreate');
        // Runs before the form fields are saved to the database.
    }

    protected function afterCreate(): void
    {
        //  dump('afterCreate');
        // Runs after the form fields are saved to the database.
    }
}
