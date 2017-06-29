<?php

namespace App\Http\Controllers;

use App\Venue;
use App\Http\Requests\VenueRequest;
use Illuminate\Http\Request;

class VenueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $venues = Venue::visible()->orderBy('name', 'asc')->get();

        return view('venue.venues', ['venues' => $venues]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('venue.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(VenueRequest $request)
    {
        $venue = new Venue($request->all());
//        $venue->save();
        return redirect('venue');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Venue $venue
     * @return \Illuminate\Http\Response
     */
    public function show(Venue $venue)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Venue $venue
     * @return \Illuminate\Http\Response
     */
    public function edit(Venue $venue)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Venue $venue
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Venue $venue)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Venue $venue
     * @return \Illuminate\Http\Response
     */
    public function destroy(Venue $venue)
    {
        //
    }
}
