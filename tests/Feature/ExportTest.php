<?php

namespace Tests\Feature;

use App\Jobs\ExportFinancialData;
use App\Models\Brand;
use App\Models\Store;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class ExportTest extends TestCase
{
    use RefreshDatabase;

    public function test_export_dispatches_job(): void
    {
        Queue::fake();

        $user = User::factory()->create();
        $brand = Brand::factory()->create();
        $store = Store::factory()->create(['brand_id' => $brand->id]);
        $user->stores()->attach($store);

        $response = $this->actingAs($user)->post(route('export.store'));

        $response->assertRedirect();
        $response->assertSessionHas('success');
        Queue::assertPushed(ExportFinancialData::class);
    }

    public function test_export_with_brand_filter(): void
    {
        Queue::fake();

        $user = User::factory()->create();
        $brand = Brand::factory()->create();
        $store = Store::factory()->create(['brand_id' => $brand->id]);
        $user->stores()->attach($store);

        $response = $this->actingAs($user)
            ->post(route('export.store'), ['brand_id' => $brand->id]);

        $response->assertRedirect();
        Queue::assertPushed(ExportFinancialData::class, function ($job) use ($brand) {
            return $job->brandId === $brand->id;
        });
    }

    public function test_export_rejects_invalid_brand_id(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->post(route('export.store'), ['brand_id' => 99999]);

        $response->assertSessionHasErrors('brand_id');
    }

    public function test_export_rejects_brand_user_cannot_access(): void
    {
        $user = User::factory()->create();
        $brand = Brand::factory()->create();

        $response = $this->actingAs($user)
            ->post(route('export.store'), ['brand_id' => $brand->id]);

        $response->assertSessionHasErrors('brand_id');
    }
}
