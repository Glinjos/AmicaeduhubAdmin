<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;

use Illuminate\Http\Request;


use DB;

use App\Models\User;
use App\Models\user_detail_Model;

use App\Models\SubscriptionModels\planSubscribersModel;
use App\Models\SubscriptionModels\SubscriptionModel;

use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Session;




class PlanvalidityController extends Controller
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

    public function show_add_plan_form(Request $request){
        return view('planExpire_sadmin.planshow_sm');
    }

    public function searchusersplans(Request $request){
        $selValue = $request->input('selvalue');

        // Check for empty or null value
        if (!isset($selValue) || empty($selValue)) {
            return response()->json(0);
        }
        $checkUser = DB::select("SELECT DISTINCT plan.apsId,det.name,det.mobile,sub.planName,plan.startDate,plan.endDate,plan.isExpired
        FROM `app_plan_subscribers` as plan
        JOIN `user_details` as det on det.uId= plan.uId
        JOIN `subscriptions` as sub on sub.planId=plan.planId
        WHERE (det.name  LIKE '%$selValue%' OR det.mobile LIKE '%$selValue%')  AND (plan.uId, plan.apsId) IN (
        SELECT
            uId,
            MAX(apsId) AS maxapsId
        FROM
            `app_plan_subscribers`
        GROUP BY
            uId
    );");

        $planNames=DB::select("SELECT planId,planName FROM `subscriptions` WHERE isAvail =0 AND isExpired IN (0, 2)");
        

        $responseData = [
            'checkUser' => $checkUser,
            'planNames' => $planNames,
        ];
        
        return response()->json($responseData);

    }

    // update
    public function update_user_plan_extend(Request $request){

        $planId = $request->input('planId');
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $apsId = $request->input('apsId');
       // echo $planId;

        $offerPrice=SubscriptionModel::where('planId',$planId)->value('offerPrice');

        if($offerPrice){

            $uId=planSubscribersModel::where('apsId',$apsId)->value('uId');

            if($uId){

                

                $isExpired=0;

                $updateAppPlan=planSubscribersModel::where('apsId',$apsId)
                ->update([
                    'planId' => $planId,
                    'netPayableAmount' => $offerPrice,
                    'startDate' => $startDate,
                    'endDate' => $endDate,
                    'isExpired' => $isExpired
                ]);

                $userdetailsPlan=user_detail_Model::where('uId',$uId)
                ->update([
                     'planId' => $planId
                ]);
                
                $getAPPplanExpirestatus=planSubscribersModel::where('apsId',$apsId)->value('isExpired');

                $responseData = [
                    'status' => 'success',
                    'getAPPplanExpirestatus' => $getAPPplanExpirestatus,
                ];
                
                return response()->json($responseData);

                


            }else{
                return response()->json('failed');
            }

        }else{
            return response()->json('failed');
        }



    }


}
