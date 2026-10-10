<?php

namespace Tests\Feature;

use App\Models\Listing;
use App\Models\User;
use App\Notifications\OfferMade;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class OfferTest extends TestCase
{
    use RefreshDatabase;

    public function test_making_an_offer_notifies_the_listing_owner()
    {
        Notification::fake();

        $owner = User::factory()->create();
        $listing = Listing::factory()->for($owner, 'owner')->create();
        $bidder = User::factory()->create();

        $response = $this->actingAs($bidder)->post(route('listing.offer.store', $listing), [
            'amount' => 150000,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('offers', [
            'listing_id' => $listing->id,
            'bidder_id' => $bidder->id,
            'amount' => 150000,
        ]);

        Notification::assertSentTo($owner, OfferMade::class);
    }

    public function test_owner_cannot_make_an_offer_on_their_own_listing()
    {
        $owner = User::factory()->create();
        $listing = Listing::factory()->for($owner, 'owner')->create();

        $response = $this->actingAs($owner)->post(route('listing.offer.store', $listing), [
            'amount' => 150000,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseCount('offers', 0);
    }
}
