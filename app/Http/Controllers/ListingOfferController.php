<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\Offer;
use App\Notifications\OfferMade;
use Illuminate\Http\Request;

class ListingOfferController extends Controller
{
    public function store(Listing $listing, Request $request)
    {
        $this->authorize('view', $listing);

        $offer = $listing->offers()->save(
            Offer::make(
                $request->validate([
                    'amount'=> 'required|int|min:1|max:20000000'
                ])
            )->user()->associate($request->user())
        );

        $listing->user->notify(new OfferMade($offer));

        return redirect()->back()->with('success', 'Offer was made');
    }
}
