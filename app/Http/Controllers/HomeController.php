<?php

namespace App\Http\Controllers;

use App\OrganizationRoleUser;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        \DB::listen(function($sql) {
//            var_dump($sql);
//        });
//        $oru = OrganizationRoleUser::find(7);
        $user = Auth::user();

        foreach ($user->organizations as $organization) {
            Log::debug('home: '.$organization);
        }

        $activeOrganization = $user->currentOrganization;
        Log::debug('home:index: activeOrg: '.$activeOrganization);
//        $userRole = $oru->role;

//        $organizations = Organization::orderBy('name', 'asc')->get();

        foreach ($user->organizations as $organization) {
            Log::debug('home'.$organization->pivot->role);
        }

        return view('home', ['aorg'=>$activeOrganization]);
    }
}
