<?php

namespace App\Http\Controllers;

use App\Http\Requests\RealtorListingRequest;
use App\Http\Requests\UpdateRealtorListingRequest;
use App\Models\Listing;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;

class RealtorListingController extends Controller
{
    public function index(RealtorListingRequest $request): Response
    {
        $filters = $request->validated();

        $query = $request->user()->listings()
            ->filter($request->validated())
            ->withCount(['images', 'offers'])
            ->withExists('acceptedOffer')
            ->paginate(5)
            ->withQueryString();

        return inertia('Realtor/Index',
            [
                'filters' => $filters,
                'listings' => $query,
            ]
        );
    }

    public function destroy(Listing $listing): RedirectResponse
    {
        Gate::authorize('delete', $listing);

        $listing->deleteOrFail();

        Inertia::flash('toast', ['type' => 'success', 'message' => 'Listing was deleted!']);

        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Listing $listing): Response
    {
        Gate::authorize('update', $listing);

        return inertia(
            'Realtor/Edit',
            [
                'listing' => $listing,
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRealtorListingRequest $request, Listing $listing): RedirectResponse
    {
        Gate::authorize('update', $listing);

        if ($listing->acceptedOffer()->exists()) {
            Inertia::flash('toast', ['type' => 'error', 'message' => 'This listing is already sold.']);

            return redirect()->back();
        }

        $listing->update($request->validated());

        Inertia::flash('toast', ['type' => 'success', 'message' => 'Listing was changed!']);

        return redirect()->route('realtor.listing.index');
    }

    public function restore(Listing $listing): RedirectResponse
    {
        Gate::authorize('restore', $listing);

        $listing->restore();

        Inertia::flash('toast', ['type' => 'success', 'message' => 'Listing was restored!']);

        return redirect()->back();
    }
}
