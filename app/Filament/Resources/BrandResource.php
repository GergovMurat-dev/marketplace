<?php

namespace App\Filament\Resources;

use App\Models\Brand;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class BrandResource extends Resource
{
    protected static ?string $model = Brand::class;

    protected static ?string $pluralModelLabel = 'Бренды';

    protected static ?string $modelLabel = 'Бренд';

    protected static ?string $label = 'Бренд';

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $pluralLabel = 'Бренд';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->translateLabel()
                    ->live(
                        onBlur: true
                    )
                    ->afterStateUpdated(function (string $state, Set $set) {
                        $set('slug', Str::slug($state));
                    }),

                TextInput::make('slug')
                    ->disabled()
                    ->dehydrated()
                    ->required()
                    ->translateLabel()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->translateLabel(),
                TextColumn::make('slug')
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->url(function (Brand $record) {
                        return CompanyResource::getUrl('brand-edit', [
                            'record' => $record->company_id,
                            'brand' => $record->id,
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
