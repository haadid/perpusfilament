<?php

namespace App\Filament\Resources;

use App\Enums\TransactionStatus;
use App\Enums\TransactionType;
use App\Filament\Resources\TransactionResource\Pages;
use App\Filament\Resources\TransactionResource\RelationManagers;
use App\Filament\Resources\UserResource\RelationManagers\TransactionsRelationManager;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;
    protected static ?string $navigationGroup = 'Peminjaman Buku';
    protected static ?string $label = 'Transaksi';
    protected static ?int $navigationSort = 1;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';

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
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
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
            Forms\Components\Select::make('user_id')
                ->label('Nama')
                ->relationship('user', 'name')
                ->hiddenOn(TransactionsRelationManager::class)
                ->searchable()
                ->preload()
                ->required(),
            Forms\Components\Select::make('book_id')
                ->label('Buku')
                ->relationship('book', 'title')
                ->searchable()
                ->preload()
                ->required(),
            Forms\Components\DateTimePicker::make('requested_at')
                ->default(now())
                ->required(),
            Forms\Components\DateTimePicker::make('borrowed_at')
                ->default(now()),
            Forms\Components\DateTimePicker::make('due_at'),
            Forms\Components\DateTimePicker::make('returned_at'),
            Forms\Components\Select::make('status')
                ->enum(TransactionStatus::class)
                ->options(TransactionStatus::class)
                ->required(),
            Forms\Components\Select::make('type')
                ->enum(TransactionType::class)
                ->options(TransactionType::class)
                ->required(),
            Forms\Components\Textarea::make('reason')
                ->columnSpanFull(),
            Forms\Components\Select::make('original_transaction_id')
                ->hidden(true)
                ->relationship('originalTransaction', 'id'),
        ];
    }

    public static function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('user.name')
                ->label('Nama')
                ->hiddenOn(TransactionsRelationManager::class)
                ->numeric()
                ->sortable(),
            Tables\Columns\TextColumn::make('book.title')
                ->label('Judul')
                ->numeric()
                ->sortable(),
            Tables\Columns\TextColumn::make('requested_at')
                ->label('Tanggal Permintaan')
                ->dateTime()
                ->sortable(),
            Tables\Columns\TextColumn::make('borrowed_at')
                ->label('Tanggal Peminjaman')
                ->placeholder(TransactionStatus::PENDING->value)
                ->dateTime()
                ->sortable(),
            Tables\Columns\TextColumn::make('due_at')
                ->label('Tanggal Tenggat')
                ->placeholder(fn (Transaction $record) => $record->status->getLabel())
                ->color(TransactionStatus::BORROWED->getColor())
                ->dateTime()
                ->sortable(),
            Tables\Columns\TextColumn::make('returned_at')
                ->label('Tanggal Pengembalian')
                // if not borrowed yet, get pending, if borrowed, get borrowed, if returned, get returned
                ->placeholder(fn (Transaction $transaction) => $transaction->status->getLabel())
                ->dateTime()
                ->sortable(),
            Tables\Columns\TextColumn::make('status')
                ->searchable(),
            Tables\Columns\TextColumn::make('type')
                ->label('Jenis')
                ->searchable(),
            Tables\Columns\TextColumn::make('originalTransaction.id')
                ->hidden(true)
                ->numeric()
                ->sortable(),
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
