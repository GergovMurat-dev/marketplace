<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $pluralModelLabel = 'Товары';

    protected static ?string $modelLabel = 'товар';

    protected static ?string $navigationGroup = 'Платформа';

    public static function form(Form $form): Form
    {
        return $form
            ->columns(3)
            ->schema([
                Section::make()
                    ->columnSpan(2)
                    ->schema([
                        Grid::make()
                            ->columnSpan(2)
                            ->schema([
                                TextInput::make('name')
                                    ->translateLabel(),
                                TextInput::make('sku')
                                    ->translateLabel(),
                                TextInput::make('price')
                                    ->translateLabel()
                                    ->postfix('₽'),
                                TextInput::make('old_price')
                                    ->translateLabel()
                                    ->postfix('₽')
                            ]),
                        Grid::make(1)
                            ->columnSpan(2)
                            ->schema([
                                RichEditor::make('description')
                                    ->translateLabel(),
                                RichEditor::make('short_description')
                                    ->maxLength(255)
                                    ->translateLabel(),
                            ])
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->translateLabel()
                    ->searchable(),
                Tables\Columns\TextColumn::make('sku')
                    ->label('SKU')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->translateLabel()
                    ->money('rub')
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}