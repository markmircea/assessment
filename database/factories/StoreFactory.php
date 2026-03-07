<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Brand;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Store>
 */
class StoreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
              'brand_id' => Brand::factory(),
              'number' => $this->faker->unique()->numberBetween(1000, 99999),
              'address' => $this->faker->streetAddress(),
              'city' => $this->faker->city(),
              'state' => $this->faker->stateAbbr(),
              'zip_code' => $this->faker->postcode()
        ];
    }
}
