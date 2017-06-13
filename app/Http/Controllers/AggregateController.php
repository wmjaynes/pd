<?php

namespace App\Http\Controllers;

use App\Organization;
use Illuminate\Http\Request;

class AggregateController extends Controller
{
    public function index(Organization $organization, Request $request) {

//        $aggregates = $organization->aggregatees ()->where ( 'id', '!=', $organization->id )->orderBy ( 'name', 'asc' )->get ();
        $aggregates = $organization->aggregatees()->get();
        return view('aggregate.aggregates', ['organization' => $organization, 'searchOrgs' => [],]);
    }

    public function destroy(Organization $organization)
    {
        return view('aggregate.aggregates', ['organization' => $organization, 'searchOrgs' => [],]);
    }
}
