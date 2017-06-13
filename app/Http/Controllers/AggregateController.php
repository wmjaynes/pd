<?php

namespace App\Http\Controllers;

use App\Organization;
use Illuminate\Http\Request;

class AggregateController extends Controller
{
    public function index(Organization $organization, Request $request)
    {

        $aggregates = $organization->aggregatees ()->where ( 'aggregator_id', '!=', $organization->id )->orderBy ( 'name', 'asc' )->get ();
//        $aggregates = $organization->aggregatees()->get();
        return view('aggregate.aggregates', ['organization' => $organization, 'searchOrgs' => [],]);
    }

    public function destroy(Request $request, Organization $organization)
    {
        $aggs = $request->agg;
        return view('aggregate.aggregates', ['organization' => $organization, 'searchOrgs' => [],]);
    }

    public function update(Request $request, Organization $organization)
    {

        return view('aggregate.aggregates', ['organization' => $organization, 'searchOrgs' => [],]);
    }

    public function search(Request $request, Organization $organization)
    {
        $searchTerm = $request->searchTerm;

        $searchOrgs = Organization::where('name', 'like', '%' . $searchTerm . '%')->orderBy('name', 'asc')->get();

//        return redirect()->route('aggregate.search', [$organization]);

        return view('aggregate.aggregates', ['organization' => $organization, 'searchOrgs' => $searchOrgs,])->with('searchTerm', $searchTerm);
    }
}
