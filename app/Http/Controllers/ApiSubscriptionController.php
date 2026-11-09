<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionModels\SubscriptionModel;
use App\Models\SubscriptionModels\planSubscribersModel;
use App\Models\user_detail_Model;

use App\Models\ReferUsersModels\refAmountModel;
use App\Models\ReferUsersModels\referUsersModel;
use App\Models\ReferUsersModels\refpaymentrequestModel;
use App\Models\ReferUsersModels\refUserDetailsModel;
use App\Models\ReferUsersModels\userbankdetailsModel;
use App\Models\ReferUsersModels\userLedgerModel;



use Illuminate\Http\Request;

class ApiSubscriptionController extends Controller
{

    private $currentDate;
    private $currentTime;
    private $currentDateTime;

    public function __construct()
    {

        date_default_timezone_set("Asia/Calcutta");   //India time (GMT+5:30)

        $currentDateTime = date('Y-m-d H:i:s');
        $currentDate = date('Y-m-d');
        $currentTime = date('H:i:s');

        $this->currentDate = $currentDate;
        $this->currentTime = $currentTime;
        $this->currentDateTime = $currentDateTime;


    }








    public function show_subscription()
    {
        try {
            $data = SubscriptionModel::where('isExpired',0)->get();
            return response()->json([
                'responseMessage' => 'all subscription',
                'responseCode' => 200,
                'responseStatus' =>true,
                'data'=>$data,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'responseMessage' => 'sorry no data found',
                'responseCode' => 401,
                'responseStatus' =>false,
            ]);
        }
    }






    // STORE SUBSCRIBED PLANS--------------------------------------//LAST UPDATED-30-09-2023
    public function save_users_subscribed_plan(Request $request)
    {
        $method = $request->method();
        if ($method == "POST")
        {
            $planId = request('planId');
            if($planId == "")
            {
                return response()->json([
                    'responseStatus' => false,
                    'responseCode' => 400,
                    'responseMessage' => 'planId is mandatory',
                ]);
            }
            else
            {
                $userId = request('userId');
                if($userId == "")
                {
                    return response()->json([
                        'responseStatus' => false,
                        'responseCode' => 400,
                        'responseMessage' => 'userId is mandatory',
                    ]);
                }
                else
                {
                    $transactionNumber= request('transactionNumber');
                    if($transactionNumber == "")
                    {
                        return response()->json([
                            'responseStatus' => false,
                            'responseCode' => 400,
                            'responseMessage' => 'transactionNumber is mandatory',
                        ]);
                    }
                      else {
                        $netPayableAmount = request('netPayableAmount');
                        if ($netPayableAmount == "") {
                            return response()->json([
                                'responseStatus' => false,
                                'responseCode' => 400,
                                'responseMessage' => 'netPayableAmount is mandatory',
                            ]);
                        } 
                    else {
                        $startDate = request('startDate');
                        if ($startDate == "") {
                            return response()->json([
                                'responseStatus' => false,
                                'responseCode' => 400,
                                'responseMessage' => 'startDate is mandatory',
                            ]);
                        } else {
                            $endDate = request('endDate');
                            if ($endDate == "") {
                                return response()->json([
                                    'responseStatus' => false,
                                    'responseCode' => 400,
                                    'responseMessage' => 'endDate is mandatory',
                                ]);
                            } else {
                                try {
                                    //print_r("hai");die;
                                    $store_data = new planSubscribersModel();
                                    $store_data->planId = $planId;
                                    $store_data->uId = $userId;
                                    $store_data->transactionNumber=$transactionNumber;
                                    $store_data->netPayableAmount = $netPayableAmount;
                                    $store_data->startDate = $startDate;
                                    $store_data->endDate = $endDate;
                                    $store_data->save();
                                    $store_user_details = user_detail_Model::where('uId', $userId)->first();
                                    if ($store_user_details) {
                                        $store_user_details->update([
                                            'planId' => $planId,
                                        ]);
                                    }
                                    
                                    
                                    
                                    
                                    
                                    
                                     // if transaction successs work -this

                                     $get_user_id_from_ud=refUserDetailsModel::select('refered_user_Id')
                                     ->where('refer_user_Id',$userId)
                                     ->where('isUserSubscribed',0)
                                     ->value('refered_user_Id');
                                  //  print_r($get_user_id_from_ud);die;
                                   
                                     if ($get_user_id_from_ud) {
                
                                     
                                      date_default_timezone_set("Asia/Calcutta");   //India time (GMT+5:30)
                                      $currentDate = date('Y-m-d');
                                      $currentDateTime = date('Y-m-d H:i:s');
                
                                        $store_user_ledger = new userLedgerModel();
                                        $store_user_ledger->date = $currentDateTime;
                                        $store_user_ledger->user_Id = $get_user_id_from_ud;
                
                                        // REFER AMOUNT
                                        $referAmount = refAmountModel::select('ref_amount')
                                        ->first();
                
                
                                         // Assuming $referAmount contains JSON data like {"ref_amount":100}
                                        $referAmountData = json_decode($referAmount, true); // Convert JSON to PHP array
                                        if (isset($referAmountData['ref_amount'])) {
                                            $store_user_ledger->user_debit = $referAmountData['ref_amount']; // Extract and save the numeric value
                                        }
                                        $store_user_ledger->save();
                                        
                                        
                                            // $store_user_ledger = new userLedgerModel();
                                            // $store_user_ledger->date = $currentDateTime;
                                            // $store_user_ledger->user_Id = $get_user_id_from_ud;
                                            // // $store_user_ledger->user_debit =$referAmount;
                                            // $referAmountData = json_decode($referAmount, true); // Convert JSON to PHP array
                                            // if (isset($referAmountData['ref_amount'])) {
                                            //     $store_user_ledger->user_debit = $referAmountData['ref_amount']; // Extract and save the numeric value
                                            // }
                                            // $store_user_ledger->save();
                                        
                                        
                                        
                                        
                
                                    
                                        
                                        // UPDATE REFER USER DETAILS TABLE 1 USER SUBSCRIBED
                
                                        $select_userdetails=refUserDetailsModel::select('referUserdetails_Id')
                                      // ->where('refer_user_Id',$get_user_id_from_ud)
                                        ->where('refer_user_Id',$userId)
                                        ->where('isUserSubscribed',0)
                                        ->value('referUserdetails_Id');
                                      // print_r($select_userdetails);die;
                
                                        $isUserSubscribed='1';
                                        $UPDATE_USER_DETAILS=refUserDetailsModel::where('referUserdetails_Id',$select_userdetails)
                                        ->update([
                                            'isUserSubscribed' => $isUserSubscribed
                                        ]);
                   
                                     }
                                    
                
                                    // end like this
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    return response()->json([
                                        'responseStatus' => true,
                                        'responseCode' => 200,
                                        'responseMessage' => 'Record saved successfully',

                                    ]);
                                } //try closing
                                catch (\Exception $e) {
                                    return response()->json([
                                        'responseStatus' => false,
                                        'responseCode' => 400,
                                        'responseMessage' => 'Something went wrong, record not saved' . $e->getMessage(),
                                    ]);
                                }//catch closing
                            }//end date closing
                        }//start date closing
                    }//netpayable
                    }//transactionNumber closing
                }//userId closing
            }//plan else closing
        }
        else
        {
            return response()->json([
                'responseStatus' =>false,
                'responseCode' => 404,
                'responseMessage' => 'INCORRECT METHOD, ACCESS DENIED',
            ]);
        }
    } 
    
   





     // get user subscription palan details--------------

     public function getusersubscriptions_app(Request $request)
     {

        $method = $request->method();
        if ($method == "POST")
        {

            $userId = request('userId');
            if($userId == "") 
            {
                return response()->json([
                    'responseStatus' => false,
                    'responseCode' => 400,
                    'responseMessage' => 'userId is mandatory',
                ]);
            }

  
            try {
                
                $data = SubscriptionModel::select('subscriptions.*', 'app_subscriber.*')
                    ->join('app_plan_subscribers as app_subscriber', 'app_subscriber.planId', '=', 'subscriptions.planId')
                    ->join('user_details', 'user_details.uId', '=', 'app_subscriber.uId')
                    ->where('app_subscriber.isExpired','=',0)
                    ->where('app_subscriber.uId', $userId)
                    ->orderBy('app_subscriber.created_at', 'desc')//new added 1
                    ->take(1) //new added2
                    ->get();
            
                if ($data->isEmpty()) {
                    return response()->json([
                        'responseMessage' => 'SORRY NO DATA FOUND',
                        'responseCode' => 404, 
                        'responseStatus' => false,
                    ]);
                }
            
                return response()->json([
                    'responseMessage' => 'DATA FETCH SUCCESSFULLY',
                    'responseCode' => 200,
                    'responseStatus' => true,
                    'data' => $data,
                ]);
            
            } catch (\Exception $e) {
                return response()->json([
                    'responseMessage' => 'INTERNAL SERVER ERROR', 
                    'responseCode' => 500, // Internal Server Error
                    'responseStatus' => false,
                ]);
            }
            


    }
    else 
    {
        return response()->json([
            'responseStatus' =>false,
            'responseCode' => 404,
            'responseMessage' => 'INCORRECT METHOD, ACCESS DENIED',
        ]);
    }




 }





}
