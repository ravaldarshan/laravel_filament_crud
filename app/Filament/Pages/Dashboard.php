<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BasePage;

use Closure;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Route;

class Dashboard extends BasePage
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static ?int $navigationSort = -2;

    // protected function getHeaderWidgets(): array
    // {
    //     return [
    //         StatsOverviewWidget::class
    //     ];
    // }

    // protected static string $view = 'filament::pages.dashboard';

    // protected static function getNavigationLabel(): string
    // {
    //     return static::$navigationLabel ?? static::$title ?? __('filament::pages/dashboard.title');
    // }

    // public static function getRoutes(): Closure
    // {
    //     return function () {
    //         Route::get('/', static::class)->name(static::getSlug());
    //     };
    // }

    // protected function getWidgets(): array
    // {
    //     return Filament::getWidgets();
    // }

    // protected function getColumns(): int | string | array
    // {
    //     return 2;
    // }

    // protected function getTitle(): string
    // {
    //     return static::$title ?? __('filament::pages/dashboard.title');
    // }
}
