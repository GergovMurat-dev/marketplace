<?php

namespace App\Filament\Resources\CompanyResource\Pages;

use App\Filament\Resources\CompanyResource;
use App\Filament\Resources\ProductResource;
use App\Models\Company;
use App\Models\Product;
use AymanAlhattami\FilamentPageWithSidebar\Traits\HasPageSidebar;
use Filament\Actions;
use Filament\Forms\Form;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;

class EditProduct extends EditRecord
{
    use HasPageSidebar;

    protected static string $resource = CompanyResource::class;

    protected static ?string $title = 'Редактирование товара';

    public Product $product;

    public static function getNavigationIcon(): string|Htmlable|null
    {
        return 'heroicon-o-shopping-cart';
    }

    public function getBreadcrumbs(): array
    {
        return [
            CompanyResource::getUrl() => 'Компании',
            CompanyResource::getUrl('products', ['record' => $this->record->id]) => 'Товары',
            "Редактировать"
        ];
    }

    public function mount(int|string $record): void
    {
        $this->record = Company::query()->find($record);

        $this->form->fill($this->product->toArray());
    }

    public function getRecord(): Model
    {
        return $this->product;
    }

    public function getRecordTitle(): string|Htmlable
    {
        return 'товар';
    }

    public function form(Form $form): Form
    {
        return ProductResource::form($form);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
