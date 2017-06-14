<?php

namespace App\Http\Controllers;

use App\Organization;
use App\Http\Requests\OrganizationRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class OrganizationController extends Controller
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
    public function index()
    {
        $organizations = Organization::all();

        return view('organization.organizations', ['organizations' => $organizations]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('organization.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrganizationRequest $request)
    {
        $organization = new Organization($request->all());
        $organization->save();

        return redirect('organization');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Organization $organization
     * @return \Illuminate\Http\Response
     */
    public function show(Organization $organization)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Organization $organization
     * @return \Illuminate\Http\Response
     */
    public function edit(Organization $organization)
    {
        return view('organization.edit', compact('organization'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Organization $organization
     * @return \Illuminate\Http\Response
     */
    public function update(OrganizationRequest $request, Organization $organization)
    {
        $organization->fill($request->all());
        $organization->save();

        return view('organization.edit', compact('organization'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Organization $organization
     * @return \Illuminate\Http\Response
     */
    public function destroy(Organization $organization)
    {
        $deleteErrors = [];
        if ($organization->events->isNotEmpty()) {
            $deleteErrors[] = "The organization, $organization->name, has events associated with it and therefore can not be deleted.";
            return redirect('organization')->withErrors($deleteErrors);
        }

        $organization->delete();

        return redirect('organization');
    }
}
