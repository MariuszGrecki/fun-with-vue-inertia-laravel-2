<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\Offer;
use App\Notifications\OfferMade;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ListingOfferController extends Controller
{
    public function store(Listing $listing, Request $request): RedirectResponse
    {
        if ($listing->acceptedOffer()->exists()) {
            Inertia::flash('toast', ['type' => 'error', 'message' => 'This listing is already sold.']);

            return redirect()->back();
        }

        if ($listing->user_id === $request->user()->id) {
            Inertia::flash('toast', ['type' => 'error', 'message' => 'You cannot make an offer on your own list!']);

            return redirect()->back();
        }

        DB::transaction(function () use ($listing, $request) {
            $offer = new Offer($request->validate(['amount' => 'required|integer|min:1|max:200000']));
            $offer->listing()->associate($listing);
            $offer->bidder()->associate($request->user());
            $offer->save();

            $listing->owner->notify(new OfferMade($offer));
        });

        Inertia::flash('toast', ['type' => 'success', 'message' => 'Offer was made!']);

        return redirect()->back();
    }
}
