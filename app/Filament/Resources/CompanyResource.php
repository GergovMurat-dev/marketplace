<?php

namespace App\Filament\Resources;

use App\Enums\User\UserCompanyTypesEnum;
use App\Filament\Resources\CompanyResource\Pages;
use App\Models\Company;
use AymanAlhattami\FilamentPageWithSidebar\FilamentPageSidebar;
use AymanAlhattami\FilamentPageWithSidebar\PageNavigationItem;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CompanyResource extends Resource
{
    protected static ?string $model = Company::class;

    protected static ?string $pluralModelLabel = 'Компании';

    protected static ?string $navigationGroup = 'Платформа';

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Компания')
                    ->schema([
                        Grid::make()
                            ->schema([
                                TextInput::make('name')
                                    ->required()
                                    ->translateLabel(),
                                Select::make('type')
                                    ->options(UserCompanyTypesEnum::getAllWithLabels())
                                    ->required()
                                    ->translateLabel()
                            ])
                    ]),
                Fieldset::make('Владелец')
                    ->relationship('user')
                    ->schema([
                        Grid::make()
                            ->schema([
                                TextInput::make('email')
                                    ->unique(ignoreRecord: true)
                                    ->required(),
                                TextInput::make('name')
                                    ->label('ФИО')
                                    ->required()
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
                Tables\Columns\TextColumn::make('type')
                    ->translateLabel()
                    ->formatStateUsing(fn(UserCompanyTypesEnum $state) => $state->getLabel())
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Подробнее')
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
            'index' => Pages\ListCompanies::route('/'),
            'create' => Pages\CreateCompany::route('/create'),
            'edit' => Pages\EditCompany::route('/{record}/edit'),
            'products' => Pages\ListCompanyProducts::route('/{record}/products'),
            'product-edit' => Pages\EditProduct::route('/{record}/products/{product}/edit'),
            'categories' => Pages\ListCompanyCategories::route('/{record}/categories'),
            'category-edit' => Pages\EditCategory::route('/{record}/categories/{category}/edit'),
        ];
    }

    public static function sidebar(Company $record): FilamentPageSidebar
    {
        return FilamentPageSidebar::make()
            ->sidebarNavigation()
            ->setNavigationItems([
                PageNavigationItem::make('Редактировать')
                    ->icon(Pages\EditCompany::getNavigationIcon())
                    ->isActiveWhen(fn() => request()->routeIs(Pages\EditCompany::getRouteName()))
                    ->url(fn() => static::getUrl('edit', ['record' => $record->id])),
                PageNavigationItem::make('Товары')
                    ->icon(Pages\EditProduct::getNavigationIcon())
                    ->isActiveWhen(fn() => request()->routeIs(Pages\ListCompanyProducts::getRouteName(), Pages\EditProduct::getRouteName()))
                    ->url(fn() => static::getUrl('products', ['record' => $record->id])),
                PageNavigationItem::make('Категории')
                    ->icon(Pages\ListCompanyCategories::getNavigationIcon())
                    ->isActiveWhen(fn() => request()->routeIs(Pages\ListCompanyCategories::getRouteName()))
                    ->url(fn() => static::getUrl('categories', ['record' => $record->id])),
            ]);
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
