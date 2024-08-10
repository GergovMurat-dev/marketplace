<?php

namespace App\Filament\Resources\CompanyResource\Pages;

use App\Filament\Resources\CategoryResource;
use App\Filament\Resources\CompanyResource;
use App\Models\Category;
use App\Models\Company;
use AymanAlhattami\FilamentPageWithSidebar\Traits\HasPageSidebar;
use Filament\Actions;
use Filament\Forms\Form;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;

class EditCategory extends EditRecord
{
    use HasPageSidebar;

    protected static string $resource = CompanyResource::class;

    protected static ?string $title = 'Редактирование категории';

    public Category $category;

    public static function getNavigationIcon(): string|Htmlable|null
    {
        return 'heroicon-o-tag';
    }

    public function getBreadcrumbs(): array
    {
        return [
            CompanyResource::getUrl() => 'Компании',
            CompanyResource::getUrl('categories', ['record' => $this->record->id]) => 'Категории',
            "Редактировать"
        ];
    }

    public function mount(int|string $record): void
    {
        $this->record = Company::query()->find($record);

        $this->form->fill($this->category->toArray());
    }

    public function getRecord(): Model
    {
        return $this->category;
    }

    public function form(Form $form): Form
    {
        return CategoryResource::form($form);
    }

    public function getRelationManagers(): array
    {
        return [
            CategoryResource\RelationManagers\ChildrenRelationManager::make(['ownerRecord' => $this->category])
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
