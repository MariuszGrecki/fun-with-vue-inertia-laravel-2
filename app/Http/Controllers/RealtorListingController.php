<?php

namespace App\Http\Controllers;

use App\Http\Requests\RealtorListingRequest;
use Illuminate\Http\Request;

class RealtorListingController extends Controller
{
    public function index(RealtorListingRequest $request)
    {
       $query = $request->user()->listings;

        return inertia('Realtor/Index',
            [
                 'listings' => $query
            ]
        );
    }
}
