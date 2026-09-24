<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Listing;
use App\Http\Requests\ListingRequest;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class ListingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return inertia(
            'Listing/Index',
            [
                'listings' => Listing::orderByDesc('created_at')
                    ->paginate(5)
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Listing::class);   

        return inertia('Listing/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ListingRequest $request)
    {
        Gate::authorize('create', Listing::class);

        $request->user()->listings()->create($request->validated());
        
        Inertia::flash('toast', ['type' => 'success', 'message' => 'Listing was created!']);

        return redirect()->route('listing.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Listing $listing)
    {
        Gate::authorize('view', $listing);   

        return inertia(
            'Listing/Show',
            [
                'listing' => $listing,
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Listing $listing)
    {
        Gate::authorize('update', $listing);   

        return inertia(
            'Listing/Edit',
            [
                'listing' => $listing,
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ListingRequest $request, Listing $listing)
    {
         Gate::authorize('update', $listing);   

        $listing->update($request->validated());
        
        Inertia::flash('toast', ['type' => 'success', 'message' => 'Listing was changed!']);

        return redirect()->route('listing.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Listing $listing)
    {
        Gate::authorize('delete', $listing);   

        $listing->delete();

        Inertia::flash('toast', ['type' => 'success', 'message' => 'Listing was deleted!']);

        return redirect()->back();
    }
}
