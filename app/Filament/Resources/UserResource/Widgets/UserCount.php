<?php

namespace App\Filament\Resources\UserResource\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class UserCount extends BaseWidget
{

    protected function getCards(): array
    {
        $users = User::query()->orderBy('users.id','asc')->latest()->count();
        return [
            Card::make('Users',  $users)
                ->descriptionIcon('heroicon-s-trending-up')
                ->color('success'),
        ];
    }
}
