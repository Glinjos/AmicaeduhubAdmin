<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use App\Models\loginIP\webLoginModel;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */

    //protected $redirectTo = RouteServiceProvider::HOME;

      public function login(Request $request)
        {
            $credentials = $request->only('email', 'password');
            if (Auth::attempt($credentials)) {
                $user = Auth::user();

                $request->session()->put('email', $credentials['email']);
              //  $request->session()->put('password', $credentials['password']);
                $request->session()->put('user_id', $user->id);
                $request->session()->put('userType', $user->userType);
                $request->session()->put('name', $user->name);
                $request->session()->put('isactive', $user->isactive);
                $request->session()->regenerate();

                if ($user->isactive == 1) {
                    Auth::logout();
                    return back()->withErrors([
                        'email' => 'You are no longer active.',
                    ]);
                }
                
                
                
                $userEmail = $request->session()->get('email');
                date_default_timezone_set('Asia/Kolkata');
                $currentDateTime = date('Y-m-d');
                $currentDateTimeIST = date('Y-m-d H:i:s');
                
                $userIp = $request->ip();
                
                $checkAlready = webLoginModel::where('ipConfig', $userIp)->where('username', $userEmail)->first();
                $webLoginId = webLoginModel::where('ipConfig', $userIp)->value('login_Id');
                $webHit = webLoginModel::where('ipConfig', $userIp)->value('hitCount');
                
                if ($checkAlready) {
                    if ($checkAlready->date == $currentDateTime) {
                        $countplus = $webHit + 1;
                
                        $updateIp = webLoginModel::where('login_Id', $webLoginId)
                            ->update([
                                'date' => $currentDateTime,
                                'hitCount' => $countplus,
                                'updated_at' => $currentDateTimeIST
                            ]);
                    } else {
                        $hitc = 1;
                        $insertMyLoginDetails = new webLoginModel();
                        $insertMyLoginDetails->date = $currentDateTime;
                        $insertMyLoginDetails->username = $userEmail;
                        $insertMyLoginDetails->ipConfig = $userIp;
                        $insertMyLoginDetails->hitCount = $hitc;
                        $insertMyLoginDetails->save();
                    }
                } else {
                    $hitc = 1;
                    $insertMyLoginDetails = new webLoginModel();
                    $insertMyLoginDetails->date = $currentDateTime;
                    $insertMyLoginDetails->username = $userEmail;
                    $insertMyLoginDetails->ipConfig = $userIp;
                    $insertMyLoginDetails->hitCount = $hitc;
                    $insertMyLoginDetails->save();
                }
                
               
                
                
                
                
              return redirect()->intended(RouteServiceProvider::HOME);
               
            }

            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ]);
        }

      
       
    

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

   

    
}
