<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FineResource\Pages;
use App\Filament\Resources\FineResource\RelationManagers;
use App\Filament\Resources\UserResource\RelationManagers\FinesRelationManager;
use App\Models\Fine;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FineResource extends Resource
{
    protected static ?string $model = Fine::class;
    protected static ?string $navigationGroup = 'Peminjaman Buku';
    protected static ?int $navigationSort = 2;
    protected static ?string $label = 'Denda';
    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(self::getFieldForms());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(self::getTableColumns())
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFines::route('/'),
            'create' => Pages\CreateFine::route('/create'),
            'edit' => Pages\EditFine::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getFieldForms(): array
    {
        return [
            Forms\Components\Select::make('user_id')
                ->label('Nama')
                ->relationship('user', 'name')
                ->searchable()
                ->preload()
                ->required(),
            Forms\Components\Select::make('book_id')
                ->label('Buku')
                ->relationship('book', 'title')
                ->searchable()
                ->preload()
                ->required(),
            Forms\Components\DateTimePicker::make('issued_at')
                ->label('Dikeluarkan')
                ->default(date(now()))
                ->required(),
            Forms\Components\TextInput::make('amount')
                ->label('Jumlah')
                ->prefix('Rp')
                ->mask(RawJs::make('$money($input)'))
                ->required(),
            Forms\Components\Select::make('original_fine_id')
                ->hidden()
                ->relationship('originalFine', 'id'),
            Forms\Components\DateTimePicker::make('paid_at'),
            Forms\Components\Textarea::make('reason')
                ->label('Alasan')
                ->required(),
            Forms\Components\Toggle::make('is_paid')
                ->label('Sudah Dibayar?')
                ->hiddenOn(FinesRelationManager::class)
                ->required()
        ];
    }

    public static function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('user.name')
                ->label('Nama')
                ->numeric()
                ->hiddenOn(FinesRelationManager::class)
                ->sortable(),
            Tables\Columns\TextColumn::make('book.title')
                ->label('Buku')
                ->numeric()
                ->sortable(),
            Tables\Columns\TextColumn::make('issued_at')
                ->label('Dikeluarkan')
                ->dateTime()
                ->sortable(),
            Tables\Columns\TextColumn::make('amount')
                ->label('Jumlah')
                ->prefix('Rp')
                ->suffix(',-')
                ->numeric()
                ->sortable(),
            Tables\Columns\IconColumn::make('is_paid')
                ->label('Terbayar?')
                ->boolean(),
            Tables\Columns\TextColumn::make('paid_at')
                ->label('Dibayar Pada')
                ->placeholder('Belum Dibayar')
                ->dateTime()
                ->sortable(),
            Tables\Columns\TextColumn::make('originalFine.id')
                ->numeric()
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
