<?php

namespace App\Http\Controllers;

use App\Organization;
use Illuminate\Http\Request;

class AdministerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show(Organization $organization, Request $request)
    {
        $user = \Auth::user();
        return view('administer.administer', ['organization'=>$organization, 'user'=>$user]);
    }

}
