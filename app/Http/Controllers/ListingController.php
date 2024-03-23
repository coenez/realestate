<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;

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
        $listing->update($request->validate(Listing::getValidations()));

        return redirect()->route('listing.index')->with('success', 'Listing was changed');
    }


    public function store(Request $request)
    {
        Listing::create([
            $request->validate(Listing::getValidations()),
        ]);

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
