<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use App\Filament\Resources\FineResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FinesRelationManager extends RelationManager
{
    protected static string $relationship = 'fines';
    protected static ?string $label = 'Denda';
    protected static ?string $title = 'Denda';

    public function form(Form $form): Form
    {
        return $form
            ->schema(FineResource::getFieldForms());
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('user_id')
            ->columns(FineResource::getTableColumns())
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
