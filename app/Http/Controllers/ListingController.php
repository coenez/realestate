<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    public function __construct() {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display an overview of listings
     */
    public function index()
    {
        return inertia('Listing/Index', [
            'listings' => Listing::all()
        ]);
    }

    public function create()
    {
        return inertia('Listing/Create');
    }

    public function edit(Listing $listing)
    {
        return inertia('Listing/Edit', [
            'listing' => $listing
        ]);
    }

    public function update(Request $request, Listing $listing)
    {
        $request->user()->listings()->update($request->validate(Listing::VALIDATIONS));

        return redirect()->route('listing.index')->with('success', 'Listing was changed');
    }


    public function store(Request $request)
    {
        $request->user()->listings()->create($request->validate(Listing::VALIDATIONS));

        return redirect()->route('listing.index')->with('success', 'Listing was created');
    }

    /**
     * Display the specified listing
     */
    public function show(Listing $listing)
    {
        return inertia('Listing/Show', [
            'listing' => $listing
        ]);
    }

    public function destroy(Listing $listing)
    {
        $listing->delete();
        return redirect()->back()->with('success', 'Listing was deleted');
    }
}
