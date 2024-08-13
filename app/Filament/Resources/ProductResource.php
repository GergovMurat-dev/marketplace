<?php

namespace App\Filament\Resources;

use App\Enums\Product\ProductStatusesEnum;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    protected static ?string $pluralModelLabel = 'Товары';

    protected static ?string $modelLabel = 'товар';

    protected static ?string $navigationGroup = 'Платформа';

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
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
                                    ->numeric()
                                    ->translateLabel()
                                    ->postfix('₽'),
                                TextInput::make('old_price')
                                    ->numeric()
                                    ->translateLabel()
                                    ->postfix('₽'),
                                Grid::make(1)
                                    ->columnSpan(1)
                                    ->schema([
                                        Select::make('categories')
                                            ->translateLabel()
                                            ->multiple()
                                            ->required(fn(Get $get) => $get('status') !== ProductStatusesEnum::disabled->value)
                                            ->native(false)
                                            ->relationship(
                                                name: 'categories',
                                            )
                                            ->options(function (Product $record) {
                                                $result = [];

                                                Category::query()
                                                    ->where('company_id', $record->company_id)
                                                    ->get()
                                                    ->each(function (Category $category) use (&$result) {
                                                        $result[$category->name] = $category
                                                            ->children()
                                                            ->pluck('name', 'id')
                                                            ->toArray();
                                                    });

                                                return $result;
                                            }),
                                        Select::make('brand')
                                            ->translateLabel()
                                            ->native(false)
                                            ->relationship(
                                                name: 'brand',
                                            )
                                            ->options(function (Product $record) {
                                                return Brand::query()
                                                    ->where('company_id', $record->company_id)
                                                    ->get()
                                                    ->pluck('name', 'id');
                                            })
                                    ]),
                                Select::make('status')
                                    ->native(false)
                                    ->translateLabel()
                                    ->required()
                                    ->options(
                                        ProductStatusesEnum::getAllWithLabels()
                                    )
                                    ->required()
                                    ->live()
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
            ->recordUrl(null)
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->translateLabel()
                    ->searchable(),
                Tables\Columns\TextColumn::make('sku')
                    ->label('SKU')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->sortable()
                    ->translateLabel()
                    ->money('rub'),
                Tables\Columns\TextColumn::make('categories.name')
                    ->translateLabel()
                    ->badge(),
                Tables\Columns\TextColumn::make('brand.name')
                    ->translateLabel()
                    ->searchable()
                    ->badge(),
                Tables\Columns\IconColumn::make('status')
                    ->translateLabel()
                    ->icon(fn(ProductStatusesEnum $state): string => match ($state) {
                        ProductStatusesEnum::active => 'heroicon-o-eye',
                        ProductStatusesEnum::disabled => 'heroicon-o-eye-slash',
                        default => '',
                    })
                    ->color(fn(ProductStatusesEnum $state): string => match ($state) {
                        ProductStatusesEnum::active => 'success',
                        ProductStatusesEnum::disabled => 'warning',
                        default => '',
                    })
            ])
            ->filters([
                SelectFilter::make('status')
                    ->translateLabel()
                    ->multiple()
                    ->options(ProductStatusesEnum::getAllWithLabels())
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->url(function (Product $record) {
                        return CompanyResource::getUrl('product-edit', [
                            'record' => $record->company_id,
                            'product' => $record->id,
                        ]);
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
