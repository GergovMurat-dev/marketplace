<?php

namespace App\Filament\Resources\CompanyResource\Pages;

use App\Filament\Resources\CategoryResource;
use App\Filament\Resources\CompanyResource;
use App\Models\Company;
use AymanAlhattami\FilamentPageWithSidebar\Traits\HasPageSidebar;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;

class ListCompanyCategories extends ListRecords
{
    use InteractsWithRecord, HasPageSidebar;

    protected static string $resource = CompanyResource::class;

    protected static ?string $title = 'Категории';

    /** @var Company */
    public string|int|null|Model $record;
    public ?array $data = [];

    public function mount(): void
    {
        $this->record = Company::query()->find($this->record);
    }

    public static function getNavigationIcon(): string|Htmlable|null
    {
        return 'heroicon-o-tag';
    }

    public function getBreadcrumb(): ?string
    {
        return self::$title;
    }

    public function table(Table $table): Table
    {
        return CategoryResource::table($table)
            ->query(
                $this->record->categories()->getQuery()
            );
    }
}
