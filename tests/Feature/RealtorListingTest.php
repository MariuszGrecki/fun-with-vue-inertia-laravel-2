<?php

namespace Tests\Feature;

use App\Models\Listing;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class RealtorListingTest extends TestCase
{
    use RefreshDatabase;

    private function validListingData(array $overrides = []): array
    {
        return array_merge([
            'beds' => 3,
            'baths' => 2,
            'area' => 75,
            'city' => 'Warszawa',
            'code' => '00-950',
            'street' => 'Marszałkowska',
            'street_nr' => '10',
            'price' => 500000,
        ], $overrides);
    }

    public function test_realtor_sees_only_own_listings()
    {
        $realtor = User::factory()->create();
        $other = User::factory()->create();
        Listing::factory()->count(2)->for($realtor, 'owner')->create();
        Listing::factory()->count(3)->for($other, 'owner')->create();

        $response = $this->actingAs($realtor)->get(route('realtor.listing.index'));

        $response->assertOk()->assertInertia(fn (Assert $page) => $page
            ->component('Realtor/Index')
            ->has('listings.data', 2)
        );
    }

    public function test_deleted_listings_are_shown_only_with_the_deleted_filter()
    {
        $realtor = User::factory()->create();
        Listing::factory()->for($realtor, 'owner')->create();
        Listing::factory()->for($realtor, 'owner')->create()->delete();

        $this->actingAs($realtor)
            ->get(route('realtor.listing.index'))
            ->assertInertia(fn (Assert $page) => $page->has('listings.data', 1));

        $this->actingAs($realtor)
            ->get(route('realtor.listing.index', ['deleted' => 1]))
            ->assertInertia(fn (Assert $page) => $page->has('listings.data', 2));
    }

    public function test_realtor_can_update_own_listing()
    {
        $realtor = User::factory()->create();
        $listing = Listing::factory()->for($realtor, 'owner')->create();

        $response = $this->actingAs($realtor)->put(
            route('realtor.listing.update', $listing),
            $this->validListingData(['price' => 999999])
        );

        $response->assertRedirect(route('realtor.listing.index'));
        $this->assertSame(999999, $listing->fresh()->price);
    }

    public function test_realtor_cannot_update_someone_elses_listing()
    {
        $realtor = User::factory()->create();
        $listing = Listing::factory()->for(User::factory(), 'owner')->create();

        $response = $this->actingAs($realtor)->put(
            route('realtor.listing.update', $listing),
            $this->validListingData(['price' => 1])
        );

        $response->assertForbidden();
        $this->assertNotSame(1, $listing->fresh()->price);
    }

    public function test_realtor_can_delete_and_restore_own_listing()
    {
        $realtor = User::factory()->create();
        $listing = Listing::factory()->for($realtor, 'owner')->create();

        $this->actingAs($realtor)->delete(route('realtor.listing.destroy', $listing));
        $this->assertSoftDeleted($listing);

        $this->actingAs($realtor)->put(route('realtor.listing.restore', $listing));
        $this->assertNotSoftDeleted($listing);
    }

    public function test_realtor_cannot_delete_someone_elses_listing()
    {
        $realtor = User::factory()->create();
        $listing = Listing::factory()->for(User::factory(), 'owner')->create();

        $response = $this->actingAs($realtor)->delete(route('realtor.listing.destroy', $listing));

        $response->assertForbidden();
        $this->assertNotSoftDeleted($listing);
    }
}
