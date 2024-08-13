<?php

namespace App\DTO\Product;

use App\Traits\ToArray;

class ProductCreateDTO
{
    use ToArray;

    public function __construct(
        public string  $name,
        public string  $sku,
        public int     $companyId,
        public array   $categoryIds,
        public ?int    $brandId = null,
        public ?string $description = null,
        public ?string $shortDescription = null,
        public ?int    $price = null,
        public ?int    $oldPrice = null,
    )
    {
    }

    public static function make(array $data): self
    {
        return new self(
            name: $data['name'],
            sku: $data['sku'],
            companyId: $data['companyId'],
            categoryIds: $data['categoryIds'],
            brandId: $data['brandId'] ?? null,
            description: $data['description'] ?? null,
            shortDescription: $data['shortDescription'] ?? null,
            price: $data['price'] ?? null,
            oldPrice: $data['oldPrice'] ?? null
        );
    }
}
