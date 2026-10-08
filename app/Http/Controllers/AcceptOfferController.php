<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\Offer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class AcceptOfferController extends Controller
{
    public function __invoke(Listing $listing, Offer $offer): RedirectResponse
    {
        Gate::authorize('update', $listing);

        if ($listing->acceptedOffer()->exists()) {
            Inertia::flash('toast', ['type' => 'error', 'message' => 'This listing is already sold.']);

            return redirect()->back();
        }

        $offer->update(['accepted_at' => now()]);

        Inertia::flash('toast', ['type' => 'success', 'message' => 'Offer accepted!']);

        return redirect()->back();
    }
}
