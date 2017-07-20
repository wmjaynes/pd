<?php

namespace App\Http\Controllers;

use App\Venue;
use App\Http\Requests\VenueRequest;
use Illuminate\Http\Request;

class VenueController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $venues = Venue::approved()->orderBy('name', 'asc')->get();

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
        $user = \Auth::user();
        $venue = new Venue($request->all());
        $venue->createdBy()->associate($user);
        $venue->approved = true;
        $venue->save();

        $superusers = User::superuser()->get();
        if ($superusers->isNotEmpty()) {
            Mail::raw("This is a messsage from AACTMAD events. A new venue ($venue->id : $venue->name) has been created by: $user->email",
                function ($message) use ($superusers) {
                    foreach ($superusers as $user)
                        $message->to($user->email)->subject("New venue created");
                });
        }
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
        return view('venue.edit', compact('venue'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Venue $venue
     * @return \Illuminate\Http\Response
     */
    public function update(VenueRequest $request, Venue $venue)
    {
        $venue->fill($request->all());
        $venue->save();

        return view('venue.edit', compact('venue'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Venue $venue
     * @return \Illuminate\Http\Response
     */
    public function destroy(Venue $venue)
    {
        $deleteErrors = [];
        if ($venue->events->isNotEmpty()) {
            $deleteErrors[] =
                "The venue, $venue->name, has events associated with it and therefore can not be deleted.";
            return redirect('venue')->withErrors($deleteErrors);
        }

        $venue->delete();

        return redirect('venue');
    }
}
