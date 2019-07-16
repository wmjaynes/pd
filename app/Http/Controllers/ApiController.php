<?php

namespace App\Http\Controllers;

use App\Aggregate;
use App\Organization;
use App\Event;
use App\OrganizationRoleUser;
use App\User;
use function array_column;
use function dd;
use function GuzzleHttp\Psr7\_caseless_remove;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use function response;
use function strtotime;

class ApiController extends Controller
{
    /*
     * If one or both are not specified, the default for start and end dates are:
     *     startDate: today
     *     endDate: 6 months after the startDate
     */
    private function determiineStartEndDates(Request $request)
    {
        $startDateStr = $request->input('startDate');
        $endDateStr = $request->input('endDate');

        if (strtotime($startDateStr) === false) {
            $startDateStr = "today";
        }
        if (strtotime($endDateStr) === false) {
            $endDateStr = $startDateStr . " +6 months";
        }

        $startDate = (new Carbon($startDateStr))->startOfDay();
        $endDate = (new Carbon($endDateStr))->startOfDay();
        Log::debug("startDate: " . $startDate . " endDate: " . $endDate);


        return [$startDate, $endDate];
    }

    private function packToArrays($events)
    {
        foreach ($events as $event) {
            $venues[$event->venue->id] = $event->venue;
            $organizations[$event->organization->id] = $event->organization;
            unset($event->venue);
            unset($event->organization);
        }
        return [$events, $venues, $organizations];
    }

    public function events(Request $request, Organization $organization)
    {
        $startEndDates = $this->determiineStartEndDates($request);

        $ids[] = $organization->id;

        $events = Event::whereIn('organization_id', $ids)
            ->whereBetween('startDate', $startEndDates)
            ->published()
            ->ordered()
            ->with(['venue', 'organization'])->get();

        $eventsVenuesOrgs = $this->packToArrays($events);

        return response()->json($eventsVenuesOrgs);
    }

    public function eventsForAggregate(Aggregate $aggregate, Request $request)
    {
        $startEndDates = $this->determiineStartEndDates($request);

        $orgs = $aggregate->organizations;
        $orgsIds = array_column($orgs->toArray(), 'id');

        $events = Event::whereIn('organization_id', $orgsIds)
            ->whereBetween('startDate', $startEndDates)
            ->published()
            ->ordered()
            ->with(['venue', 'organization'])->get();

        $eventsVenuesOrgs = $this->packToArrays($events);


        return response()->json($eventsVenuesOrgs);
    }


//    public function events(Request $request,
//                           Organization $organization,
//                           $aggrType,
//                           $outputFormat,
//                           $xxx = null)
//    {
//        dd($request);
//        $ids[] = $organization->id;
//        if ($aggrType == 's')
//            $ids = DB::table('aggregates')->where('aggregator_id', '=', $organization->id)
//                ->pluck('aggregatee_id');
//
//        $events = Event::whereIn('organization_id', $ids)->published()->future()->ordered()
//            ->with(['venue', 'organization'])->get();
//
//        return response()->json($events);
//    }

    public function eventsperiod(Request $request,
                                 Organization $organization,
                                 $aggrType,
                                 $outputFormat,
                                 $period,
                                 $extra = null)
    {
        //        dd(Carbon::now()->tz);
        $periodOffset = 0;
        $numOfPerods = 0;
        $ids[] = $organization->id;

        if ($aggrType == 's')
            $ids = DB::table('aggregates')->where('aggregator_id', '=', $organization->id)
                ->pluck('aggregatee_id');

        $matches = null;
        $match = preg_match('/([\\-\\+0-9]+)([:]*)([\\-\\+0-9]*)/', $extra, $matches);
        if ($match) {
            $periodOffset = $matches[1];  // Relavitve to today
            $numOfPerods = !empty($matches[3]) ? $matches[3] : 0;
        }
        //        dd([$match, $extra, $periodOffset, $numOfPerods, $matches]);

        switch ($period) {
            case 'd':
                $begin = Carbon::today()->addDay($periodOffset)->startOfDay();
                if ($numOfPerods > 0)
                    $end = (new Carbon($begin))->addDays($numOfPerods - 1)->endOfDay();
                break;
            case 'w':
                $begin = Carbon::today()->startOfWeek()->addWeeks($periodOffset)->startOfWeek();
                if ($numOfPerods > 0)
                    $end = (new Carbon($begin))->addWeek($numOfPerods - 1)->endOfWeek();
                break;
            case 'm':
                $begin = Carbon::today()->startOfMonth()->addMonths($periodOffset)->startOfMonth();
                if ($numOfPerods > 0)
                    $end = (new Carbon($begin))->addMonths($numOfPerods - 1)->endOfMonth();
                break;
            case 'y':
                $begin = Carbon::today()->startOfYear()->addYears($periodOffset)->startOfYear();
                if ($numOfPerods > 0)
                    $end = (new Carbon($begin))->addYears($numOfPerods - 1)->endOfYear();
                break;
        }

        $query = Event::whereIn('organization_id', $ids)->published()->ordered()
            ->with(['venue', 'organization']);

        if (isset($end))
            $events = $query->whereBetween('startDate', [$begin, $end])->get();
        else
            $events = $query->where('startDate', '>', $begin)->get();

        return response()->jsonp($events);
    }

    public function event(Request $request, Event $event, $moreEvents = null)
    {
        if (!empty($moreEvents))
            $events = explode('/', $moreEvents);

        array_unshift($events, $event->id);
        foreach ($events as $key => $eventId) {
            $events[$key] = (int)$eventId;
        }

        //        dd($events);

        $events =
            Event::published()->ordered()->whereIn('id', $events)->with(['venue', 'organization'])
                ->get();

        return response()->json($events);
    }
}
