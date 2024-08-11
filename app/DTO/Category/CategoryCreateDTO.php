<?php

namespace App\DTO\Category;

use App\Traits\ToArray;

class CategoryCreateDTO
{
    use ToArray;

    public function __construct(
        public string $name,
        public string $slug,
        public int    $companyId
    )
    {
    }

    public static function make(array $data): self
    {
        return new self(
            name: $data['name'],
            slug: $data['slug'],
            companyId: $data['companyId']
        );
    }
}
