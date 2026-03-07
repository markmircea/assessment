<?php

namespace Tests\Feature;

use App\Livewire\StoresDashboard;
use App\Models\Brand;
use App\Models\Store;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class StoresDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_renders_users_stores(): void
    {
        $brand = Brand::factory()->create();
        $store = Store::factory()->create(['brand_id' => $brand->id]);
        $user = User::factory()->create();
        $user->stores()->attach($store);

        Livewire::actingAs($user)
            ->test(StoresDashboard::class)
            ->assertSee((string) $store->number)
            ->assertSee($brand->name);
    }

    public function test_filters_by_brand(): void
    {
        $brand1 = Brand::factory()->create();
        $brand2 = Brand::factory()->create();
        $store1 = Store::factory()->create(['brand_id' => $brand1->id]);
        $store2 = Store::factory()->create(['brand_id' => $brand2->id]);
        $user = User::factory()->create();
        $user->stores()->attach([$store1->id, $store2->id]);

        Livewire::actingAs($user)
            ->test(StoresDashboard::class)
            ->call('switchBrand', $brand1->id)
            ->assertSee((string) $store1->number)
            ->assertDontSee((string) $store2->number);
    }

    public function test_clear_filter_shows_all(): void
    {
        $brand1 = Brand::factory()->create();
        $brand2 = Brand::factory()->create();
        $store1 = Store::factory()->create(['brand_id' => $brand1->id]);
        $store2 = Store::factory()->create(['brand_id' => $brand2->id]);
        $user = User::factory()->create();
        $user->stores()->attach([$store1->id, $store2->id]);

        Livewire::actingAs($user)
            ->test(StoresDashboard::class)
            ->call('switchBrand', $brand1->id)
            ->call('clearBrand')
            ->assertSee((string) $store1->number)
            ->assertSee((string) $store2->number);
    }
}
