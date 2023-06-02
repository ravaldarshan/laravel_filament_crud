<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Closure;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class LatestUsers extends BaseWidget
{
    protected function getTableQuery(): Builder
    {
        return User::query()->orderBy('users.id','asc')->latest();
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\ImageColumn::make('profile_photo_path'),
            Tables\Columns\TextColumn::make('name')->sortable()->searchable(),
                Tables\Columns\IconColumn::make('is_admin')
                    ->boolean(),
                Tables\Columns\TextColumn::make('roles.name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('email')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('email_verified_at')
                    ->dateTime('d-M-Y'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d-M-Y')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime('d-M-Y')
        ];
    }
}
