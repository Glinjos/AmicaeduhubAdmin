<?php

namespace App\Http\Controllers;

use App\Http\Controllers\StaffController;
use App\Http\Controllers\AuthorizerController;
use App\Http\Controllers\StaffAdminController;


use Illuminate\Http\Request;
use Auth;


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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {

           
        $userType = $request->session()->get('userType');
    
        if ($userType == 0) {
            $email = $request->session()->get('email');
           // $password = $request->session()->get('password');
            $userId = $request->session()->get('user_id');
    
            $controller = app(AdminController::class);
            $response = $controller->dashboard();
            return $response;
        } else if($userType == 2) {
            $name = $request->session()->get('name');
           // print_r($name);die;
            $email = $request->session()->get('email');
           // $password = $request->session()->get('password');
            $userId = $request->session()->get('user_id');
    
            $controller = app(AuthorizerController::class);
            $response = $controller->index(); 
            return $response;
        }else if($userType == 3) {
            $name = $request->session()->get('name');
           // print_r($name);die;
            $email = $request->session()->get('email');
           // $password = $request->session()->get('password');
            $userId = $request->session()->get('user_id');
    
            $controller = app(StaffAdminController::class);
            $response = $controller->index(); 
            return $response;
        }
         else {
            $email = $request->session()->get('email');
          //  $password = $request->session()->get('password');
            $userId = $request->session()->get('user_id');
    
            $controller = app(StaffController::class);
            $response = $controller->index(); 
            return $response;
        }
       
    }
    
    

}
