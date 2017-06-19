<?php

namespace App\Http\Controllers;

use App\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AggregateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Organization $organization, Request $request)
    {

//        $aggregates = $organization->aggregatees ()->where ( 'aggregator_id', '!=', $organization->id )->orderBy ( 'name', 'asc' )->get ();
//        $aggregates = $organization->aggregatees()->get();
        Auth::user()->setActiveOrganization($organization);
        return view('aggregate.aggregates', ['organization' => $organization, 'searchOrgs' => [],]);
    }

    public function destroy(Request $request, Organization $organization)
    {
        $aggsToDelete = $request->agg;
        if (count($aggsToDelete) > 0)
            $organization->aggregatees()->detach($aggsToDelete);

        return view('aggregate.aggregates', ['organization' => $organization, 'searchOrgs' => [],]);
    }

    public function update(Request $request, Organization $organization)
    {
        $addOrgs = $request->addOrg;
        if (count($addOrgs) > 0)
            $organization->aggregatees()->attach($addOrgs);

        return view('aggregate.aggregates', ['organization' => $organization, 'searchOrgs' => [],]);
    }

    public function search(Request $request, Organization $organization)
    {
        $searchTerm = $request->searchTerm;

        $searchOrgs = Organization::where('name', 'like', '%' . $searchTerm . '%')->orderBy('name', 'asc')->get();
        /**
         * Search for orgs, but then exclude those that have the current organization as an aggregator.
         */
        $newSearchOrgs = array();
        foreach ($searchOrgs as $sorg) {
            $include = true;
            foreach ($sorg->aggregators as $aorg) {
                if ($aorg->id == $organization->id)
                    $include = false;
            }
            if ($include)
                $newSearchOrgs [] = $aorg;
        }

        if (count($newSearchOrgs) == 0)
            $message = "No results found";

//        return redirect()->route('aggregate.search', [$organization]);

        return view('aggregate.aggregates', ['organization' => $organization, 'searchOrgs' => $newSearchOrgs,])->with('searchTerm', $searchTerm);
    }
}
