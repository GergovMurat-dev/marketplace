<?php

namespace App\Enums\User;

enum UserTypesEnum: string
{
    case admin = 'admin';
    case seller = 'seller';
    case buyer = 'buyer';

    public function getLabel(): string
    {
        return self::getAllWithLabel()[$this->value];
    }

    public static function getAllWithLabel(): array
    {
        return [
            self::admin->value => 'Администратор',
            self::buyer->value => 'Покупатель',
            self::seller->value => 'Продавец'
        ];
    }

    public static function getAll(): array
    {
        return [
            self::admin->value,
            self::buyer->value,
            self::seller->value
        ];
    }

    public static function hasAccessPanel(): array
    {
        return [
            self::admin,
            self::seller,
        ];
    }
}
