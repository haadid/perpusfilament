<?php

namespace App\Filament\Resources;

use App\Enums\UserStatus;
use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationGroup = 'Pengunjung';
    protected static ?string $label = 'Pengguna';
    protected static ?string $navigationIcon = 'heroicon-s-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(self::getFormFields());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(self::getTableColumns())
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                Tables\Filters\SelectFilter::make('status')
                    ->options(UserStatus::class)
                    ->label('Status')
                    ->placeholder('Pilih Status'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\TransactionsRelationManager::class,
            RelationManagers\FinesRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
            'view' => Pages\ViewUser::route('/{record}'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getFormFields(): array
    {
        return [
            Forms\Components\TextInput::make('name')
                ->label('Nama')
                ->required()
                ->prefixIcon('heroicon-o-user')
                ->maxLength(255),
            Forms\Components\TextInput::make('username')
                ->maxLength(255),
            Forms\Components\TextInput::make('email')
                ->email()
                ->prefixIcon('heroicon-o-envelope')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('password')
                ->label(__('Kata Sandi'))
                ->password()
                ->required()
                ->maxLength(255),
            Forms\Components\Textarea::make('address')
                ->label(__('Alamat')),
            Forms\Components\TextInput::make('phone')
                ->label('Telepon')
                ->tel()
                ->maxLength(255),
            Forms\Components\Select::make('status')
                ->enum(UserStatus::class)
                ->options(UserStatus::class)
                ->required()
                ->default('active'),
            Forms\Components\DateTimePicker::make('email_verified_at')
                ->label('Tanggal Verifikasi Email')
                ->readOnly(),
        ];
    }

    public static function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('name')
                ->label('Nama')
//                    ->description(fn (User $record): string => Str::limit($record->address, 25))
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('username')
                ->searchable(),
            Tables\Columns\TextColumn::make('email')
                ->icon('heroicon-m-envelope')
                ->iconColor('primary')
                ->searchable(),
            Tables\Columns\TextColumn::make('phone')
                ->label('Telepon')
                ->searchable(),
            Tables\Columns\TextColumn::make('status')
                ->badge()
                ->color(fn($state) => $state->getColor())
                ->searchable(),
            Tables\Columns\TextColumn::make('email_verified_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            Tables\Columns\TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            Tables\Columns\TextColumn::make('updated_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            Tables\Columns\TextColumn::make('deleted_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }
}
