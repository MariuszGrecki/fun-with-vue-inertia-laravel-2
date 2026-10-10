<?php

namespace Tests\Feature;

use App\Models\Listing;
use App\Models\Offer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AcceptOfferTest extends TestCase
{
    use RefreshDatabase;

    public function test_realtor_can_accept_an_offer_on_their_own_listing()
    {
        $owner = User::factory()->create();
        $listing = Listing::factory()->for($owner, 'owner')->create();
        $bidder = User::factory()->create();
        $offer = Offer::factory()->for($listing)->for($bidder, 'bidder')->create();

        $response = $this->actingAs($owner)->post(
            route('realtor.listing.offer.accept', ['listing' => $listing, 'offer' => $offer])
        );

        $response->assertRedirect();
        $this->assertNotNull($offer->fresh()->accepted_at);
    }

    public function test_realtor_cannot_accept_an_offer_belonging_to_a_different_listing()
    {
        $owner = User::factory()->create();
        $listingA = Listing::factory()->for($owner, 'owner')->create();
        $listingB = Listing::factory()->for($owner, 'owner')->create();
        $bidder = User::factory()->create();
        $offerOnListingB = Offer::factory()->for($listingB)->for($bidder, 'bidder')->create();

        // {listing} in the URL is listingA, but {offer} actually belongs to listingB —
        // scopeBindings() on the route must reject this instead of accepting the wrong offer.
        $response = $this->actingAs($owner)->post(
            route('realtor.listing.offer.accept', ['listing' => $listingA, 'offer' => $offerOnListingB])
        );

        $response->assertNotFound();
        $this->assertNull($offerOnListingB->fresh()->accepted_at);
    }
}
