<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatsOverview extends BaseWidget
{
    protected static ?string $pollingInterval = '10s';
    protected static ?int $sort = 1;
    protected function getCards(): array
    {
        return [
            Card::make('Unique views', '192.1k')
                ->description('32k increase')
                ->descriptionIcon('heroicon-s-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),
            Card::make('bonus rate', '21%')
                ->description('7% increase')
                ->descriptionIcon('heroicon-s-trending-down'),
            Card::make('Average time on page', '3:12')
                ->description('3% increase')
                ->descriptionIcon('heroicon-s-trending-up'),
        ];
    }
    // protected int | string | array $columnSpan = [
    //     'md' => 2,
    //     'xl' => 2,
    // ];
}
