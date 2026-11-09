<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\user_detail_Model;

class CheckUserToken
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
        $uId = $request->header('uId');
        $onlinetoken = $request->header('onlinetoken');

        if (!$uId || !$onlinetoken) {
            return response()->json([

            'responseMessage' => 'Invalid Prameters',
            'responseCode' => 401,
            'responseStatus' =>false,

        ]);
        
        }

        if (!$this->checkAuth($uId, $onlinetoken)) {
            return response()->json([

            'responseMessage' => 'Authentication failed',
            'responseCode' => 555,
            'responseStatus' =>false,
           
        ]);

        }

       // Log::info("uId: $uId, OnlineToken: $onlinetoken");

        return $next($request);
    }

    private function checkAuth($uId, $onlinetoken)
    {
        $user = user_detail_Model::where('uId', $uId)->first();

        if (!$user) {
            return false; // User not found
        }
    
        // Check if the provided OnlineToken matches the stored token
        if ($user->onlinetoken !== $onlinetoken) {
            return false; // Token mismatch
        }

       // Log::info("uId: $uId, OnlineToken: $onlinetoken");

        return true; // Authentication successful
    }

}
