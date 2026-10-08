<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Support\Facades\Gate;
use Inertia\Response;

class RealtorListingOfferController extends Controller
{
    public function index(Listing $listing): Response
    {
        Gate::authorize('update', $listing);

        $offers = $listing->offers()
            ->with('bidder:id,name,email')
            ->latest()
            ->get(['id', 'listing_id', 'bidder_id', 'amount', 'accepted_at', 'created_at']);

        return inertia(
            'Realtor/Offer/Index',
            [
                'listing' => $listing,
                'offers' => $offers,
            ]
        );
    }
}
