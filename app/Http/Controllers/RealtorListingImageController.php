<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\ListingImage;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class RealtorListingImageController extends Controller
{
    public function create(Listing $listing)
    {
        $listing->load(['images']);

        return inertia(
            'Realtor/ListingImage/Create',
            [
                'listing' => $listing,
            ]
        );
    }

    public function store(Listing $listing, Request $request)
    {
        $request->validate([
            'images' => 'required|array',
            'images.*' => 'mimes:jpg,jpeg,png|max:5000',
        ], [
            'images.required' => 'Choose at least one image.',
            'images.*.mimes' => 'Image #:position must be a JPG or PNG file.',
            'images.*.max' => 'Image #:position is larger than 5 MB.',
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('images', 'public');

                $listing->images()->save(new ListingImage([
                    'filename' => $path,
                ]));
            }
        }

        Inertia::flash('toast', ['type' => 'success', 'message' => 'Images uploaded!']);

        return redirect()->back();
    }

    public function destroy(Listing $listing, ListingImage $image)
    {
        Storage::disk('public')->delete($image->filename);
        $image->delete();

        Inertia::flash('toast', ['type' => 'success', 'message' => 'Photo was deleted!']);

        return redirect()->back();
    }
}
