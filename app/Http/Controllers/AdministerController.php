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

        $orgUsers = $organization->users;
        $newSearchUsers = array();
        foreach ($searchUsers as $user) {
            if (!$orgUsers->contains('id', $user->id))
                $newSearchUsers[] = $user;
        }

        if (count($newSearchUsers) == 0)
            $message = "No results found";

        return view('administer.administer', ['organization' => $organization, 'user' => $user, 'searchUsers' => $newSearchUsers,])->with('searchTerm', $searchTerm);
    }

    public function update(Request $request, Organization $organization)
    {
        $user = \Auth::user();
        $addnew = $request->addnew;
        $roleId = ($addnew == 'addeditor' ? 2 : 3);
        $orgUsers = $organization->users;
        $addUserIds = $request->addUser;
        if (isset($addUserIds)) {
            foreach ($addUserIds as $userId) {
                if (!$orgUsers->contains('id', $userId))
                    $organization->users()->attach($userId, ['role_id' => $roleId]);
            }
        }

        return view('administer.administer', ['organization' => $organization, 'user' => $user, 'searchUsers' => [],]);
    }

    public function destroy(Request $request, Organization $organization)
    {
        $user = \Auth::user();
        $usersToDelete = $request->delUser;
        if (count($usersToDelete) > 0)
            $organization->users()->detach($usersToDelete);

        return view('administer.administer', ['organization' => $organization, 'user' => $user, 'searchUsers' => [],]);
    }

}
