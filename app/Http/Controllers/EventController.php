<?php

namespace App\Http\Controllers;

use App\Event;
use App\Venue;
use App\Http\Requests\EventRequest;
use App\Organization;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class EventController extends Controller
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
    public function index(Request $request)
    {
        $year = null;
        if ($request->has('year'))
            $year = $request->input('year');
        $events = null;
        $org = Auth::user()->currentOrganization;
        $currentYear = Carbon::today()->year;
        $oldestEvent = $org->events()->orderBy('startDate', 'asc')->first();
        $oldestYear = isset($oldestEvent) ? $oldestEvent->startDate->year : $currentYear;
        for ($yr = $currentYear; $yr >= $oldestYear; $yr--) {
            $years [$yr] = $yr;
        }

        If (is_null($year)) {
            $events = $org->events()->oldest('startDate')->future()->published()->get();
        } else {
            $events = $org->events()->oldest('startDate')->published()->whereYear('startDate', $year)->get();
        }
        //        \DB::listen(function ($sql) {
        //            var_dump($sql);
        //        });

        $hidden = $org->events()->oldest('startDate')->unpublished()->get();

        $mostRecentEvent = $org->events()->published()->orderBy('startDate', 'desc')->with('venue')->first();
        $currentVenueId = $mostRecentEvent->venue->id;

        return view('events.events', compact('year', 'years', 'events', 'hidden', 'currentVenueId'), $this->venueDropdown());
    }


    public function show(Organization $organization, Request $request)
    {
        Auth::user()->setCurrentOrganization($organization);
        return $this->index($request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $venue = $request->venue;
        $allvenue = $request->allvenue;
        if (isset($venue))
            $currentVenueId = $venue;
        if (isset($allvenue))
            $currentVenueId = $allvenue;
        if (!isset($currentVenueId)) {
            $org = Auth::user()->currentOrganization;
            $mostRecentEvent = $org->events()->published()->orderBy('startDate', 'desc')->with('venue')->first();
            $currentVenueId = $mostRecentEvent->venue->id;
        }
        return view('events.create', compact('currentVenueId'), $this->venueDropdown());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(EventRequest $request)
    {
        $input = $request->all();

        $start = new Carbon ($input ['startDate']);
        $end = new Carbon ($input ['endDate']);
        $input ['startDate'] = $start;
        $input ['endDate'] = $end;


        $org = Auth::user()->currentOrganization;

        $event = new Event($input);
        $event->venue_id = $this->selectedVenueId($request);
        $event->createdBy()->associate(\Auth::user());

        $org->events()->save($event);
        $event->save();

        return redirect('events');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Event $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        $currentVenueId = $event->venue_id;

        return view('events.edit', compact('event', 'currentVenueId'), $this->venueDropdown());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Event $event
     * @return \Illuminate\Http\Response
     */
    public function update(EventRequest $request, Event $event)
    {
        $input = $request->all();
        //        dd($input);

        $start = new Carbon ($input ['startDate']);
        $end = new Carbon ($input ['endDate']);
        $input ['startDate'] = $start;
        $input ['endDate'] = $end;


        $event->fill($input);
        $event->venue_id = $this->selectedVenueId($request);
        $event->save();
        $currentVenueId = $event->venue_id;
        //        return $event;
        return view('events.edit', compact('event', 'currentVenueId'), $this->venueDropdown());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Event $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        Log::debug("destroy: $event->id");
        $event->delete();
        return redirect('events');
    }

    public function copy(Event $event)
    {
        $newevent = $event->replicate();
        $newevent->published = false;
        $event->createdBy()->associate(\Auth::user());
        $newevent->save();
        return redirect('events');
    }

    protected function venueDropdown($chosenVenueId = null)
    {
        $org = Auth::user()->currentOrganization;
        $events = $org->events()->orderBy('startDate', 'desc')->with('venue')->get();

        foreach ($events as $ev) {
            $vn = $ev->venue;
            if ($vn->visible)
                $vdd[$vn->id] = $vn->nameCity();
        }

        $allVenues = Venue::visible()->get();
        $allVenuesdd = $allVenues->mapWithKeys(function ($vn) {
            return [$vn->id => $vn->nameCity()];
        });

        $mostVenuesdd = $allVenuesdd->diffKeys($vdd);

        return ['venueDropdown' => $vdd, 'allVenuesDropdown' => $mostVenuesdd];
    }

    protected function selectedVenueId(Request $request)
    {
        $venueId = $request->input('venue');
        $allVenueId = $request->input('allvenue');
        if (isset($allVenueId))
            return $allVenueId; else return $venueId;
    }

}
