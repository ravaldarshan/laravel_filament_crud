<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Filament\Resources\UserResource\Widgets\UserCount;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Pages\Actions;
use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Illuminate\View\View;
use Illuminate\Support\Str;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    //custume page
    // protected static string $view = 'filament.resources.users.pages.list-users';

    // custume tabel html
    // public function getTableContent(): ?View
    // {
    //     return view('filament.resources.users.pages.list-users');
    // }



    protected function getActions(): array
    {
        return [
            Action::make('updateAuthor')
                ->action(function (array $data): void {
                    $this->record->author()->associate($data['name']);
                    $this->record->save();
                    dump($data);
                    dd($this);
                })
                ->form([
                    TextInput::make('name')
                        ->required()
                        ->reactive()
                        ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),
                    TextInput::make('slug')
                        ->required()
                        ->maxLength(191),
                    TextInput::make('email')
                        ->email()
                        ->required()
                        ->maxLength(191),
                    Toggle::make('is_admin')
                        ->required(),
                ]),
            Action::make('settings')
                ->label('Settings')
                ->action('openSettingsModal')
                ->icon('heroicon-s-cog')
                ->requiresConfirmation(),
            Action::make('Open model')
                ->action(fn () => $this->record->advance())
                // ->modalHidden(fn (): bool => $this->role !== 'admin')
                ->modalContent(
                    view('filament.settings.custom-header')
                ),
            Actions\CreateAction::make()
                ->successNotification(
                    Notification::make()
                        ->success()
                        ->title('User registered')
                        ->body('The user has been created successfully.'),
                ),
        ];
    }

    // custum action
    public static function openSettingsModal(): void
    {
        dd('thanks');
    }

    protected function getHeaderWidgets(): array
    {
        return [
            UserCount::class,
        ];
    }

    //custume Header
    //  protected function getHeader(): View
    //  {
    //      return view('filament.settings.custom-header');
    //  }

    //  //custume footer
    //  protected function getFooter(): View
    //  {
    //      return view('filament.settings.custom-header');
    //  }

    public function mount(): void
    {
        abort_unless(auth()->user()->can('read: user'), 403);
    }
}
