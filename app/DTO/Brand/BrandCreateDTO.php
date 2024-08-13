<?php

namespace App\DTO\Brand;

use App\Traits\ToArray;

class BrandCreateDTO
{
    use ToArray;

    public function __construct(
        public string $name,
        public string $slug,
        public int    $companyId,
    )
    {
    }

    public static function make(array $data): self
    {
        return new self(
            $data['name'],
            $data['slug'],
            $data['companyId']
        );
    }
}
