<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{

    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'description' => $this->faker->text,
            'price' => $this->faker->randomFloat(2, 10, 100),
            'old_price' => $this->faker->randomFloat(2, 10, 100),
            'company_id' => Company::query(),
            'sku' => function (array $attributes) {
                return $this->generateUniqueSkuForCompany($attributes['company_id']);
            }
        ];
    }

    private function generateUniqueSkuForCompany($companyId): int
    {
        do {
            $sku = str_pad(random_int(0, 99999999), 8, '0', STR_PAD_LEFT);;
        } while (Product::where('company_id', $companyId)->where('sku', $sku)->exists());

        return $sku;
    }
}
