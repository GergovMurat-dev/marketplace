<?php

namespace App\Filament\Resources\CompanyResource\Pages;

use App\Filament\Resources\CompanyResource;
use AymanAlhattami\FilamentPageWithSidebar\Traits\HasPageSidebar;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;

class EditCompany extends EditRecord
{
    use HasPageSidebar;

    protected static ?string $title = 'Редактирование компании';

    protected static string $resource = CompanyResource::class;

    public function getRecordTitle(): string|Htmlable
    {
        return 'компанию';
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
