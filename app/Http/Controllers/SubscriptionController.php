<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubscriptionModel;
use App\Models\SubscriptionModels\planSubscribersModel;
use App\Models\user_detail_Model;
use DB;
use Illuminate\Support\Facades\Validator;
class SubscriptionController extends Controller
{

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

// SUBSCRIPTION FORM

    public function subscriptionForm(){

       // $subscription_details = SubscriptionModel::orderBy('isAvail', 'asc')->orderBy('planId', 'desc')->get();
        $subscription_details = SubscriptionModel::select()->where('isExpired','=','0')->orWhere('isExpired','=','1')->orderBy('isExpired','ASC')->get();
        return view('subscription/subscriptionAddForm',compact('subscription_details'));
     }

// ADD SUBSCRIPTION
    
    public function subscription_add(Request $request){
        $validator = Validator::make($request->all(), [
            'planName' => 'required',
            'actualPrice' => 'required|numeric',
            'offerPrice' => 'required|numeric',
            'planValidity' => 'required|numeric',
            
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $isAvail='0';
        $created_by=request('user_id');
        $updated_by='0';
        $isExpired='0';
       // $created_at= $this->currentDateTime;
       // $updated_at= $this->currentDateTime;

        
        $planName           = $request->get('planName');
        $actualPrice        = $request->get('actualPrice');
        $offerPrice         = $request->get('offerPrice');
        $planDescription    = $request->get('planDescription');
        $planValidity       = $request->get('planValidity');


        if($request->get('previousQuestion'))
        {
            $previousQuestion= $request->get('previousQuestion');
        }
        else
        {
            $previousQuestion="0";
        }
        if($request->get('videoClass'))
        {
            $videoClass= $request->get('videoClass');
        }
        else
        {
            $videoClass="0";
        }
        if($request->get('crashCourse'))
        {
            $crashCourse= $request->get('crashCourse');
        }
        else
        {
            $crashCourse="0";
        }
        if($request->get('gameZone'))
        {
            $gameZone= $request->get('gameZone');
        }
        else
        {
            $gameZone="0";
        }
        if($request->get('modelExams'))
        {
            $modelExams= $request->get('modelExams');
        }
        else
        {
            $modelExams="0";
        }
        
        
        

        SubscriptionModel::create(
            [
                'isAvail' =>$isAvail,
                'isExpired' =>$isExpired,
                'planName' =>$planName,
                'actualPrice' =>$actualPrice, 
                'offerPrice' =>$offerPrice,
                'planDescription' =>$planDescription,
                'planValidity' =>$planValidity,
                'previousQuestion' =>$previousQuestion,
                'videoClass' =>$videoClass, 
                'crashCourse' =>$crashCourse,
                'gameZone' =>$gameZone,
                'modelExams' =>$modelExams,
                'created_by' => $created_by,
               // 'created_at' => $created_at,
                'updated_by' => $updated_by,
               // 'updated_at' => $updated_by,
                
            ]);

        return redirect()->back()->with('success','Subscription Added Successfully');
    }

// UPDATE SUBSCRIPTION FORM

    public function update_Subscription($planId){

        $subscription_details  = SubscriptionModel::where('planId',$planId)->get();
        return view('subscription/subscription_update_form',compact('subscription_details'));
    }

// SUBSCRIPTION UPDATE

    public function Subscription_details_update(Request $request,$planId){
        $validator = Validator::make($request->all(), [
            'planName' => 'required',
            'actualPrice' => 'required|numeric',
            'offerPrice' => 'required|numeric',
            'planValidity' => 'required|numeric',
            
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        
        $updated_by=request('user_id');
        $updated_at= $this->currentDateTime;

        
        $planName           = $request->get('planName');
        $actualPrice        = $request->get('actualPrice');
        $offerPrice         = $request->get('offerPrice');
        $planDescription    = $request->get('planDescription');
        $planValidity       = $request->get('planValidity');
       
        if($request->get('previousQuestion'))
        {
            $previousQuestion="1";
        }
        else
        {
            $previousQuestion="0";
        }
        if($request->get('videoClass'))
        {
            $videoClass= "1";
        }
        else
        {
            $videoClass="0";
        }
        if($request->get('crashCourse'))
        {
            $crashCourse="1";
        }
        else
        {
            $crashCourse="0";
        }
        if($request->get('gameZone'))
        {
            $gameZone="1";
        }
        else
        {
            $gameZone="0";
        }
        if($request->get('modelExams'))
        {
            $modelExams="1";
        }
        else
        {
            $modelExams="0";
        }
        

        $subscription_details = SubscriptionModel::find($planId);

        $subscription_details->update([

            
            
            'planName' =>$planName,
            'actualPrice' =>$actualPrice, 
            'offerPrice' =>$offerPrice,
            'planDescription' =>$planDescription,
            'planValidity' =>$planValidity,
            'previousQuestion' =>$previousQuestion,
            'videoClass' =>$videoClass, 
            'crashCourse' =>$crashCourse,
            'gameZone' =>$gameZone,
            'modelExams' =>$modelExams,
            'updated_by' => $updated_by,
            'updated_at' => $updated_by,
            ]);
           

            return redirect('/subscription')->with('success','Subscription Plan updated Successfully');
    }



// DEACTIVATE SUBSCRIPTION

    public function Inactive_Subscription($planId){
        $isAvail  = 1;

        $SubscriptionPlan     = SubscriptionModel::find($planId);
        $SubscriptionPlan->update([
            'isExpired' => $isAvail,
        ]);

        return redirect()->back()->with('success','Subscription Plan Deactivated');
    }


// ACTIVATE DESCRIPTION

    public function Active_Subscription($planId){
        $isAvail = 0;

        $SubscriptionPlan = SubscriptionModel::find($planId);

        $SubscriptionPlan->update([
            'isExpired' => $isAvail,
        ]);

        return redirect()->back()->with('success','Subscription Plan activated');
    
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    



    // APP SUBSCRIBERS FUNCTIONS START HERE------------------------------

    public function showappplansubscribers()
    {

        $plan_details =SubscriptionModel::select('planId','planName','offerPrice','planValidity')
        ->where('isExpired',0)
        ->get();

        return view('subscription.show_plans_from_subscribers',compact('plan_details'));
    }


    public function planSubscribers_details($planId)
    {
        $plan_name=SubscriptionModel::select('planName')
        ->where('planId',$planId)
        ->get();

        $app_plan_subscribers = planSubscribersModel::select('app_plan_subscribers.*','user_details.name','user_details.mobile')
        ->join('subscriptions as subscriptions', 'subscriptions.planId', '=', 'app_plan_subscribers.planId')
        ->join('user_details as user_details', 'user_details.uId', '=', 'app_plan_subscribers.uId')
        ->where('app_plan_subscribers.isExpired', 0)
        ->where('app_plan_subscribers.planId', $planId)
        ->orderBy('app_plan_subscribers.uId','desc')
        ->get();


       // print_r($app_plan_subscribers);die;
        
        return view('subscription.show_single_plan_subscribers',compact('plan_name','app_plan_subscribers'));
    }


    
    // APP SUBSCRIBERS FUNCTIONS END HERE------------------------------



     // PAYMENT HISTORY

    public function showpaymenthist_sup()
    {
        $payment_his=DB::select("SELECT app_plan.startDate,app_plan.transactionNumber,det.name,det.mobile,sub.planName,app_plan.netPayableAmount
        FROM `app_plan_subscribers` as app_plan
        JOIN `subscriptions` as sub on sub.planId = app_plan.planId
        JOIN `user_details` as det on det.uId = app_plan.uId
        WHERE sub.isExpired !='2'
        ORDER BY app_plan.startDate DESC;");
        return view('subscription.show_payment_hist',compact('payment_his'));
    }

    //END


    
    
    
    
    
    
    
}
