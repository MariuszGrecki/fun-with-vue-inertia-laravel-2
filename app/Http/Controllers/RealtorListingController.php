<?php

namespace App\Http\Controllers;

use App\Http\Requests\RealtorListingRequest;
use Illuminate\Http\Request;
use App\Models\Listing;
use Inertia\Inertia;

class RealtorListingController extends Controller
{
    public function index(RealtorListingRequest $request)
    {
        $filters = $request->validated();

        $query = $request->user()->listings()
            ->filter($request->validated())
            ->paginate(5)
            ->withQueryString();

        return inertia('Realtor/Index',
            [
                'filters' => $filters,
                'listings' => $query
            ]
        );
    }

    public function destroy(Listing $listing)
    {
        $listing->deleteOrFail();

        Inertia::flash('toast', ['type' => 'success', 'message' => 'Listing was deleted!']);

        return redirect()->back();
    }
}
