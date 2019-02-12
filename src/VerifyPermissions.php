<?php

namespace Roksta\Permit;

use Closure;
use Illuminate\Support\Facades\Auth;
use Route;
use DB;

class VerifyPermissions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $current_route = Route::current()->getName();
        $is_protected = DB::table('all_permissions')->where('name', '=', $current_route)->exists();

        if ($is_protected) {
            if (Auth::guard($guard)->user()->permissions()->contains($current_route)) {
                return $next($request);
            }

            abort(403, 'You are not allowed to be here');
        }

        return $next($request);
    }
}
