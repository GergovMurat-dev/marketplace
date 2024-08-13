<?php

namespace App\Filament\Resources\CompanyResource\Pages;

use App\Filament\Resources\BrandResource;
use App\Filament\Resources\CompanyResource;
use App\Models\Company;
use App\UseCases\Commands\CompanyCommandAddBrand;
use AymanAlhattami\FilamentPageWithSidebar\Traits\HasPageSidebar;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ListCompanyBrands extends ListRecords
{
    use InteractsWithRecord, HasPageSidebar;

    protected static string $resource = CompanyResource::class;

    protected static ?string $title = 'Бренды';

    /** @var Company */
    public Model|int|string|null $record;
    public ?array $data = [];

    public function mount(): void
    {
        $this->record = Company::query()->find($this->record);
    }

    public static function getNavigationIcon(): string|Htmlable|null
    {
        return 'heroicon-o-shopping-bag';
    }

    public function getBreadcrumb(): ?string
    {
        return self::$title;
    }

    public function table(Table $table): Table
    {
        return BrandResource::table($table)
            ->emptyStateHeading(
                'Не найдено брендов'
            )
            ->query(
                $this
                    ->record
                    ->brands()
                    ->orderBy('created_at', 'desc')
                    ->getQuery()
            )
            ->headerActions([
                $this->createAction()
            ]);
    }

    private function createAction(): Action
    {
        return Action::make('Создать')
            ->form([
                Grid::make()
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
                    ]),
            ])
            ->action(function (
                array                  &$data,
                CompanyCommandAddBrand $command,
                Action                 $action,
            ) {
                $data['companyId'] = $this->record->id;

                $commandResult = $command->handle($data);

                if ($commandResult->isError) {
                    Notification::make()
                        ->warning()
                        ->title($commandResult->message)
                        ->body(implode($commandResult->errors))
                        ->duration(2000)
                        ->send();
                    $action->halt();
                }

                $action->success();
            })
            ->successNotificationTitle('Бренд успешно создан');
    }
}
