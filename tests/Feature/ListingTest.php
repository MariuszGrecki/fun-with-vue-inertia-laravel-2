<?php

namespace Tests\Feature;

use App\Models\Listing;
use App\Models\ListingImage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class ListingTest extends TestCase
{
    use RefreshDatabase;

    private function validListingData(array $overrides = []): array
    {
        return array_merge([
            'beds' => 3,
            'baths' => 2,
            'area' => 75,
            'city' => 'Kraków',
            'code' => '30-001',
            'street' => 'Floriańska',
            'street_nr' => '12',
            'price' => 650000,
        ], $overrides);
    }

    public function test_guest_can_browse_listings()
    {
        $owner = User::factory()->create();
        Listing::factory()->count(3)->for($owner, 'owner')->create();

        $response = $this->get(route('listing.index'));

        $response->assertOk()->assertInertia(fn (Assert $page) => $page
            ->component('Listing/Index')
            ->has('listings.data', 3)
        );
    }

    public function test_listings_can_be_filtered_by_price()
    {
        $owner = User::factory()->create();
        Listing::factory()->for($owner, 'owner')->create(['price' => 100000]);
        Listing::factory()->for($owner, 'owner')->create(['price' => 500000]);

        $response = $this->get(route('listing.index', ['priceFrom' => 200000]));

        $response->assertInertia(fn (Assert $page) => $page
            ->has('listings.data', 1)
            ->where('listings.data.0.price', 500000)
        );
    }

    public function test_listing_page_shows_its_images()
    {
        $owner = User::factory()->create();
        $listing = Listing::factory()->for($owner, 'owner')->create();
        ListingImage::factory()->count(2)->for($listing)->create();

        $response = $this->get(route('listing.show', $listing));

        $response->assertOk()->assertInertia(fn (Assert $page) => $page
            ->component('Listing/Show')
            ->where('listing.id', $listing->id)
            ->has('listing.images', 2)
        );
    }

    public function test_guest_cannot_open_the_create_form()
    {
        $response = $this->get(route('listing.create'));

        $response->assertRedirect(route('auth.login'));
    }

    public function test_user_can_create_a_listing()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('listing.store'), $this->validListingData());

        $response->assertRedirect(route('listing.index'));
        $this->assertDatabaseHas('listings', [
            'user_id' => $user->id,
            'city' => 'Kraków',
            'price' => 650000,
        ]);
    }

    public function test_listing_requires_a_valid_postal_code()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(
            route('listing.store'),
            $this->validListingData(['code' => '30001'])
        );

        $response->assertSessionHasErrors('code');
        $this->assertDatabaseCount('listings', 0);
    }
}
