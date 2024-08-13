<?php

namespace App\Filament\Resources\CompanyResource\Pages;

use App\Filament\Resources\BrandResource;
use App\Filament\Resources\CompanyResource;
use App\Models\Brand;
use App\Models\Company;
use AymanAlhattami\FilamentPageWithSidebar\Traits\HasPageSidebar;
use Filament\Actions;
use Filament\Forms\Form;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditBrand extends EditRecord
{
    use HasPageSidebar;

    protected static string $resource = CompanyResource::class;

    protected static ?string $title = 'Редактирование бренда';

    public Brand $brand;

    public function getBreadcrumbs(): array
    {
        return [
            CompanyResource::getUrl() => 'Компании',
            CompanyResource::getUrl('brands', ['record' => $this->record->id]) => 'Бренды',
            "Редактировать"
        ];
    }

    public function mount(int|string $record): void
    {
        $this->record = Company::query()->find($record);

        $this->form->fill($this->brand->toArray());
    }

    public function getRecord(): Model
    {
        return $this->brand;
    }

    public function form(Form $form): Form
    {
        return BrandResource::form($form);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
