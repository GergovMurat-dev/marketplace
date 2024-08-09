<?php

namespace App\Enums\User;

enum UserCompanyTypesEnum: string
{
    case OOO = 'OOO';
    case IP = 'IP';
    case SAMOZANYATYY = 'SAMOZANYATYY';

    public function getLabel(): string
    {
        return self::getAllWithLabels()[$this->value];
    }

    public static function getAllWithLabels(): array
    {
        return [
            self::OOO->value => 'ООО',
            self::IP->value => 'ИП',
            self::SAMOZANYATYY->value => 'Самозанятый'
        ];
    }

    public static function getAll(): array
    {
        return [
            self::OOO,
            self::IP,
            self::SAMOZANYATYY
        ];
    }
}
