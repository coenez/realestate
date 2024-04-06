<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RealtorListingController extends Controller
{
    public function __construct() {
        $this->authorizeResource(Listing::class, 'listing');
    }

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
                ->paginate(Listing::PAGE_SIZE)
                ->withQueryString()
        ]);
    }

    public function destroy(Listing $listing)
    {
        $listing->deleteOrFail();
        return redirect()->back()->with('success', 'Listing was deleted');
    }
}
