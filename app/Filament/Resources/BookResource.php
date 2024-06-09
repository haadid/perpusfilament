<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookResource\Pages;
use App\Filament\Resources\BookResource\RelationManagers;
use App\Models\Book;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Components\Tab;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class BookResource extends Resource
{
    protected static ?string $model = Book::class;

    protected static ?string $recordTitleAttribute = 'title';
    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $label = 'Buku';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Fieldset::make('Data Buku')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('book_code')
                            ->label('Kode Buku')
                            ->unique(ignoreRecord: true)
                            ->required()
                            ->maxLength(255)
                            ->autofocus()
                            ->reactive()
                            ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set, ?string $state) {
                                $title = $get('title');
                                if ($title) {
                                    $set('slug', Str::slug($state . '-' . $title));
                                }
                            }),
                        Forms\Components\TextInput::make('title')
                            ->label('Judul Buku')
                            ->required()
                            ->maxLength(100)
                            ->live(debounce: 250)
                            ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set, ?string $old, ?string $state) {
                                $bookCode = $get('book_code');
                                if ($bookCode) {
                                    $set('slug', Str::slug($bookCode . '-' . $state));
                                }
                            }),
                        Forms\Components\Group::make()
                            ->columns(3)
                            ->columnSpanFull()
                            ->schema([
                                Forms\Components\TextInput::make('slug')
                                    ->required()
                                    ->readOnly()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('isbn')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('year')
                                    ->label('Tahun Terbit')
                                    ->rules(['required', 'integer', 'max:' . date('Y'), 'min:1700'])
                                    ->numeric(),
                            ]),
                        Forms\Components\Textarea::make('description')
                            ->label('Deskripsi Buku')
                            ->required()
                            ->autosize()
                            ->columnSpanFull(),
                        Forms\Components\FileUpload::make('cover')
                            ->label('Cover Buku')
                            ->required()
                            ->columnSpanFull()
                            ->image()
                            ->directory('cover')
                            ->visibility('public')
                            ->imageEditor()
                    ]),
                Forms\Components\Section::make('Komponen Buku')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('genre')
                            ->prefixIcon('heroicon-s-tag')
                            ->label('Pilih Genre Buku')
                            ->multiple()
                            ->relationship('genres', 'name')
                            ->createOptionForm(fn() => GenreResource::getFormFields())
                            ->preload()
                            ->required(),
                        Forms\Components\Select::make('category')
                            ->prefixIcon('heroicon-s-hashtag')
                            ->label('Pilih Kategori Buku')
                            ->multiple()
                            ->relationship('categories', 'name')
                            ->createOptionForm(fn() => CategoryResource::getFormFields())
                            ->preload()
                            ->required(),
                        Forms\Components\Select::make('author')
                            ->prefixIcon('heroicon-s-pencil-square')
                            ->label('Pilih Penulis Buku')
                            ->multiple()
                            ->relationship('authors', 'name')
                            ->createOptionForm(fn() => AuthorResource::getFormFields())
                            ->preload()
                            ->required(),
                        Forms\Components\Select::make('publisher')
                            ->prefixIcon('heroicon-s-bookmark-square')
                            ->label('Pilih Penerbit Buku')
                            ->multiple()
                            ->relationship('publishers', 'name')
                            ->createOptionForm(fn() => PublisherResource::getFormFields())
                            ->preload()
                            ->required()
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('book_code')
                    ->label('Kode')
                    ->searchable(),
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable(),
                Tables\Columns\TextColumn::make('isbn')
                    ->label('ISBN')
                    ->placeholder('-')
                    ->searchable(),
                Tables\Columns\TextColumn::make('year')
                    ->label('Tahun')
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Deskripsi')
                    ->limit(20)
                    ->searchable(),
                Tables\Columns\TextColumn::make('genres.name')
                    ->label('Genre')
                    ->badge()
                    ->color('success'),
                Tables\Columns\TextColumn::make('categories.name')
                    ->label('Kategori')
                    ->badge()
                    ->color('info'),
                Tables\Columns\TextColumn::make('inventory.stock')
                    ->label('Stock')
                    ->sortable(),
                Tables\Columns\ImageColumn::make('cover')
                    ->disk('public'),
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
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBooks::route('/'),
            'create' => Pages\CreateBook::route('/create'),
            'edit' => Pages\EditBook::route('/{record}/edit'),
            'view' => Pages\ViewBook::route('/{record}'),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Semua Buku'),
            'semmua' => Tab::make('Buku'),
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
