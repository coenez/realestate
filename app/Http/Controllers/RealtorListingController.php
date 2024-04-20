<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RealtorListingController extends Controller
{

    public function index(Request $request)
    {
        $filters = [
            'deleted' => (int)$request->boolean('deleted'),
        ];
        $sorter = $request->only(['by', 'order']);

        return inertia('Realtor/Index', [
            'filters' => $filters,
            'sorter' => $sorter,
            'listings' => Auth::user()->listings()
                ->filtered($filters, $sorter)
                ->withCount('images')
                ->withCount('offers')
                ->paginate(Listing::PAGE_SIZE)
                ->withQueryString()
        ]);
    }

    public function show(Listing $listing)
    {
        return inertia('Realtor/Show', ['listing' => $listing->load('offers')]);
    }

    public function create()
    {
        return inertia('Realtor/Create');
    }

    public function store(Request $request)
    {
        $request->user()->listings()->create($request->validate(Listing::VALIDATIONS));

        return redirect()->route('realtor.listing.index')->with('success', 'Listing was created');
    }

    public function edit(Listing $listing)
    {
        return inertia('Realtor/Edit', [
            'listing' => $listing
        ]);
    }

    public function update(Request $request, Listing $listing)
    {
        $request->user()->listings()->update($request->validate(Listing::VALIDATIONS));

        return redirect()->route('realtor.listing.index')->with('success', 'Listing was changed');
    }

    public function destroy(Listing $listing)
    {
        $listing->deleteOrFail();
        return redirect()->back()->with('success', 'Listing was deleted');
    }

    public function restore(Listing $listing)
    {
        $listing->restore();
        return redirect()->back()->with('success', 'Listing was restored');
    }
}
