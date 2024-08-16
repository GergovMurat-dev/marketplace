<?php

namespace App\DTO\User;

use App\Traits\ToArray;

class UserCreateDTO
{
    use ToArray;

    public function __construct(
        public string $name,
        public string $email,
        public string $password,
    )
    {
    }

    public static function make(array $data): self
    {
        return new self(
            name: $data['name'],
            email: $data['email'],
            password: $data['password'],
        );
    }
}
