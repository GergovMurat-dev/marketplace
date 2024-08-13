<?php

namespace App\Filament\Resources\CompanyResource\Pages;

use App\Filament\Resources\CompanyResource;
use App\Filament\Resources\ProductResource;
use App\Models\Company;
use App\Models\Product;
use App\UseCases\Commands\CompanyCommandAddProduct;
use AymanAlhattami\FilamentPageWithSidebar\Traits\HasPageSidebar;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class ListCompanyProducts extends ListRecords
{
    use InteractsWithRecord, HasPageSidebar;

    protected static string $resource = CompanyResource::class;

    protected static ?string $title = 'Товары';

    /** @var Company */
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

    public function table(Table $table): Table
    {
        return ProductResource::table($table)
            ->emptyStateHeading(
                'Не найдено товаров'
            )
            ->query(
                $this->record
                    ->products()
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
            ->model(Product::class)
            ->form([
                Section::make()
                    ->columnSpan(2)
                    ->schema([
                        Grid::make()
                            ->columnSpan(2)
                            ->schema([
                                TextInput::make('name')
                                    ->translateLabel()
                                    ->required(),
                                TextInput::make('sku')
                                    ->translateLabel()
                                    ->required(),
                                TextInput::make('price')
                                    ->numeric()
                                    ->translateLabel()
                                    ->postfix('₽')
                                    ->required(),
                                TextInput::make('oldPrice')
                                    ->numeric()
                                    ->translateLabel()
                                    ->postfix('₽')
                                    ->required()
                            ]),
                        Grid::make(1)
                            ->columnSpan(2)
                            ->schema([
                                RichEditor::make('description')
                                    ->translateLabel(),
                                RichEditor::make('shortDescription')
                                    ->maxLength(255)
                                    ->translateLabel(),
                            ])
                    ])
            ])
            ->action(function (
                array                    &$data,
                CompanyCommandAddProduct $command,
                Action                   $action
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
            ->successNotificationTitle('Товар успешно создан');
    }
}
