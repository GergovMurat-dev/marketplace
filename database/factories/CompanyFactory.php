<?php

namespace Database\Factories;

use App\Enums\User\UserCompanyTypesEnum;
use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Company>
 */
class CompanyFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'name' => $this->faker->company(),
            'type' => $this->faker->randomElement(UserCompanyTypesEnum::getAll())
        ];
    }
}
