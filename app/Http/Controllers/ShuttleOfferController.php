<?php

namespace App\Http\Controllers;

use App\Models\Shuttle_offer;
use App\Http\Requests\StoreShuttle_offerRequest;
use App\Http\Requests\UpdateShuttle_offerRequest;
use App\Models\Tag;

class ShuttleOfferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $offers = auth()->user()->shuttleOffers;
        // dd($offers;
        return view('offres.index', compact('offers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tags=Tag::all();
        return view('offres.create',compact('tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreShuttle_offerRequest $request)
    {
        // dd($request->all());
        $offer = new Shuttle_offer();
        $offer->title = $request->title;
        $offer->description = $request->description;
        $offer->departure_city = $request->depart;
        $offer->arrival_city = $request->arrivee;    
        $offer->departure_time = $request->heure_depart;
        $offer->arrival_time = $request->heure_arrivee;
        $offer->start_date = $request->date_debut;
        $offer->end_date = $request->date_fin;
        $offer->max_subscribers = $request->available_places;
        $offer->user_id = auth()->id();
        $offer->save();
        $offer->tags()->attach($request->tags);
        return redirect()->route('offers.index');

    }

    /**
     * Display the specified resource.
     */
    public function show(Shuttle_offer $shuttle_offer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Shuttle_offer $shuttle_offer)
    {
        // dd($shuttle_offer);
        $tags=Tag::all();
        return view('offres.create',compact('shuttle_offer','tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateShuttle_offerRequest $request, Shuttle_offer $shuttle_offer)
    {
        // dd($request->all());
        $shuttle_offer->title = $request->title;
        $shuttle_offer->description = $request->description;
        $shuttle_offer->departure_city = $request->depart;
        $shuttle_offer->arrival_city = $request->arrivee;
        $shuttle_offer->departure_time = $request->heure_depart;
        $shuttle_offer->arrival_time = $request->heure_arrivee;
        $shuttle_offer->start_date = $request->date_debut;
        $shuttle_offer->end_date = $request->date_fin;
        $shuttle_offer->max_subscribers = $request->available_places;
        $shuttle_offer->save();
        $shuttle_offer->tags()->sync($request->tags);
        return redirect()->route('offers.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shuttle_offer $shuttle_offer)
    {
        // dd($shuttle_offer);
        $shuttle_offer->delete();
        return redirect()->route('offers.index');
    }
}
