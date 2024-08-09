<?php

namespace App\Filament\Resources\CompanyResource\Pages;

use App\Filament\Resources\CompanyResource;
use App\Filament\Resources\ProductResource;
use App\Models\Company;
use App\Models\Product;
use AymanAlhattami\FilamentPageWithSidebar\Traits\HasPageSidebar;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ListCompanyProducts extends ListRecords
{
    use InteractsWithRecord, HasPageSidebar;

    protected static string $resource = CompanyResource::class;

    protected static ?string $title = 'Товары';

    public string|int|null|Model $record;
    public ?array $data = [];

    public function mount(): void
    {
        $this->record = Company::query()->find($this->record);
    }

    public function getBreadcrumb(): ?string
    {
        return self::$title;
    }

    protected function getTableQuery(): ?Builder
    {
        return Product::query()
            ->where('company_id', $this->record->id);
    }

    public function table(Table $table): Table
    {
        return ProductResource::table($table);
    }
}
