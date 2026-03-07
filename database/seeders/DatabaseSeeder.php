<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Brand;
use App\Models\Journal;
use App\Models\Store;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $tacoBell = Brand::create(['name' => 'Taco Bell', 'color' => '#702082']);
        $kfc = Brand::create(['name' => 'KFC', 'color' => '#E4002B']);
        $pizzaHut = Brand::create(['name' => 'Pizza Hut', 'color' => '#EE3A23']);

        $brands = [$tacoBell, $kfc, $pizzaHut];
        $allStores = collect();

        foreach ($brands as $brand) {
            $stores = Store::factory()->count(rand(5, 8))->create(['brand_id' => $brand->id]);
            $allStores = $allStores->merge($stores);

            foreach ($stores as $store) {
                $startDate = now()->subYear();
                $journals = [];

                for ($i = 0; $i < 365; $i++) {
                    $revenue = fake()->randomFloat(2, 2000, 15000);
                    $foodCost = round($revenue * fake()->randomFloat(2, 0.25, 0.35), 2);
                    $laborCost = round($revenue * fake()->randomFloat(2, 0.20, 0.30), 2);

                    $journals[] = [
                        'store_id' => $store->id,
                        'date' => $startDate->copy()->addDays($i)->format('Y-m-d'),
                        'revenue' => $revenue,
                        'food_cost' => $foodCost,
                        'labor_cost' => $laborCost,
                        'profit' => round($revenue - $foodCost - $laborCost, 2),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }

                foreach (array_chunk($journals, 500) as $chunk) {
                    Journal::insert($chunk);
                }
            }
        }

        $peter = User::factory()->create([
            'name' => 'Peter Parker',
            'email' => 'peter@yumbrands.test',
            'password' => bcrypt('password'),
        ]);
        foreach ($brands as $brand) {
            $peter->stores()->attach(
                $allStores->where('brand_id', $brand->id)->take(2)->pluck('id')
            );
        }

        $dwane = User::factory()->create([
            'name' => 'Dwane The Rock Johnson',
            'email' => 'dwane@yumbrands.test',
            'password' => bcrypt('password'),
        ]);
        $dwane->stores()->attach($allStores->where('brand_id', $tacoBell->id)->pluck('id'));

        $shaggy = User::factory()->create([
            'name' => 'Shaggy Scooby',
            'email' => 'shaggy@yumbrands.test',
            'password' => bcrypt('password'),
        ]);
        $shaggy->stores()->attach(
            $allStores->whereIn('brand_id', [$kfc->id, $pizzaHut->id])->pluck('id')
        );
    }
}
