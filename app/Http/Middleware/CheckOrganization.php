<?php

namespace App\Http\Middleware;

use App\Organization;
use Closure;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class CheckOrganization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $organization = $request->route('organization');
        $success = true;
        if (isset($organization)) {
            if (!Auth::user()->superuser)
                $success = Auth::user()->setCurrentOrganization($request->organization);
        }
        if ($success)
            return $next($request);
        else return redirect('home');
    }
}
