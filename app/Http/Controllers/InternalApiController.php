<?php

namespace App\Http\Controllers;

use App\Aggregate;
use App\Organization;
use App\User;
use Illuminate\Http\Request;
use function response;

class InternalApiController extends Controller
{
    //

    public function getOrganizations()
    {
        $organizations = Organization::visible()->get();

        return response()->json($organizations);
    }

    public function getAggregatesForOrganizations(Organization $organization)
    {

//        Auth::user()->setCurrentOrganization($organization);

        $organization->load('aggregates', 'aggregates.organizations');
        return response()->json($organization);
    }

    // HTTP Delete
    public function detachOrganizationFromAggregate(Aggregate $aggregate, Organization $organization, Request $request)
    {
        $aggregate->organizations()->detach($organization->id);
    }

    // HTTP Put
    public function attachOrganizationToAggregate(Aggregate $aggregate, Organization $organization, Request $request)
    {
        $aggregate->organizations()->attach($organization);
    }

    // HTTP Post
    public function createAggregateForOrganization(Organization $organization, Request $request)
    {
        $agg = new Aggregate([
            'name' =>$request->get('name')
        ]);
        $organization->aggregates()->save($agg);
//        $organization->save;

    }

    // HTTP Delete
    public function deleteAggregate(Aggregate $aggregate)
    {
        $aggregate->organizations()->sync([]);
        $aggregate->delete();
    }

    public function getOrganizationsForUser(User $user)
    {
        $organizations = $user->organizations;
        return response()->json($organizations);
    }
}
