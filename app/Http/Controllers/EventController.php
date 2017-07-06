<?php

namespace App\Http\Controllers;

use App\Event;
use App\Venue;
use App\Http\Requests\EventRequest;
use App\Organization;
use Carbon\Carbon;
use Carbon\CarbonInterval;
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
            $events =
                $org->events()
                    ->oldest('startDate')
                    ->published()
                    ->whereYear('startDate', $year)
                    ->get();
        }
        //        \DB::listen(function ($sql) {
        //            var_dump($sql);
        //        });

        $hidden = $org->events()->oldest('startDate')->unpublished()->get();

        $currentVenueId = null;
        $mostRecentEvent =
            $org->events()
                ->published()
                ->orderBy('startDate', 'desc')
                ->with('venue')
                ->first();
        if (isset($mostRecentEvent))
            $currentVenueId = $mostRecentEvent->venue->id;

        return view('events.events',
            compact('year', 'years', 'events', 'hidden', 'currentVenueId'),
            $this->venueDropdown());
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
            $currentVenueId = null;
            $mostRecentEvent =
                $org->events()
                    ->published()
                    ->orderBy('startDate', 'desc')
                    ->with('venue')
                    ->first();
            if (isset($mostRecentEvent))
                $currentVenueId = $mostRecentEvent->venue->id;
        }
        //        dd($currentVenueId);
        return view('events.create',
            compact('currentVenueId'),
            $this->venueDropdown($currentVenueId));
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

        $start = new Carbon ($input ['xstartDate'] . ' ' . $input['startTime']);
        $end = new Carbon ($input ['xendDate'] . ' ' . $input['endTime']);
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
        $event->xstartDate = $event->startDate->format('m/d/Y');
        $event->xendDate = $event->endDate->format('m/d/Y');
        $event->startTime = $event->startDate->format('H:i');
        $event->endTime = $event->endDate->format('H:i');

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

        $start = new Carbon ($input ['xstartDate'] . ' ' . $input['startTime']);
        $end = new Carbon ($input ['xendDate'] . ' ' . $input['endTime']);
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

    /**
     *  Create and store new copies of an event.
     *
     * @param Event $event
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function copyStore(Request $request, Event $event)
    {
        $ncopies = $request->ncopies;
        $ncopies++;
        $interval = $request->interval;
        $startDate = new Carbon($request->startDate);

        if ($interval == 0) {
            for ($i = 0; $i < $ncopies; $i++) {
                $newevent = $event->replicate();
                $newevent->published = false;
                $newevent->createdBy()->associate(\Auth::user());
                $newevent->save();
            }
        } elseif ($interval == 1) {
            for ($i = 0; $i < $ncopies; $i++) {
                $newevent = $event->replicate();
                $newStartDate =
                    Carbon::create($startDate->year,
                        $startDate->month,
                        $startDate->day,
                        $event->startDate->hour,
                        $event->startDate->minute,
                        $event->startDate->second,
                        null);
                $newEndDate =
                    Carbon::create($startDate->year,
                        $startDate->month,
                        $startDate->day,
                        $event->endDate->hour,
                        $event->endDate->minute,
                        $event->endDate->second,
                        null);
                $newevent->startDate = $newStartDate;
                $newevent->endDate = $newEndDate;

                $newevent->published = false;
                $newevent->createdBy()->associate(\Auth::user());
                $newevent->save();

                $startDate->addWeek();
            }
        } elseif ($interval == 2) {
            $days = $this->getMondays($startDate, $ncopies);
            foreach ($days as $day) {
                $newevent = $event->replicate();
                $newStartDate =
                    Carbon::create($day->year,
                        $day->month,
                        $day->day,
                        $event->startDate->hour,
                        $event->startDate->minute,
                        $event->startDate->second,
                        null);
                $newEndDate =
                    Carbon::create($day->year,
                        $day->month,
                        $day->day,
                        $event->endDate->hour,
                        $event->endDate->minute,
                        $event->endDate->second,
                        null);
                $newevent->startDate = $newStartDate;
                $newevent->endDate = $newEndDate;

                $newevent->published = false;
                $newevent->createdBy()->associate(\Auth::user());
                $newevent->save();
            }
        }

        return redirect('events');
    }

    public function getMondays($adate, $number)
    {
        $dayOfWeek = $adate->format('l');
        $ordinals = [1 => 'first', 2 => 'second', 3 => 'third', 4 => 'fourth'];
        $firstOfThisMonth = Carbon::parse('first ' . $adate->format('l \\of F Y'));
        $firstOfNextMonth =
            Carbon::parse('first ' . (new Carbon($adate))->addMonth()->format('l \\of F Y'));
        $days = new \DatePeriod(
            $firstOfThisMonth,
            CarbonInterval::week(),
            $firstOfNextMonth
        );
        $month = $firstOfThisMonth->month;
        $n = 0;
        foreach ($days as $day) {
            $n++;
            if ($day->isSameDay($adate))
                break;
        }
        $ordinal = $ordinals[$n];
        Log::debug("ordinal: $ordinal n: $n");
        $dates = [];
        $firstOfMonth = $firstOfThisMonth->subMonth();
        //        dd([$firstOfThisMonth, $firstOfMonth, $number]);
        for ($i = 0; $i < $number; $i++) {
            Log::debug("iiii:  $i  firstOfMonth: $firstOfMonth");
            $theDay =
                Carbon::parse($ordinal . ' ' . $dayOfWeek . $firstOfMonth->addMonth()
                        ->format(' \\of F Y'));
            Log::debug($firstOfMonth->format('l \\of F Y'));
            $dates[] = $theDay;
        }

        return $dates;
    }

    /**
     *  Show the form for copying the event
     * @param Event $event
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public
    function copy(Event $event)
    {
        return view('events.copy', compact('event'));
    }

    public
    function publish(Event $event)
    {
        $event->published = 1;
        $event->save();
        return redirect('events');
    }

    public
    function unpublish(Event $event)
    {
        $event->published = 0;
        $event->save();
        return redirect('events');
    }

    protected
    function venueDropdown($chosenVenueId = null)
    {
        $org = Auth::user()->currentOrganization;
        $events = $org->events()->orderBy('startDate', 'desc')->with('venue')->get();

        $vdd = collect();
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

        if (isset($chosenVenueId)) {
            $chosenVenuedd = $mostVenuesdd->pull($chosenVenueId);
            $vdd[$chosenVenueId] = $chosenVenuedd;
        }

        $collection = collect(['product_id' => 'prod-100', 'name' => 'Desk']);
        $c = $collection->pull('name');

        return ['venueDropdown' => $vdd, 'allVenuesDropdown' => $mostVenuesdd];
    }

    protected
    function selectedVenueId(Request $request)
    {
        $venueId = $request->input('venue');
        $allVenueId = $request->input('allvenue');
        if (isset($allVenueId))
            return $allVenueId; else return $venueId;
    }

}
