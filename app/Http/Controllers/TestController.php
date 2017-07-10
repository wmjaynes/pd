<?php

namespace App\Http\Controllers;

use App\Organization;
use App\OrganizationRoleUser;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TestController extends Controller
{


    public function test(Request $request, Organization $organization) {

//        \DB::listen(function($sql, $bindings) {
//            var_dump($sql);
//            var_dump($bindings);
//        });

//        $events = $organization->with('aggregatees.events')->get();

        $events = $organization->aggregatees()->with('events.venue')->get();
//        foreach ($events as $event){
//            $venues = $event->venues;
//            $organization    = $event->organization;
//        }

//        $ids = DB::table('aggregates')->where('aggregator_id',
//           '=', $organization->id)->pluck('aggregatee_id');
//
//        $events = DB::table('events')->whereIn('organization_id', $ids)->where
//        ('startDate','>', new Carbon())->orderBy
//        ('startDate', 'asc')
//            ->take(300)->get();

//        $events = $organization->events()->get();

//        foreach ($events as $event) {
//            var_dump($event);
//        }

//        dd($events);
        return response()->json($events);
    }
}
