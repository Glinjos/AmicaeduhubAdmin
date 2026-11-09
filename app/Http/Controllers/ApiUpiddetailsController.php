<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Upiddetails;

class ApiUpiddetailsController extends Controller
{
    public function get_upi_details(Request $request){
        $get_upi_details=Upiddetails::get();
        if($get_upi_details){
                return response()->json([
                    'responseMessage' => 'Upi details.',
                    'responseCode' => 200,
                    'responseStatus' => true,
                    'data' => $get_upi_details
                ]);
          
        }else{
            return response()->json([
                'responseMessage' => 'no data foumd.',
                'responseCode' => 400,
                'responseStatus' => false
            ]);
        }


    }
    
}
