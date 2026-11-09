<?php

namespace App\Http\Controllers;


use App\Models\ReferUsersModels\refAmountModel;
use App\Models\ReferUsersModels\referUsersModel;
use App\Models\ReferUsersModels\refpaymentrequestModel;
use App\Models\ReferUsersModels\refUserDetailsModel;
use App\Models\ReferUsersModels\userbankdetailsModel;
use App\Models\ReferUsersModels\userLedgerModel;
use DB;

class ApiReferralController extends Controller
{
    //store users bank details
    public function storeUserBankDetails(){
        $b_userId=request('b_userId');
        $ac_number=request('ac_number');
        $upi_number=request('upi_number');
        $upi_id=request('upi_id');
        $ifc_code=request('ifc_code');
        $ac_holder_name = request('ac_holder_name');
        $remark = request('remark');
        try {
            $storeUserBankDetails = new userbankdetailsModel();
            $data = [
            'b_userId'=>$b_userId,
            'ac_number'=>$ac_number,
            'upi_number'=>$upi_number,
            'upi_id'=>$upi_id,
            'ifc_code'=>$ifc_code,
            'ac_holder_name'=>$ac_holder_name,
            'remark'=>$remark,
            ];
            $data = array_filter($data, function ($value) {
                return $value !== null;
            });
            $storeUserBankDetails->fill($data);
            $storeUserBankDetails->save();
            return response()->json([
                'responseStatus' =>true,
                'responseCode' => 200,
                'responseMessage' => 'Record saved successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'responseStatus' => false,
                'responseCode' => 400,
                'responseMessage' => 'Something went wrong, record not saved '. $e,
            ]);
        }
    }

    //store users coin request
    public function storeUserCoinRequests(){
        $req_user_Id=request('req_user_Id');
        if($req_user_Id==""){
            return response()->json([
                'responseStatus' => false,
                'responseCode' => 400,
                'responseMessage' => 'req_user_Id is mandatory',
            ]);
        }
        else{
            $req_coin=request('req_coin');
            if($req_coin==""){
                return response()->json([
                    'responseStatus' => false,
                    'responseCode' => 400,
                    'responseMessage' => 'req_coin is mandatory',
                ]);
            }
            else {
                $created_by = request('created_by');
                if($created_by==""){
                    return response()->json([
                        'responseStatus' => false,
                        'responseCode' => 400,
                        'responseMessage' => 'created_by is mandatory',
                    ]);
                }
                else {
                    $req_date=request('req_date');
                    $remark = request('remark');
                    try {
                        date_default_timezone_set("Asia/Calcutta");   //India time (GMT+5:30)
                        $currentDate = date('Y-m-d');
                        $currentDateTime = date('Y-m-d H:i:s');
                        $storeUserBankDetails = new refpaymentrequestModel();
                        $data = [
                            'req_date'=>$currentDateTime,
                            'req_user_Id'=>$req_user_Id,
                            'req_coin'=>$req_coin,
                            'remark'=>$remark,
                            'created_by'=>$created_by,
                        ];
                        $data = array_filter($data, function ($value) {
                            return $value !== null;
                        });
                        $storeUserBankDetails->fill($data);
                        $storeUserBankDetails->save();
                        return response()->json([
                            'responseStatus' =>true,
                            'responseCode' => 200,
                            'responseMessage' => 'Record saved successfully',
                        ]);
                    } catch (\Exception $e) {
                        return response()->json([
                            'responseStatus' => false,
                            'responseCode' => 400,
                            'responseMessage' => 'Something went wrong, record not saved '. $e,
                        ]);
                    }
                }
            }
        }
    }


    // //fetch my referral code
    // public function showMyReferralCode(){
    //     $uId = request('uId');
    //     if ($uId == "") {
    //         return response()->json([
    //             'responseMessage' => 'uId is mandatory',
    //             'responseCode' => 401,
    //             'responseStatus' => false,
    //         ]);
    //     } else {
    //         $data =DB::table('refer_users')
    //             ->where('refer_user_Id','=',$uId)
    //             ->pluck('referral_code');
    //         $count = $data->Count();
    //         if ($count > 0) {
    //             return response()->json([
    //                 'responseMessage' => 'My referral code',
    //                 'responseCode' => 200,
    //                 'responseStatus' => true,
    //                 'data' => $data,
    //             ]);
    //         } else {
    //             //no data found
    //             return response()->json([
    //                 'responseMessage' => 'sorry no data found',
    //                 'responseCode' => 401,
    //                 'responseStatus' => false,
    //             ]);
    //         }
    //     }
    // }

    //fetch my referred users details
    public function showMyReferredUserDetails(){
        $uId = request('uId');
        if ($uId == "") {
            return response()->json([
                'responseMessage' => 'uId is mandatory',
                'responseCode' => 401,
                'responseStatus' => false,
            ]);
        } else {
            $data = refUserDetailsModel::select('refer_users_details.date', 'user_details.name', 'user_details.mobile','user_details.userImage')
                ->join('user_details', 'refer_users_details.refer_user_Id', '=', 'user_details.uId')
                ->where('refer_users_details.refered_user_Id', $uId)
                ->get();
            $count = $data->Count();
            if ($count > 0) {
                return response()->json([
                    'responseMessage' => 'My referral code',
                    'responseCode' => 200,
                    'responseStatus' => true,
                    'data' => $data,
                ]);
            } else {
                //no data found
                return response()->json([
                    'responseMessage' => 'sorry no data found',
                    'responseCode' => 401,
                    'responseStatus' => false,
                ]);
            }
        }
    }

    // //fetch coin prize
    // public function showCoinPrize(){
    //     try {
    //         $data = refAmountModel::select('ref_amount',
    //             'ref_type')->get();
    //         return response()->json([
    //             'responseMessage' => 'Referral amount',
    //             'responseCode' => 200,
    //             'responseStatus' =>true,
    //             'data'=>$data,
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'responseMessage' => 'sorry no data found',
    //             'responseCode' => 401,
    //             'responseStatus' =>false,
    //         ]);
    //     }
    // }

    //show user bank details
    public function showUserBankDetails(){
        $uId = request('uId');
        if ($uId == "") {
            return response()->json([
                'responseMessage' => 'uId is mandatory',
                'responseCode' => 401,
                'responseStatus' => false,
            ]);
        } else {
            $data = userbankdetailsModel::select([
                'ref_user_bank_details.ac_number',
                'ref_user_bank_details.upi_number',
                'ref_user_bank_details.upi_id',
                'ref_user_bank_details.ifc_code',
                'ref_user_bank_details.ac_holder_name',
                'ref_user_bank_details.remark',
                'user_details.name'
            ])
                ->join('user_details', 'ref_user_bank_details.b_userId', '=', 'user_details.uId')
                ->where('ref_user_bank_details.b_userId',$uId)
                ->get();
            $count = $data->Count();
            if ($count > 0) {
                return response()->json([
                    'responseMessage' => 'My referral code',
                    'responseCode' => 200,
                    'responseStatus' => true,
                    'data' => $data,
                ]);
            } else {
                //no data found
                return response()->json([
                    'responseMessage' => 'sorry no data found',
                    'responseCode' => 401,
                    'responseStatus' => false,
                ]);
            }
        }
    }

    //show my coins sum
    public function showSumCoins(){
        $uId = request('uId');
        if ($uId == "") {
            return response()->json([
                'responseMessage' => 'uId is mandatory',
                'responseCode' => 401,
                'responseStatus' => false,
            ]);
        } else {
            
           // print_r($uId);die;
          
          
                // try {
                //     $data = DB::select("SELECT
                //                 SUM(COALESCE(ref_user_ledger.user_debit, 0)) - SUM(COALESCE(ref_user_ledger.user_credit, 0)) - COALESCE(req_sum.req_coin, 0) AS user_balance_coins
                //             FROM `ref_user_ledger`
                //             LEFT JOIN (
                //                 SELECT req_user_Id, SUM(COALESCE(CASE WHEN isRequested = 0 OR isRequested = 1 THEN req_coin ELSE 0 END, 0)) AS req_coin
                //                 FROM `ref_payment_request`
                //                 WHERE isRequested = 0 OR isRequested = 1
                //                 GROUP BY req_user_Id
                //             ) AS req_sum ON req_sum.req_user_Id = ref_user_ledger.user_Id
                //             WHERE ref_user_ledger.user_Id = $uId);
                    
                //     print_r($data); 
                // } catch (\Exception $e) {
                //     echo "Error: " . $e->getMessage(); 
                // }
                
             $data =DB::select(" SELECT
        (SELECT COALESCE(SUM(user_debit), 0) FROM ref_user_ledger WHERE user_Id = $uId) -
        (SELECT COALESCE(SUM(user_credit), 0) FROM ref_user_ledger WHERE user_Id = $uId) -
        (SELECT COALESCE(SUM(CASE WHEN isRequested = 0 OR isRequested = 1 THEN req_coin ELSE 0 END), 0) FROM ref_payment_request WHERE req_user_Id = $uId) AS user_balance_coins");


              $referal_user_code=referUsersModel::select('referral_code')
              ->where('refer_user_Id','=',$uId)
              ->first();
        
              $referAmount_user=refAmountModel::select('ref_amount')->first();
              // print_r($data);die;

            

            if ($data) {
                return response()->json([
                    'responseMessage' => 'My coins',
                    'responseCode' => 200,
                    'responseStatus' => true,
                    'referral_code'=>$referal_user_code->referral_code,
                    'referral_amount'=>$referAmount_user->ref_amount,
                    'data' => $data,
                    
                ]);
            } else {
                return response()->json([
                    'responseMessage' => 'sorry no data found',
                    'responseCode' => 401,
                    'responseStatus' => false,
                ]);
            }
            
            
        }
    }

    //show my ledger
    public function showMyLedger(){
        $uId = request('uId');
        if ($uId == "") {
            return response()->json([
                'responseMessage' => 'uId is mandatory',
                'responseCode' => 401,
                'responseStatus' => false,
            ]);
        } else {


            // $data = userLedgerModel::select()
            //     ->where('user_Id','=',$uId)
            //     ->get();

            $data = DB::select("SELECT req.req_date AS date, NULL AS user_debit, NULL AS user_credit, req.req_coin AS request_coin
                    FROM ref_payment_request AS req
                    WHERE req.req_user_Id = '$uId'
                    UNION ALL
                    SELECT ref_user_ledger.date, ref_user_ledger.user_debit, ref_user_ledger.user_credit, NULL AS request_coin
                    FROM ref_user_ledger
                    WHERE ref_user_ledger.user_id = '$uId'
                    ORDER BY date DESC");


            if ($data) {
                return response()->json([
                    'responseMessage' => 'My coins',
                    'responseCode' => 200,
                    'responseStatus' => true,
                    'data' => $data,
                ]);


            } else {
                return response()->json([
                    'responseMessage' => 'sorry no data found',
                    'responseCode' => 401,
                    'responseStatus' => false,
                ]);
            }
        }
    }

    //store users referral details in two tabled leder,user details
    public function storeReferAmount(){
        $uId = request('uId');
        if ($uId == "") {
            return response()->json([
                'responseMessage' => 'uId is mandatory',
                'responseCode' => 401,
                'responseStatus' => false,
            ]);
        }
        $referral_code = request('referral_code');
        if ($referral_code == "") {
            return response()->json([
                'responseMessage' => 'referral_code is mandatory',
                'responseCode' => 401,
                'responseStatus' => false,
            ]);
        }
        
        
         $referal_code_checking=referUsersModel::select('referral_code')
        -> where('referral_code', $referral_code)
        ->get();
      


        if ($referal_code_checking->count() > 0) 
        {

        
        try {
            $refer_user_id = referUsersModel::select('refer_user_Id')
                ->where('referral_code', '=', $referral_code)
                ->first();
                
           

            if ($refer_user_id) {
                $referUserIdValue = $refer_user_id->refer_user_Id;
                
            }
            
            // print_r($referUserIdValue);die;

            $referAmount = refAmountModel::select('ref_amount')
                ->first();
            date_default_timezone_set("Asia/Calcutta"); 
            $currentDate = date('Y-m-d');
            $currentDateTime = date('Y-m-d H:i:s');

            $store_user_ledger = new userLedgerModel();
            $store_user_ledger->date = $currentDateTime;
            $store_user_ledger->user_Id = $referUserIdValue;
        
            $referAmountData = json_decode($referAmount, true); 
            if (isset($referAmountData['ref_amount'])) {
                $store_user_ledger->user_debit = $referAmountData['ref_amount']; 
            }
            $store_user_ledger->save();

           

            $store_refUserDetails = new refUserDetailsModel();
            $store_refUserDetails->date = $currentDate;
            $store_refUserDetails->refered_user_Id = $referUserIdValue;
            $store_refUserDetails->refer_user_Id = $uId;
            $store_refUserDetails->save();

            return response()->json([
                'responseMessage' => 'stored successfully.',
                'responseCode' => 200,
                'responseStatus' => true,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'responseMessage' => 'sorry no data found',
                'responseCode' => 401,
                'responseStatus' =>false,
            ]);
        }
        
        
        
    }
    else
    {
        return response()->json([
            'responseMessage' => 'Invalid Referal Code',
            'responseCode' => 401,
            'responseStatus' =>false,
        ]);
    }
        
        
        
        
    }



    // Bank details update
     //store users bank details
     public function updateUserBankDetails(){
        $b_userId=request('b_userId');

        $ac_number=request('ac_number');
        $upi_number=request('upi_number');
        $upi_id=request('upi_id');
        $ifc_code=request('ifc_code');
        $ac_holder_name = request('ac_holder_name');
        $remark = request('remark');
        try {
            $storeUserBankDetails =userbankdetailsModel::where('b_userId',$b_userId)
            ->update([
                //'b_userId'=>$b_userId,
                'ac_number'=>$ac_number,
                'upi_number'=>$upi_number,
                'upi_id'=>$upi_id,
                'ifc_code'=>$ifc_code,
                'ac_holder_name'=>$ac_holder_name,
                'remark'=>$remark,
            ]);
            return response()->json([
                'responseStatus' =>true,
                'responseCode' => 200,
                'responseMessage' => 'Record updated successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'responseStatus' => false,
                'responseCode' => 400,
                'responseMessage' => 'Something went wrong, record not saved '. $e,
            ]);
        }
    }
    
    
    //store users coin in credit app plan subscription time
    public function storeCreditAppSub(){
        $user_Id=request('user_Id');
        if($user_Id==""){
            return response()->json([
                'responseStatus' => false,
                'responseCode' => 400,
                'responseMessage' => 'user_Id is mandatory',
            ]);
        }
        else{
            $user_credit=request('user_credit');
            if($user_credit==""){
                return response()->json([
                    'responseStatus' => false,
                    'responseCode' => 400,
                    'responseMessage' => 'user_credit is mandatory',
                ]);
            }
            else {
                    $date=request('date');
                    $remark = request('remark');
                    try {
                        date_default_timezone_set("Asia/Calcutta");   //India time (GMT+5:30)
                        $currentDate = date('Y-m-d');
                        $store_user_credit = new userLedgerModel();
                        $data = [
                            'date'=>$currentDate,
                            'user_Id'=>$user_Id,
                            'user_credit'=>$user_credit,
                            'remark'=>$remark,
                        ];
                        $store_user_credit->fill($data);
                        $store_user_credit->save();

                        return response()->json([
                            'responseStatus' =>true,
                            'responseCode' => 200,
                            'responseMessage' => 'Record saved successfully',
                        ]);
                    } catch (\Exception $e) {
                        return response()->json([
                            'responseStatus' => false,
                            'responseCode' => 400,
                            'responseMessage' => 'Something went wrong, record not saved '. $e,
                        ]);
                    }
                }
            }
        }
    
    
    
    
    
    
    
    
    
    

}
