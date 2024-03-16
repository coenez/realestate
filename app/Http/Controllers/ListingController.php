<?php

namespace App\Http\Controllers;

use App\Models\Listing;

class ListingController extends Controller
{
    /**
     * Display an overview of listings
     */
    public function index()
    {
        return inertia('Listing/Index', [
            'listings' => Listing::all()
        ]);
    }

    /**
     * Display the specified listing
     */
    //using route model binding
    public function show(Listing $listing)
    {
        return inertia('Listing/Show', [
            'listing' => $listing
        ]);
    }
}
