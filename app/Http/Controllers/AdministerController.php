<?php

namespace App\Http\Controllers;

use App\Organization;
use App\User;
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
        return view('administer.administer', ['organization' => $organization, 'user' => $user, 'searchUsers' => [],]);
    }

    public function search(Request $request, Organization $organization)
    {
        $user = \Auth::user();
        $searchTerm = $request->searchTerm;

        $searchUsers = User::where('name', 'like', '%' . $searchTerm . '%')->orWhere('email', 'like', '%' . $searchTerm . '%')->orderBy('name', 'asc')->get();

        $newSearchUsers = $searchUsers;

        if (count($newSearchUsers) == 0)
            $message = "No results found";

//        return redirect()->route('aggregate.search', [$organization]);

        return view('administer.administer', ['organization' => $organization, 'user' => $user, 'searchUsers' => $newSearchUsers,])->with('searchTerm', $searchTerm);
    }

    public function update(Request $request, Organization $organization)
    {
        $user = \Auth::user();
        $addnew = $request->addnew;
        $roleId = ($addnew == 'addeditor' ? 2 : 3);
        $addUsers = $request->addUser;
        if (isset($addUsers)) {
            foreach ($addUsers as $userId) {
                $organization->users()->attach($userId, ['role_id' => $roleId]);
            }
        }

        return view('administer.administer', ['organization' => $organization, 'user' => $user, 'searchUsers' => [],]);
    }

}
