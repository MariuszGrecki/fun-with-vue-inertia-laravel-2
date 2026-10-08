<?php

namespace App\Http\Controllers;

use App\Http\Requests\ListingRequest;
use App\Models\Listing;
use App\Models\Offer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;

class ListingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $filters = $request->only(['priceFrom', 'priceTo', 'beds', 'baths', 'areaFrom', 'areaTo']);

        $query = Listing::mostRecent()
            ->filter($filters)
            ->notSold();

        return inertia(
            'Listing/Index',
            [
                'filters' => $filters,
                'listings' => $query
                    ->paginate(5)
                    ->withQueryString(),
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        Gate::authorize('create', Listing::class);

        return inertia('Listing/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ListingRequest $request): RedirectResponse
    {
        Gate::authorize('create', Listing::class);

        $request->user()->listings()->create($request->validated());

        Inertia::flash('toast', ['type' => 'success', 'message' => 'Listing was created!']);

        return redirect()->route('listing.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Listing $listing, Request $request): Response
    {
        Gate::authorize('view', $listing);

        $listing->load(['images']);

        $isSold = $listing->acceptedOffer()->exists();

        return inertia(
            'Listing/Show',
            [
                'listing' => $listing,
                'isSold' => $isSold,
                'isOwner' => $request->user()?->id === $listing->user_id,
                'offers' => $request->user()
                    ? Offer::createdByMe()
                        ->where('listing_id', $listing->id)
                        ->latest()
                        ->get(['id', 'amount', 'created_at'])
                    : [],
            ]
        );
    }
}
