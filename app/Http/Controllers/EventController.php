<?php

namespace App\Http\Controllers;

use App\Event;
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
        Log::debug("index:org - ".Auth::user()->currentOrganization);
        $eventYear = null;
        if ($request->has('year'))
            $eventYear = $request->input('year');
        $events = null;
        $org = Auth::user()->currentOrganization;
        Log::debug("events index org: $org");
        $oldestEvent = $org->events()->orderBy('startDate', 'asc')->first();
        $oldestYear = $oldestEvent->startDate->year;
        $currentYear = Carbon::today()->year;
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
        Log::debug("show:org - $organization");
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
        return view('events.create');
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

        $start = new Carbon ( $input ['startDate'] );
        $end = new Carbon ( $input ['endDate'] );
        $input ['startDate'] = $start;
        $input ['endDate'] = $end;

        $org = Auth::user()->currentOrganization;
        Log::debug("event store: org:$org");

        $input ['organization_id'] = $org->id;
        $event = new Event($input);

        $org->events ()->save ( $event );
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
        Log::debug("edit: $event->id");
//        dd($event);
        return view('events.edit', compact('event'));
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

        $start = new Carbon ( $input ['startDate'] );
        $end = new Carbon ( $input ['endDate'] );
        $input ['startDate'] = $start;
        $input ['endDate'] = $end;

        $event->fill($input);
        $event->save();
//        return $event;
        return view('events.edit', compact('event'));
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
}
