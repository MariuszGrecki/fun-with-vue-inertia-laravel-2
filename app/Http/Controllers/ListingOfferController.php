<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\Offer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ListingOfferController extends Controller
{
    public function store(Listing $listing, Request $request): RedirectResponse
    {
        $listing->offers()->save(
            (new Offer(
                $request->validate(['amount' => 'required|integer|min:1|max:200000'])
            ))->bidder()->associate($request->user())
        );

        Inertia::flash('toast', ['type' => 'success', 'message' => 'Offer was made!']);

        return redirect()->back();
    }
}
