<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\Pages\CreateUser;
use App\Filament\Resources\UserResource\Pages\EditUser;
use App\Filament\Resources\UserResource\Widgets\UserCount;
use App\Filament\Resources\UsersResource\RelationManagers\RolesRelationManager;
use App\Models\User;
use Filament\Forms;
use Filament\Pages\Page;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Filters\TrashedFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{

    // model
    protected static ?string $model = User::class;

    // navigation icon
    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    // navigation Group
    protected static ?string $navigationGroup = 'Admin Management';

    // navigation elenments
    protected static ?int $navigationSort = 1;

    // custumization model lebel
    protected static ?string $modelLabel = 'Users';

    // change page url
    protected static ?string $slug = 'users';

    // for globel serch
    protected static ?string $recordTitleAttribute = 'name';


    // protected static bool $shouldRegisterNavigation = false;

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'email' => $record->name,
            'is_admin' => $record->is_admin === 1 ? 'true' : 'false',
        ];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(191),
                Forms\Components\Toggle::make('is_admin')
                    ->required(),

                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(191),
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
                Forms\Components\CheckboxList::make('roles')
                    ->relationship('roles', 'name')
                    ->columns(2)
                    ->helperText('only choose one!')
                    ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
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
            ])
            ->filters([
                TrashedFilter::make(),
                Tables\Filters\Filter::make('verified')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('email_verified_at')),
                Tables\Filters\Filter::make('Admin')
                    ->query(fn (Builder $query): Builder => $query->where('is_admin', 1)),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->before(function () {
                        // dump('test');
                    })
                    ->after(function () {
                        // dump('test');
                    }),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
                Tables\Actions\Action::make('Make as admin')
                    ->action(fn (User $record) => $record->is_admin())
                    ->requiresConfirmation()
                    ->color('success'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\ForceDeleteBulkAction::make(),
                Tables\Actions\RestoreBulkAction::make(),
            ]);
    }
    public function hasCombinedRelationManagerTabsWithForm(): bool
    {
        return true;
    }
    public static function getRelations(): array
    {
        return [
            RolesRelationManager::class,
        ];
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewTest::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
            'sort' => Pages\SortUsers::route('/sort'),
        ];
    }
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
