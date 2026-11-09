<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use DB;
use Illuminate\Support\Facades\Crypt;

use App\Models\user_detail_Model;
use App\Models\ReferUsersModels\referUsersModel;
use App\Models\ReferUsersModels\refAmountModel;
use App\Models\ReferUsersModels\refpaymentrequestModel;
use App\Models\ReferUsersModels\userbankdetailsModel;
use App\Models\ReferUsersModels\userLedgerModel;

use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Session;

class refferedUsersController extends Controller
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





    /// form function 
    public function reffered_amount_form()
    {
       
       $reffer_amount=refAmountModel::select()->get();

        return view('refferal_data.show_referred_amount',compact('reffer_amount'));
    }


    // VIEW MORE 
    public function referamountupdate($refamount_Id)
    {

       
       $update_refamount=refAmountModel::select()->where('refamount_Id',$refamount_Id)->get();
      

        return view('refferal_data.edit_referred_amount',compact('update_refamount'));
    }

    public function updateamountrefer(Request $request)
    {

        $amount = request('ref_amount');
        $refamount_Id= request('refamount_Id');

        $update_amount_table=refAmountModel::where('refamount_Id',$refamount_Id)->update(['ref_amount'=>$amount]);

        return redirect("/reffered_amount_form")->with('success', 'Amount Updated');

    }



    public function user_payment_request()
    {

        $pay_req=refpaymentrequestModel::select('request_Id','req_user_Id','req_date','det.name','req_coin','isRequested','remark')
        ->join('user_details as det','det.uId','=','ref_payment_request.req_user_Id')
        ->orderBy('request_Id','DESC')
        ->where('isRequested',0)
        ->get();

        return view('refferal_data.show_payment_req',compact('pay_req'));
    }


    public function users_details_bnk(Request $request)
    {

        $req_user_Id= request('req_user_Id');
       // dd($req_user_Id);
       $bank_details = userbankdetailsModel::select('ref_user_bank_details.*', 'det.name')
        ->join('ref_payment_request as req', 'req.req_user_Id', '=', 'ref_user_bank_details.b_userId')
        ->join('user_details as det', 'det.uId', '=', 'ref_user_bank_details.b_userId')
        //->where('req.isRequested', 0)  
        ->where('req.req_user_Id', $req_user_Id)         
        ->get();
   
        // dd($bank_details);
        return $bank_details;
    }


    public function userrequestapprove(Request $request,$request_Id,$userId)
    {


        date_default_timezone_set("Asia/Calcutta");   //India time (GMT+5:30)
        $currentDate = date('Y-m-d');
        $pay_req_update = refpaymentrequestModel::find($request_Id);

        $pay_req_update->update(['isRequested' => 1,'req_accepted_date'=>$currentDate,'updated_by',$userId]);
        return redirect()->back()->with('success','User Request Approved');

    }



    public function add_user_payment()
    {

       $get_pay_request_user =refpaymentrequestModel::select('ref_payment_request.*','det.name')
       ->join('user_details as det','det.uId','=','ref_payment_request.req_user_Id')
       ->where('isRequested',1)
       ->get();

        return view('refferal_data.add_user_payment',compact('get_pay_request_user'));
    }
   

    public function check_user_credit_amount(Request $request)
    {

        $user_name_pay=request('user_name_pay');

        $credit_amount=refpaymentrequestModel::select('req_coin','req_user_Id')
        ->where('request_Id',$user_name_pay)
        ->get();

        //dd($user_name_pay);
        return $credit_amount;
    }


    public function save_user_payment_ami(Request $request)
    {

        $validatedData = $request->validate([
            'user_name_pay' => 'required',
            'req_user_Id' => 'required',
            'user_pay_amount' => 'required',
            'user_pay_date' => 'required',

        ], [
             'user_name_pay.required' => 'This field is required.',
             'req_user_Id.required' => 'This field is required.',
             'user_pay_amount.required' => 'This field is required.',
             'user_pay_date.required' => 'This field is required.',
        ]);

        $user_name_pay   = request('user_name_pay');
        $req_user_Id     = request('req_user_Id');
        $user_pay_amount = request('user_pay_amount');
        
        $user_pay_date   = request('user_pay_date');
        
         date_default_timezone_set("Asia/Calcutta");   //India time (GMT+5:30)
        // $currentDate = date('Y-m-d');
        $currentDateTime = date('H:i:s');
        $combined_datetime = $user_pay_date . ' ' . $currentDateTime;
        
        
        
        
        

        $userDetail  =user_detail_Model::select('name')
        ->where('uId','=',$req_user_Id)
        ->first(); 

        if ($userDetail) {
            $req_user_name = $userDetail->name;
        } else {
            
            $req_user_name = "Unknown User";
        }

        $remark = " $req_user_name requested $user_pay_amount amount paid by amica.";

        $isRequested = 2;

        $save_user_ledger = new userLedgerModel();
        $save_user_ledger->date        =$combined_datetime;
        $save_user_ledger->user_Id     =$req_user_Id;
        $save_user_ledger->user_credit =$user_pay_amount;
        $save_user_ledger->request_Id  =$user_name_pay;
        $save_user_ledger->remark      =$remark;
        $save_user_ledger->save();

        $update_pay_req=refpaymentrequestModel::where('request_Id',$user_name_pay)
        ->update(['isRequested'=>$isRequested]);


        return redirect()->back()->with('success','User Payment Added');


    }



    // USERS AND PAYMENT HISTORIES
    public function show_total_user_payments()
    {

        $total_users_pay=DB::select("SELECT 
        det.name, 
        ref_user_ledger.user_Id,
        COALESCE(SUM(ref_user_ledger.user_debit), 0) as total_debit,
        COALESCE(SUM(ref_user_ledger.user_credit), 0) as total_credit
    FROM 
        ref_user_ledger
    JOIN 
        user_details as det 
        ON det.uId = ref_user_ledger.user_Id
    GROUP BY 
        det.name, ref_user_ledger.user_Id;");

        return view('refferal_data.show_total_users_payment',compact('total_users_pay'));
    }

    // Ledger START HERE
    public function show_user_single_report($user_Id)
    {

        $user_name=user_detail_Model::select('name')
        ->where('uId','=',$user_Id)
        ->get();

        $ledger=userLedgerModel::select()
        ->where('user_Id','=',$user_Id)
        ->get();

        return view('refferal_data.show_users_ledger',compact('user_name','ledger'));
    }




    


}
