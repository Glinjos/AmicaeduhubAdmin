<?php
/**
 * Created by vsCode.
 * Use: API (FLUTTER) Previous Question Bank
 * this files related to previous question papers
 */
namespace App\Http\Controllers;

use Illuminate\Routing\Controller;

use Illuminate\Http\Request;
use App\Models\ModuleModel;
use App\Models\PreviousExamModels\PreviousExamCatogoryModel;
use App\Models\PreviousExamModels\PreviousExamSubModuleModel;
use App\Models\PreviousExamModels\PreviousQuestionModel;
use App\Models\PreviousExamModels\PreviousAnswerModel;
use App\Models\advertisementsModel;
use App\Models\pqmainModel;
use DB;
use App\Models\user_detail_Model;
use App\Models\SubscriptionModel;
use App\Models\SubscriptionModels\planSubscribersModel;

use App\Models\loginIP\appLoginModel;

use App\Models\userdevicetokenModel;

use App\Models\ReferUsersModels\referUsersModel;
use Illuminate\Support\Str;

use GrahamCampbell\ResultType\Success;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Session;


class ApiPreviousExamController extends Controller
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

    public function getCurrentDate()
    {
        return $this->currentDate;
    }
    
    
    
    
    
    
    
    
    

      
        public function sendsms($Template,$modifiedPhone,$otp)
        {
        
            $client = new \GuzzleHttp\Client();
            $response = $client->request('POST', 'https://control.msg91.com/api/v5/flow/', [
            'body' => '{
                "template_id":"'.$Template.'",
                "sender":"AMIHUB",
                "short_url":"1",
                "mobiles":"'.$modifiedPhone.'",
                "var":"'.$otp.'"
            }',
            'headers' => [
                'accept' => 'application/json',
                'authkey' => '403785AnMJXQDJlU64deffc4P1',
                'content-type' => 'application/json',
            ],
            ]);

            return $response->getBody();
        }






        //SIGNIN FORM
        //name,phone number,otp generate
        public function signup(){
        
            $name = request('name');
            $phone = request('phone');
          //  $modifiedPhone = request('phone');
            $modifiedPhone = '91' . $phone;
            // Now $modifiedPhone contains the phone number with "91" appended to it


             // here token starting 

            $tokenNotify= request('notifyToken');

             // end here
         
         

            
            // $otp = "1111"; 
               $otp =rand(1000,9999);  //generate random numbers


            if($name==""){
            
                        return response()->json([
                        'responseMessage' => 'please enter name',
                        'responseCode' => 401,
                        'responseStatus' =>false,]); 
                        
            }elseif($phone==""){

                        return response()->json([
                        'responseMessage' => 'please enter phonenumber',
                        'responseCode' => 401,
                        'responseStatus' =>false,]);

            }
             elseif($tokenNotify==""){

            return response()->json([
            'responseMessage' => 'please enter notifyToken',
            'responseCode' => 401,
            'responseStatus' =>false,]);

            }
            else{

              
                    $n=16;
                    $characters = 'abglinjostuvwxyz973291737344ABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()';
                    $randomString = '';
                 
                    for ($i = 0; $i < $n; $i++) {
                        $index = rand(0, strlen($characters) - 1);
                        $randomString .= $characters[$index];
                    }
                 
                   
   // $planId = SubscriptionModel::select('planId')->where('isExpired', '=', '2')->pluck('planId')->first();
       
       

     $if_exist=user_detail_Model::select()->where('mobile',$phone)->where('ActiveUser','=','0')->get();
     $if_exist_second=user_detail_Model::select()->where('mobile',$phone)->where('ActiveUser','=','1')->get();
     
    // print_r($if_exist_second);die;
     
      if($if_exist_second->isEmpty()){ 
    // print_r($if_exist);die;
               
               
                if($if_exist->Count()==0){     //user not found

                 //  print_r("$if_exist");die;

                    // print_r($if_exist);
                    // print_r('Fresh user');die;
                //insert into database
                            $result = new user_detail_Model;
                            $result->name = $name;
                            $result->mobile = $phone;
                            $result->otp = $otp;
                           // $result->planId = $planId;
                            $result->onlinetoken= $randomString;
                            $result->created_by='1';
                            $result->save();


                             // here is the code start

                            $uId = $result->uId;
                        
                            $insertsignupTimephonetoken = new userdevicetokenModel;
                            $insertsignupTimephonetoken->uId = $uId;
                            $insertsignupTimephonetoken->deviceToken = $tokenNotify;
                            $insertsignupTimephonetoken->created_by='1';
                            $insertsignupTimephonetoken->save();

                            // end here

               
               

                 // $siginTemplate="64ddc95dd6fc0575cf294452";   //template id for sign in from msg91
                 $signupTemplate="64ddc918d6fc054568162c42";

                 $result=$this->sendsms($signupTemplate,$modifiedPhone,$otp);
                 // echo $result;

                 
                   
                 



                                    return response()->json([
                                        'responseMessage' => 'Record saved succesfully',
                                        'responseCode' => 200,
                                        'responseStatus' =>true,
                                    ]);  
                                    
               



                }else {  
                    
             // here is the else code
                    
                    $selectUID=user_detail_Model::where('mobile',$phone)
                    ->value('uId');
                   $selectUDTID=userdevicetokenModel::where('uId',$selectUID)
                   ->value('udtId');
                    $insertsignupTimephonetoken =userdevicetokenModel::where('udtId',$selectUDTID)
                    ->update([
                           'deviceToken'=>$tokenNotify,
                           'updated_by' =>$selectUID,
                    ]);
                           
            // end here is the else code
                    
                    //  return response()->json([
                    //                     'responseMessage' => 'User Already Exist',
                    //                     'responseCode' => 400,
                    //                     'responseStatus' =>false,
                    //                 ]);  
                    
                    
                    $otp =rand(1000,9999); 
                    
                   
                    $otp_update = user_detail_Model::where('mobile',$phone);
                    $otp_update->update(['otp'=>$otp]);


                   
                 $signupTemplate="64ddc918d6fc054568162c42";

                 $result=$this->sendsms($signupTemplate,$modifiedPhone,$otp);
                


                    
                                    return response()->json([
                                        'responseMessage' => 'Here Your Otp.',
                                        'responseStatus' =>true,
                                        'responseCode' =>200,
                                        
                                            ]);
                        }
                        
                        
                        
      }else{
           return response()->json([
                 'responseMessage' => 'User Already Exist',
                 'responseStatus' =>false,
                 'responseCode' =>400,
                                        
                     ]);
      }
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                    }
        }











    //     //SIGNIN FORM
    //     //name,phone number,otp generate
    //     public function signup(){
        
    //         $name = request('name');
    //         $phone = request('phone');
    //       //  $modifiedPhone = request('phone');
    //         $modifiedPhone = '91' . $phone;
    //         // Now $modifiedPhone contains the phone number with "91" appended to it


            
    //         // $otp = "1111"; 
    //           $otp =rand(1000,9999);  //generate random numbers


    //         if($name==""){
            
    //                     return response()->json([
    //                     'responseMessage' => 'please enter name',
    //                     'responseCode' => 401,
    //                     'responseStatus' =>false,]); 
                        
    //         }elseif($phone==""){

    //                     return response()->json([
    //                     'responseMessage' => 'please enter phonenumber',
    //                     'responseCode' => 401,
    //                     'responseStatus' =>false,]);

    //         }else{

              
    //                 $n=16;
    //                 $characters = 'abglinjostuvwxyz973291737344ABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()';
    //                 $randomString = '';
                 
    //                 for ($i = 0; $i < $n; $i++) {
    //                     $index = rand(0, strlen($characters) - 1);
    //                     $randomString .= $characters[$index];
    //                 }
                 
                   
    //  $planId = SubscriptionModel::select('planId')->where('isExpired', '=', '2')->pluck('planId')->first();
       

    //             $if_exist=user_detail_Model::select()->where('mobile',$phone)->get();
    //             if($if_exist->Count()==0){     //user not found
    //             //insert into database
    //                         $result = new user_detail_Model;
    //                         $result->name = $name;
    //                         $result->mobile = $phone;
    //                         $result->otp = $otp;
    //                         $result->planId = $planId;
    //                         $result->onlinetoken= $randomString;
    //                         $result->created_by='1';
    //                         $result->save();
                            
                            
    //     //App plan subscribers table default plan inserting             
    //             $uId = $result->uId;

    //             $currentDate = date("Y-m-d"); // Get the current date
    //             $endDate = date("Y-m-d", strtotime($currentDate . " +1 day"));

    //             // print_r($endDate);die;

    //              $APPplanSUB = new planSubscribersModel;
    //              $APPplanSUB->planId  =$planId;
    //              $APPplanSUB->uId     =$uId;
    //              $APPplanSUB->startDate =$currentDate;
    //             // print_r($currentDate);die;
    //              $APPplanSUB->endDate  =$endDate;
    //              $APPplanSUB->save();
                
                            
                            
                            
                            


    //              // $siginTemplate="64ddc95dd6fc0575cf294452";   //template id for sign in from msg91
    //              $signupTemplate="64ddc918d6fc054568162c42";

    //              $result=$this->sendsms($signupTemplate,$modifiedPhone,$otp);
    //              // echo $result;

                 
                   
                 



    //                                 return response()->json([
    //                                     'responseMessage' => 'Record saved succesfully',
    //                                     'responseCode' => 200,
    //                                     'responseStatus' =>true,
    //                                 ]);  
                                    
               



    //             }else {  //user already exist
    //                                 return response()->json([
    //                                     'responseMessage' => 'user already exist',
    //                                     'responseStatus' =>false,
    //                                     'responseCode' =>400,
                                        
    //                                         ]);
    //                     }
    //                 }
    //     }
    
    
    
    
    
    


        //LOGIN FORM
        //phonenumber,otp generate
        public function login(){
            
           // $phone = request('phone');
            $phone = request('phone');
            $modifiedPhone = '91' . $phone;
            
            $tokenNotify = request('notifyToken');
            
            if($phone==""){
                return response()->json([
                    'responseMessage' => 'please enter phone number',
                    'responseCode' => 401,
                    'responseStatus' =>false,
                    
                ]); 
            }
             if($tokenNotify==""){
                    return response()->json([
                        'responseMessage' => 'please enter notifyToken',
                        'responseCode' => 401,
                        'responseStatus' =>false,
                        
                    ]); 
            }
            
            else{
                
                
                
                
                // $vivek_phone = '9074388829';
                // $result = user_detail_Model::where('mobile',$vivek_phone)->where('ActiveUser','=','1')->get();
                
                
                // if($phone == $vivek_phone)
                // {
                //      return response()->json([
                //                             'responseMessage' => 'otp generated succesfully',
                //                             'responseCode' => 200,
                //                             'responseStatus' =>true,
                //                           // 'onlinetoken' => $randomString,
                                            
                //                         ]); 
                // }
                // else{
                    
                    
               
                
                
          //here --- main      
                
                
                //check already exist 
                $result = user_detail_Model::where('mobile',$phone)->where('ActiveUser','=','1')->get();
                if($result->Count()>0){
                    //otp generate and message to phonenumber
                           // $otp="2222";
                           $otp =rand(1020,9989);

                        //   $n=16;
                        //   $characters = 'glinjostuwvyxzab97328888344ABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()';
                        //   $randomString = '';
                        
                        //   for ($i = 0; $i < $n; $i++) {
                        //       $index = rand(0, strlen($characters) - 1);
                        //       $randomString .= $characters[$index];
                        //   }

                            $result_otp_update = user_detail_Model::where('mobile',$phone);
                            $result_otp_update->update(['otp'=>$otp]);
                                    if($result_otp_update){   
                                        

                $siginTemplate="64ddc95dd6fc0575cf294452";   //template id for sign in from msg91
              
              
                                     // $signupTemplate="64ddc918d6fc054568162c42";

                 $result=$this->sendsms($siginTemplate,$modifiedPhone,$otp);
               
               
                                    //   echo $result;



                  
                                      // HERE LOGIN CODE START HERE

                                       $selectUID=user_detail_Model::where('mobile',$phone)
                                       ->value('uId');
                                       $selectUDTID=userdevicetokenModel::where('uId',$selectUID)
                                        ->value('udtId');
                    
                                        $selectthatusertahttable=userdevicetokenModel::where('uId', $selectUID)->first();
                    
                                        if($selectthatusertahttable)
                                        {
                    
                                            $insertsignupTimephonetoken =userdevicetokenModel::where('udtId',$selectUDTID)
                                            ->update([
                                                  'deviceToken'=>$tokenNotify,
                                                  'updated_by' =>$selectUID,
                                                    ]);
                    
                                        }
                                        else{
                    
                                            $insertsignupTimephonetoken = new userdevicetokenModel;
                                            $insertsignupTimephonetoken->uId = $selectUID;
                                            $insertsignupTimephonetoken->deviceToken = $tokenNotify;
                                            $insertsignupTimephonetoken->created_by='1';
                                            $insertsignupTimephonetoken->save();
                    
                                        }
                    
                    
                                        
                    
                                    //END HERE LOGIN CODE START HERE


               
                                        
                                        
                                        //generate random otp
                                        return response()->json([
                                            'responseMessage' => 'otp generated succesfully',
                                            'responseCode' => 200,
                                            'responseStatus' =>true,
                                           // 'onlinetoken' => $randomString,
                                            
                                        ]); 
                                    }else{
                                        return response()->json([
                                            'responseMessage' => 'otp generation failed',
                                            'responseCode' => 402,
                                            'responseStatus' =>false,
                                        ]);
                                    }
                                    
                                    
                                    
                         
                            
                                    
                                    
                                    
                                    
                
                }else{
                                        return response()->json([
                                            'responseMessage' => 'no user found,please signup',
                                            'responseStatus' =>false,
                                            'responseCode' =>400,
                                                ]);
                }
                
                
                
         //     CLOSE MAIN       
                
                
                
               // }//for vivek phone check 
                
                
                
                
                
                
            }
        }


       
       
       
       
 

// //SIGNIN FORM
// //name,phone number,otp generate
// public function signup(){
   
//     $name = request('name');
//     $phone = request('phone');
    
//     $otp = "1111";                                                                                //generate random numbers
//     if($name==""){
       
//                                 return response()->json([
//                                     'responseMessage' => 'please enter name',
//                                     'responseCode' => 401,
//                                     'responseStatus' =>false,]); 
//     }elseif($phone==""){
//                                 return response()->json([
//                                     'responseMessage' => 'please enter phonenumber',
//                                     'responseCode' => 401,
//                                     'responseStatus' =>false,]);
//     }else{

//         $if_exist=user_detail_Model::select()->where('mobile',$phone)->get();
//         if($if_exist->Count()==0){     //user not found
//         //insert into database
//                     $result = new user_detail_Model;
//                     $result->name = $name;
//                     $result->mobile = $phone;
//                     $result->otp = $otp;
//                     $result->updated_at = '2022-12-12';
//                     $result->onlinetoken= 'asdfhuitrdyfugh12345678';
//                     $result->created_by='1';
//                     $result->save();

//                             return response()->json([
//                                 'responseMessage' => 'Record saved succesfully',
//                                 'responseCode' => 200,
//                                 'responseStatus' =>true,
//                             ]);           
//          }else {  //user already exist
//                             return response()->json([
//                                 'responseMessage' => 'user already exist',
//                                 'responseStatus' =>false,
//                                 'responseCode' =>400,
                                
//                                     ]);
//                 }
//             }
// }


// //LOGIN FORM
// //phonenumber,otp generate
// public function login(){
    
//     $phone = request('phone');
       
//     if($phone==""){
//         return response()->json([
//             'responseMessage' => 'please enter phone number',
//             'responseCode' => 401,
//             'responseStatus' =>false,
            
//         ]); 
//     }else{
//         //check already exist 
//         $result = user_detail_Model::where('mobile',$phone)->get();
//         if($result->Count()>0){
//             //otp generate and message to phonenumber
//                     $otp="2222";
//                     $result_otp_update = user_detail_Model::where('mobile',$phone);
//                     $result_otp_update->update(['otp'=>$otp]);
//                             if($result_otp_update){                                                                      //generate random otp
//                                 return response()->json([
//                                     'responseMessage' => 'otp generated succesfully',
//                                     'responseCode' => 200,
//                                     'responseStatus' =>true,
                                    
//                                 ]); 
//                             }else{
//                                 return response()->json([
//                                     'responseMessage' => 'otp generation failed',
//                                     'responseCode' => 402,
//                                     'responseStatus' =>false,
//                                 ]);
//                             }
        
//         }else{
//                                 return response()->json([
//                                     'responseMessage' => 'no user found,please signup',
//                                     'responseStatus' =>false,
//                                     'responseCode' =>400,
//                                         ]);
//         }
//     }
// }









//OTP VERIFICATION
//otp validation ,phone number
public function otp_validation(){
    $phone = request('phone');
    $otp = request('otp');

    if($phone==""){ 
        return response()->json([
            'responseMessage' => 'please enter phone number',
            'responseCode' => 401,
            'responseStatus' =>false,
            
        ]); 
    }elseif($otp==""){

        return response()->json([
            'responseMessage' => 'please enter otp number',
            'responseCode' => 401,
            'responseStatus' =>false,
            
        ]); 
    }else{
        
       // print_r($otp);die;
        
           //verify mobile number and otp are same
            $verify = user_detail_Model::select('name','mobile','uId')->where('mobile',$phone)->where('otp',$otp)->get();
          // print_r($verify);die;
            
            foreach ($verify as $record) {
                 $uId =$record->uId;
            }  
              

       // print_r($uId);die;
        
        
            $ActiveUser=1;
            
         $count = $verify->Count();
         
         if($count>0){
             
             //print_r('hai');die;
             
                $n=16;
                $characters = 'glinjostuwvyxzab97328888344ABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()';
                $randomString = '';
             
                for ($i = 0; $i < $n; $i++) {
                    $index = rand(0, strlen($characters) - 1);
                    $randomString .= $characters[$index];
                }

                 $result_otp_update = user_detail_Model::where('mobile',$phone);
                 $result_otp_update->update(['onlinetoken'=>$randomString]);
             
               $planId = SubscriptionModel::select('planId')->where('isExpired', '=', '2')->pluck('planId')->first();
               
       $userPlanactive=user_detail_Model::where('uId',$uId)->update(['planId'=>$planId]);
       
        $currentDate = date("Y-m-d"); // Get the current date
                $endDate = date("Y-m-d", strtotime($currentDate . " +1 day"));



                // print_r($endDate);die;
                 $userExist=user_detail_Model::where('uId',$uId)->where('ActiveUser',$ActiveUser)->first();
                 
                 
                 $transactionNumber='0000000000';

                if(!$userExist)
                {

                 $APPplanSUB = new planSubscribersModel;
                 $APPplanSUB->planId  =$planId;
                 $APPplanSUB->uId     =$uId;
                 $APPplanSUB->transactionNumber =$transactionNumber;
                 $APPplanSUB->startDate =$currentDate;
                // print_r($currentDate);die;
                 $APPplanSUB->endDate  =$endDate;
                 $APPplanSUB->save();
                 
                 
                 
                 
                   // THIS TABLE INSERTING VALUE
                   // FOR THE USER GIVE A DEFAULT A USER REFER CODE
                   $referral_code = strtoupper(Str::random(8)); // Generate an 8-character alphanumeric code
                  
                   $referalcheckUser=referUsersModel::where('referral_code', $referral_code)->exists();
                   
                    while ($referalcheckUser) {
                        $referral_code = strtoupper(Str::random(8)); // Generate a new code
                        $referalcheckUser = referUsersModel::where('referral_code', $referral_code)->exists();
                    }
                 
                  
                       $referUsers = new referUsersModel;
                       $referUsers->refer_user_Id =$uId;
                       $referUsers->referral_code =$referral_code;
                       $referUsers->save();
                  
           
           
           
                 
                }
                 

         $updateActiveuser=user_detail_Model::where('uId',$uId)->update(['ActiveUser'=>$ActiveUser]);
               
               
                 
              
            //succsessfully login
            return response()->json([
                'responseMessage' => 'succsesfully login',
                'responseCode' => 200,
                'responseStatus' =>true,
                'onlinetoken'=>$randomString,
                'data'=>$verify,
                
                
            ]); 

         }else{
            //login failed
            return response()->json([
                'responseMessage' => 'sorry login failed',
                'responseCode' => 401,
                'responseStatus' =>false,       
            ]);
         }
    } 
}

//SHOW CATOGORIES PMODULE--------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------------------------------
//based on subject
public function show_exam_catogories(){

    $pqmainId = request('pqmainId');
    if($pqmainId==""){
        return response()->json([
            'responseMessage' => 'please enter previous question main',
            'responseCode' => 401,
            'responseStatus' =>false,       
        ]);

    }else{
    
    $previos_exam_catogory = PreviousExamCatogoryModel::where('pqmainId',$pqmainId)->where('isAvail',0)->orderby('pqmName','DESC')->get();
    $count = $previos_exam_catogory->Count();
         
         if($count>0){
            //show exam catogories
            return response()->json([
                'responseMessage' => 'all exam catogory',
                'responseCode' => 200,
                'responseStatus' =>true,
                'data'=>$previos_exam_catogory,
                
            ]); 

         }else{
            //no data found
            return response()->json([
                'responseMessage' => 'sorry no data found',
                'responseCode' => 401,
                'responseStatus' =>false,       
            ]);
         }

}
}

//SHOW YEAR OF EXAM  SUB MODULE
//based on year of exam
public function exam_date(){

    $pqmId = request('pqmId');
    if($pqmId==""){
        return response()->json([
            'responseMessage' => 'please enter exam module',
            'responseCode' => 401,
            'responseStatus' =>false,       
        ]);

    }else{
        $previous_sub_module = PreviousExamSubModuleModel::where('pqmId',$pqmId)->where('isAvail',0)->orderby('pqsmName','ASC')->get();
        $count = $previous_sub_module->Count();
         
         if($count>0){

        return response()->json([
            'responseMessage' => 'all exam submodule',
            'responseCode' => 200,
            'responseStatus' =>true,
            'data'=>$previous_sub_module,       
        ]);
    }else{
        return response()->json([
            'responseMessage' => 'sorry no data found',
            'responseCode' => 401,
            'responseStatus' =>false,  
        ]);
    }

    }    
}


//SHOW PREVIOUS MODEL QUESTION 
//previous exams
public function show_previous_question_with_answer(Request $request){
    
    $method = $request->method();
    

            if ($method=="POST"){
       
              $pqsmId = request('pqsmId');

           

                if($pqsmId==""){
                    
                    return response()->json([
                        'responseMessage' => 'please enter submoduleid',
                        'responseCode' => 404,
                        'responseStatus' =>false,  
                        ]);

                }else{
                   
                            //TAKE RELATION WITH ANSWER
                          
                $previous_questions_with_answers = PreviousQuestionModel::with('get_answers')->where('pqsmId',$pqsmId)->where('isAvail',0)->get();
             
                            $count = $previous_questions_with_answers->Count();
                                
                                if($count>0){
                                  
                                            return response()->json([
                                                'responseMessage' => 'all questions and answers',
                                                'responseCode' => 200,
                                                'responseStatus' =>true,
                                                'data'=>$previous_questions_with_answers,       
                                                ]);
                                }else{
                                   
                                            return response()->json([
                                                'responseMessage' => 'NO QUESTIONS',
                                                'responseCode' => 404,
                                                'responseStatus' =>false,  
                                                ]);
                                }
                }
        }else{
           
            return response()->json([
                'responseMessage' => 'NO METHOD ACCESS NOT FOUND',
                'responseCode' => 404,
                'responseStatus' =>false,  
                ]);
        }
}


//SHOW ADVERTISEMENTS
public function advertisements(Request $request){
    
     //IP ADDRESS AREA   
   
    $userId = $request->header('uId');
    $user_name = user_detail_Model::where('uId', $userId)->value('name');
    
    date_default_timezone_set('Asia/Kolkata');
    $currentDateTime = date('Y-m-d');
    $currentDateTimeIST = date('Y-m-d H:i:s');
    
    $userIp = $request->ip();
    
    $existingEntry = appLoginModel::where('ipConfig', $userIp)->where('username', $user_name)->first();
    $hitcounts=appLoginModel::where('ipConfig', $userIp)->where('username', $user_name)->value('hitCount');
  
    $counts = $hitcounts + 1;
    
    if ($existingEntry) {
       if($existingEntry->DateAndTime == $currentDateTime)
       {
        appLoginModel::where('ipConfig', $userIp)
            ->where('username', $user_name)
            ->update([
                'DateAndTime' => $currentDateTime,
                'hitCount'    => $counts,
                'updated_at'  => $currentDateTimeIST
            ]);
       }else{
            $newEntry = new appLoginModel();
            $newEntry->DateAndTime = $currentDateTime;
            $newEntry->username = $user_name;
            $newEntry->ipConfig = $userIp;
            $newEntry->hitCount = 1; // Set hitCount to 1 for new entries
            $newEntry->save();
       }
    } else {
        // Create a new entry
        $newEntry = new appLoginModel();
        $newEntry->DateAndTime = $currentDateTime;
        $newEntry->username = $user_name;
        $newEntry->ipConfig = $userIp;
        $newEntry->hitCount = 1; // Set hitCount to 1 for new entries
        $newEntry->save();
    }





   
    //END
 

    try {

        $data = advertisementsModel::select('adId','heading','contentType','videos','image','addType','isAvail')->where('isAvail','0')->get();
        return response()->json([
            'responseMessage' => 'all advertisements',
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

//SHOW ADVERTISEMENTS VIDEOS
public function advertisementsVideos(){

    try {

        $data = advertisementsModel::select('adId','heading','contentType','image','videos')->where('contentType', '=', '1')->get();
        return response()->json([
            'responseMessage' => 'all advertisements ',
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

//SHOW PREVIOUS QUESTION MAIN TABLE 
public function pqMain(){

    try {

        $data = pqmainModel::select('pqmainId','pqmainName','positiveMark','negativeMark')->get();
        return response()->json([
            'responseMessage' => 'all pq main data',
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




}
?>