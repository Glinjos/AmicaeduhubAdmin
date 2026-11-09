<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EmployeeStaffRoute
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $session_userType = $request->session()->get('userType');
        $userType = 1;

        if($session_userType == $userType){
            return $next($request);
        }else{
           // return abort(403, 'Unauthorized');
           return response()->view('unauthorized', [], 403);
        }
    }
}
