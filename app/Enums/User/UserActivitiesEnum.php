<?php

namespace App\Enums\User;

enum UserActivitiesEnum: string
{
    case OOO = 'OOO';
    case IP = 'IP';

    public function getLabel(): string
    {
        return self::getAllWithLabels()[$this->value];
    }

    public function getAllWithLabels(): array
    {
        return [
            self::OOO->value => 'ООО',
            self::IP->value => 'IP',
        ];
    }

    public static function getAll(): array
    {
        return [
            self::OOO,
            self::IP,
        ];
    }
}
