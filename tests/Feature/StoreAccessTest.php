<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\Journal;
use App\Models\Store;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StoreAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_own_store(): void
    {
        $brand = Brand::factory()->create();
        $store = Store::factory()->create(['brand_id' => $brand->id]);
        $user = User::factory()->create();
        $user->stores()->attach($store);

        Journal::factory()->count(3)->create(['store_id' => $store->id]);

        $response = $this->actingAs($user)->get(route('stores.show', $store));

        $response->assertOk();
        $response->assertSee((string) $store->number);
    }

    public function test_user_cannot_view_other_users_store(): void
    {
        $brand = Brand::factory()->create();
        $store = Store::factory()->create(['brand_id' => $brand->id]);
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('stores.show', $store));

        $response->assertForbidden();
    }

    public function test_guest_cannot_view_store(): void
    {
        $store = Store::factory()->create();

        $response = $this->get(route('stores.show', $store));

        $response->assertRedirect(route('login'));
    }
}
