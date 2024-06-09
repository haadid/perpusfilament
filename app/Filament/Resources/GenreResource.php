<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GenreResource\Pages;
use App\Filament\Resources\GenreResource\RelationManagers;
use App\Models\Genre;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class GenreResource extends Resource
{
    protected static ?string $model = Genre::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationGroup = 'Komponen Buku';
    protected static ?string $label = 'Genre';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(self::getFormFields());
    }

    public static function getFormFields(): array
    {
        return [
            Forms\Components\TextInput::make('name')
                ->label('Nama Genre')
                ->required()
                ->maxLength(100)
                ->live(debounce: 300)
                ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set, ?string $old, ?string $state) {
                    if (($get('slug') ?? '') !== Str::slug($old)) {
                        return;
                    }

                    $set('slug', Str::slug($state));
                }),
            Forms\Components\TextInput::make('slug')
                ->required()
                ->readOnly()
                ->maxLength(255),
        ];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Genre')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('books_count')
                    ->label('Jumlah Buku')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat Pada')
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
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageGenres::route('/'),
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
