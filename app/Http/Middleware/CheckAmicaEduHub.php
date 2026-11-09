<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAmicaEduHub
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
        $ginjosToken = $request->header('ginjosToken');
        $checkThisToken = "GlinJos*InnovaTions!)AMI(Edu!*HUB!*21082023";

        if (!$ginjosToken) {
            return response()->json([
            'responseMessage' => 'Invalid Prameters',
            'responseCode' => 401,
            'responseStatus' =>false,

        ]);
        
        }

        if (!$this->checkAuthForAmi($ginjosToken, $checkThisToken)) {
            return response()->json([
            'responseMessage' => 'Authentication failed',
            'responseCode' => 555,
            'responseStatus' =>false,
           
        ]);

        }


        return $next($request);
    }

    private function checkAuthForAmi($ginjosToken, $checkThisToken)
    {

        if ($ginjosToken !== $checkThisToken) {
            return false; //  mismatch
        }

        return true; //  successful
    }
}
