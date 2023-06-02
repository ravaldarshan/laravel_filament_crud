<?php

namespace App\Providers;

use App\Filament\Resources\UserResource;
use Filament\Facades\Filament;
use Filament\Navigation\UserMenuItem;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Vite;

class FilamentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
        Filament::serving(function() {
            Filament::registerViteTheme('resources/css/filament.css');
            if(auth()->user() && auth()->user()->is_admin === 1 && auth()->user()->hasAnyRole(['super-admin','admin', 'moderator'])){
                Filament::registerUserMenuItems([
                    UserMenuItem::make()
                    ->label('Manage User')
                    ->url(UserResource::getUrl())
                    ->icon('heroicon-o-user-group')
                ]);
            }
        });
    }
}
