<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use App\Filament\Resources\TransactionResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TransactionsRelationManager extends RelationManager
{
    protected static string $relationship = 'transactions';
    protected static ?string $label = 'transaksi';
    protected static ?string $title = 'Transaksi';

    public function form(Form $form): Form
    {
        return $form
            ->schema(TransactionResource::getFormFields());
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('status')
            ->columns(TransactionResource::getTableColumns())
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
