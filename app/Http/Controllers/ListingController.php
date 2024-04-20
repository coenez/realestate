<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ListingController extends Controller
{
    public function __construct() {
        $this->middleware('auth')->except(['index', 'show']);
        $this->authorizeResource(Listing::class, 'listing');
    }

    /**
     * Display an overview of listings
     */
    public function index(Request $request)
    {
        $filters = $request->only(array_keys(Listing::FILTERS));

        return inertia('Listing/Index', [
            'filters' => $filters,
            'listings' => Listing::latest()
                ->filtered($filters)
                ->withoutSold()
                ->paginate(Listing::PAGE_SIZE)
                ->withQueryString(),
        ]);
    }

    /**
     * Display the specified listing
     */
    public function show(Listing $listing, Request $request)
    {
        $listing->load(['images']);

        return inertia('Listing/Show', [
            'listing' => $listing,
            'offerMade' => Auth::user() ? $listing->offers()->byCurrentUser()->first() : null
        ]);
    }
}
