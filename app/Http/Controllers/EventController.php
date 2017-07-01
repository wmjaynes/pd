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
        $eventYear = null;
        if ($request->has('year'))
            $eventYear = $request->input('year');
        $events = null;
        $org = Auth::user()->currentOrganization;
        $currentYear = Carbon::today()->year;
        $oldestEvent = $org->events()->orderBy('startDate', 'asc')->first();
        $oldestYear = isset($oldestEvent) ? $oldestEvent->startDate->year : $currentYear;
        for ($year = $currentYear; $year >= $oldestYear; $year--) {
            $years [$year] = $year;
        }

        If (is_null($eventYear)) {
            $events = $org->events()->oldest('startDate')->future()->published()->get();
        } else {
            $events = $org->events()->oldest('startDate')->published()->whereYear('startDate', $eventYear)->get();
        }
//        \DB::listen(function ($sql) {
//            var_dump($sql);
//        });

        $hidden = $org->events()->oldest('startDate')->unpublished()->get();

        return view('events.events', ['year' => $eventYear, 'years' => $years, 'events' => $events, 'hidden' => $hidden]);
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
    public function create()
    {
        $org = Auth::user()->currentOrganization;
        $event = $org->events()->published()->orderBy('startDate', 'desc')->with('venue')->first();
        $currentVenueId = $event->venue->id;
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

    protected function venueDropdown()
    {
        $org = Auth::user()->currentOrganization;
        $events = $org->events()->orderBy('startDate', 'desc')->with('venue')->get();
        $vdd = $events->mapWithKeys(function ($ev) {
            $vn = $ev->venue;
            if ($vn->visible)
                return [$vn->id => $vn->nameCity()];
        });

        $allVenues = Venue::visible()->get();
        $allVenuesdd = $allVenues->mapWithKeys(function ($vn) {
            return [$vn->id => $vn->nameCity()];
        });

        return ['venueDropdown' => $vdd, 'allVenuesDropdown' => $allVenuesdd];
    }

    protected function selectedVenueId(Request $request)
    {
        $venueId = $request->input('venue');
        $allVenueId = $request->input('allvenue');
        if (isset($allVenueId))
            return $allVenueId;
        else return $venueId;
    }

}
