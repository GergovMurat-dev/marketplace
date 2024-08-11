<?php

namespace App\Enums\Product;

enum ProductStatusesEnum: string
{
    case disabled = 'disabled';
    case active = 'active';

    public function getLabel(): ?string
    {
        return self::getAllWithLabels()[$this->value];
    }

    public static function getAllWithLabels(): array
    {
        return [
            self::disabled->value => 'Не активный',
            self::active->value => 'Активный'
        ];
    }

    public static function getAll(): array
    {
        return [
            self::active->value,
            self::disabled->value
        ];
    }
}
