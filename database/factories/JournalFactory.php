<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Store;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Journal>
 */
class JournalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $revenue = $this->faker->randomFloat(2, 2000, 15000);
        $foodCost = round($revenue * $this->faker->randomFloat(2, 0.25, 0.35), 2);
        $laborCost = round($revenue * $this->faker->randomFloat(2, 0.20, 0.30), 2);
        $profit = round($revenue - $foodCost - $laborCost, 2);

        return [
            'store_id' => Store::factory(),
            'date' => $this->faker->date(),
            'revenue' => $revenue,
            'food_cost' => $foodCost,
            'labor_cost' => $laborCost,
            'profit' => $profit,
        ];
    }
}
