<?php

namespace App\Http\Controllers;

use App\OrganizationRoleUser;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
//        $user = User::find(135);
        $org = $user->organization();
//        var_dump($org);
        $oru = $user->organizationRoleUsers()->first();
//        dd($oru);
//        $org = $oru->organization();
        $userRole = $oru->role;
//        var_dump($userRole);

        if (! session()->has("currentOrganization")) {
            session(['currentOrganization'=>$user->organization()]);
        }
        return view('home', ['oru' => $oru, 'usr' => $user, 'usrOru'=>$userRole, 'org'=>$org]);
    }
}
