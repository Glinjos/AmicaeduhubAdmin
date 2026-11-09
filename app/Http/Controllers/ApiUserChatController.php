<?php

/**
 * Created by vsCode.
 * Use: API (FLUTTER) Video Class
 * chating with user ami 
 * User doubt or question inserting 
 * and displaying that answer
 */

namespace App\Http\Controllers;

use App\Models\ChatUsersModels\chatTypeModel;
use App\Models\ChatUsersModels\chatQuestionsMainModel;
use App\Models\ChatUsersModels\chatQuestionsSubModel;
use App\Models\ChatUsersModels\chatQuestionsAnsModel;
use App\Models\GenaralQuestionModels\ModuleModel;

use DB;
use Illuminate\Http\Request;

class ApiUserChatController extends Controller
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









   
    //get chat type
    public function getchattypeamica(Request $request)
    {
        $method = $request->method();
      // dd($method);

        if ($method == "POST")
        {

            

                        $chatType = chatTypeModel::select()->get();
                      //  $count = $answer->Count();
                        if ($chatType)
                         {
                            return response()->json([
                                'responseMessage' => 'chat type fetch successfully',
                                'responseCode' => 200,
                                'responseStatus' => true,
                                'data' => $chatType,
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
        else
        {
            return response()->json([
                'responseStatus' =>false,
                'responseCode' => 404,
                'responseMessage' => 'INCORRECT METHOD, ACCESS DENIED',
            ]);
        }
        
    }




    // inserting question or doubts in chatquestionstable

            public function storeUserchatquestions(Request $request)
            {
                $method = $request->method();

                if ($method == "POST")
                {
                    $uId = request('uId');

                        if ($uId == "") 
                        {
                            return response()->json([
                                'responseStatus' => false,
                                'responseCode' => 401,
                                'responseMessage' => 'uId is mandatory',
                            ]);
                        } 
                        else 
                        {
                          $chatTypeId = request('chatTypeId');
         
                            if ($chatTypeId == "") 
                            {
                                return response()->json([
                                    'responseStatus' => false,
                                    'responseCode' => 401,
                                    'responseMessage' => 'chatTypeId is mandatory',
                                ]);
                            } 
                            else 
                            {
                              $mId = request('mId');

                                if ($mId == "") 
                                {
                                    return response()->json([
                                        'responseStatus' => false,
                                        'responseCode' => 401,
                                        'responseMessage' => 'mId is mandatory',
                                        
                                        
                                    ]);
                                } 
                                else 
                                {
                           
                                
                                                       
                            try {
                                                
                                 $storeUSERchatDoubts = new chatQuestionsMainModel();
                                 $storeUSERchatDoubts->uId        = $uId;
                                 $storeUSERchatDoubts->chatTypeId = $chatTypeId;
                                 $storeUSERchatDoubts->mId        = $mId;
                                
                                //  $storeUSERchatDoubts->question   = $question;
                                //  $storeUSERchatDoubts->chatDateTime   = $chatDateTime;
                                  // print_r($storeUSERchatDoubts->chatTime);die;                       
                                 $storeUSERchatDoubts->save();

                                      return response()->json([
                                      'responseStatus' =>true,
                                      'responseCode' => 200,
                                      'responseMessage' => 'Record saved successfully',
                                      'chatQuestionId'=>$storeUSERchatDoubts->chatQuestionId,
                                      'userId'=>$storeUSERchatDoubts->uId,

                                                              ]); 
                                 } catch (\Exception $e) {

                                      return response()->json([
                                      'responseStatus' => false,
                                      'responseCode' => 400,
                                      'responseMessage' => 'Something went wrong, record not saved',
                                                             ]);
                                                  }        
                                        }

                                   }

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


            //show user doubt answer
            public function showUserDoubtAnswerData(Request $request)
            {
                $method = $request->method();
              // dd($method);

                if ($method == "POST")
                {

                    $chatQuestionId = request('chatQuestionId');
                            if ($chatQuestionId == "")
                             {

                                return response()->json([
                                    'responseMessage' => 'chatQuestionId is mandatory',
                                    'responseCode' => 401,
                                    'responseStatus' => false,
                                ]);

                            } else {

                                $answer = chatQuestionsAnsModel::select()->where('chatQuestionId', $chatQuestionId)->get();
                                $count = $answer->Count();
                                if ($count > 0)
                                 {
                                    return response()->json([
                                        'responseMessage' => 'Answer fetch successfully',
                                        'responseCode' => 200,
                                        'responseStatus' => true,
                                        'data' => $answer,
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
                else
                {
                    return response()->json([
                        'responseStatus' =>false,
                        'responseCode' => 404,
                        'responseMessage' => 'INCORRECT METHOD, ACCESS DENIED',
                    ]);
                }
                
            }




            //// inserting question or doubts in chatquestionstable

            public function storeUserchatquestionssub(Request $request)
            {
                $method = $request->method();

                if ($method == "POST")
                {
                   
                              $chatQuestionId = request('chatQuestionId');

                                if ($chatQuestionId == "") 
                                {
                                    return response()->json([
                                        'responseStatus' => false,
                                        'responseCode' => 401,
                                        'responseMessage' => 'chatQuestionId is mandatory',
                                        
                                        
                                    ]);
                                } 
                                else 
                                {
                           
                                  $question = request('question');
                           
                                        if ($question == "") 
                                        {
                                            return response()->json([
                                                'responseStatus' => false,
                                                'responseCode' => 401,
                                                'responseMessage' => 'question is mandatory',
                                            ]);
                                        } 
                                        else 
                                        {
                                            $chatDateTime = request('chatDateTime');

                                                if ($chatDateTime == "") 
                                                {
                                                    return response()->json([
                                                        'responseStatus' => false,
                                                        'responseCode' => 401,
                                                        'responseMessage' => 'chatDateTime is mandatory', 
                                                    ]);
                                                } 
                                                    else                                    
                                                {
                                                       
                            try {
                                                
                                 $storeUSERchatDoubts = new chatQuestionsSubModel();
                               
                                 $storeUSERchatDoubts->chatQuestionId  = $chatQuestionId;
                                
                                 $storeUSERchatDoubts->question   = $question;
                                 $storeUSERchatDoubts->chatDateTime   = $chatDateTime;
                                  // print_r($storeUSERchatDoubts->chatDateTime);die;                       
                                 $storeUSERchatDoubts->save();

                                      return response()->json([
                                      'responseStatus' =>true,
                                      'responseCode' => 200,
                                      'responseMessage' => 'Record saved successfully',
                                      'chatQuestionSubId'=>$storeUSERchatDoubts->chatQuestionSubId,
                                      'chatDateTime'=>$storeUSERchatDoubts->chatDateTime,

                                                              ]); 
                                 } catch (\Exception $e) {

                                      return response()->json([
                                      'responseStatus' => false,
                                      'responseCode' => 400,
                                      'responseMessage' => 'Something went wrong, record not saved',
                                                             ]);
                                                  }        
                                        }

                                   }

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


      // close chat


      public function closeuserchat(Request $request)
      {
          $method = $request->method();

          if ($method == "POST")
          {
             
                        $chatQuestionId = request('chatQuestionId');

                          if ($chatQuestionId == "") 
                          {
                              return response()->json([
                                  'responseStatus' => false,
                                  'responseCode' => 401,
                                  'responseMessage' => 'chatQuestionId is mandatory',
                                  
                                  
                              ]);
                          } 
                          else 
                          {
                     
                          
                                                 
                    try {
                        $chatQuestionsMain = chatQuestionsMainModel::where('chatQuestionId',$chatQuestionId)->update([
                            'isClosed'=>'1'
                            
                        ]);
                        
                        return response()->json([
                            'responseStatus' =>true,
                            'responseCode' => 200,
                            'responseMessage' => 'User Chat isClosed  successfully',
                        ]);
                    } catch (\Exception $e) {
                        return response()->json([
                            'responseStatus' => false,
                            'responseCode' => 400,
                            'responseMessage' => 'Something went wrong, record not saved',
                        ]);
                    }
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



// user id use show question is isclosed or not

public function showuserquestions(Request $request)
{
    $method = $request->method();
  // dd($method);

    if ($method == "POST")
    {

        $uId = request('uId');
      //  print_r($chatQuestionId);die;
                if ($uId == "")
                 {

                    return response()->json([
                        'responseMessage' => 'uId is mandatory',
                        'responseCode' => 401,
                        'responseStatus' => false,
                    ]);

                } else {

                    $question = DB::select("SELECT t6.*, t2.mId, t2.mName, t3.name, t4.chatTypeId, t4.typeName, t5.*, t7.answer
                    FROM `chat_questions_main` AS t5
                    INNER JOIN `chat_questions_sub` AS t6 ON t6.chatQuestionId = t5.chatQuestionId
                  
                    LEFT JOIN `chat_questions_ans` AS t7 ON t7.chatQuestionId = t5.chatQuestionId
                    INNER JOIN `module` AS t2 ON t2.mId = t5.mId
                    INNER JOIN `user_details` AS t3 ON t3.uId = t5.uId
                    INNER JOIN `chat_type` AS t4 ON t4.chatTypeId = t5.chatTypeId
                    WHERE t3.uId=$uId; ");
                

                   // $count = $question->Count();
                    if ($question)
                     {
                        return response()->json([
                            'responseMessage' => 'user last Question fetch successfully',
                            'responseCode' => 200,
                            'responseStatus' => true,
                            'data' => $question,
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
    else
    {
        return response()->json([
            'responseStatus' =>false,
            'responseCode' => 404,
            'responseMessage' => 'INCORRECT METHOD, ACCESS DENIED',
        ]);
    }
    
}







//show users chats q and a


public function showuserchatsquestandansapi(Request $request)
{
    $method = $request->method();
  // dd($method);

    if ($method == "POST")
    {

        $uId = request('uId');
      //  print_r($chatQuestionId);die;
                if ($uId == "")
                 {

                    return response()->json([
                        'responseMessage' => 'uId is mandatory',
                        'responseCode' => 401,
                        'responseStatus' => false,
                    ]);

                } else {

                    $answerANDquestionData = DB::select(" SELECT t6.chatQuestionId as quid,t6.chatDateTime as qtime ,t5.isClosed as isclosed,t5.uId as uid,t6.question as question,null AS answer,t6.created_at as chatorder, null as answerid,t6.chatQuestionSubId as subqid,t7.mId as module_id,t7.mName as module_name
                    FROM `chat_questions_main` AS t5       
                    INNER JOIN `chat_questions_sub`  AS t6   ON t6.chatQuestionId=t5.chatQuestionId
                    INNER JOIN `module`  AS t7   ON t7.mId=t5.mId
                          
                    WHERE t5.uId=$uId and t5.isClosed = 0
                    
                    UNION ALL
                    
                    SELECT  null as quid,null as qtime,null as isClosed,null as uId,null as question,t4.Answer as answer,t4.created_at as chatorder,t4.chatQuestionAnsId as answerid ,null as subqid,null as module_id,null as module_name
                    FROM `chat_questions_ans` AS t4      
                    INNER JOIN `chat_questions_main`  AS t5   ON t5.chatQuestionId=t4.chatQuestionId
                         
                    WHERE t5.uId=$uId and t5.isClosed=0 order by chatorder asc;  ");

                    if(empty($answerANDquestionData))
                    {
                        $questionisnotask =  DB::select("SELECT t5.chatQuestionId as quid,t5.isClosed as isclosed,t5.uId as uid,t7.mId as module_id,t7.mName as module_name
                        FROM `chat_questions_main` AS t5       
                        
                        INNER JOIN `module`  AS t7   ON t7.mId=t5.mId
                              
                        WHERE t5.uId=$uId and t5.isClosed = 0 ");

                       
                      
                    }


                    if ($answerANDquestionData)
                     {
                        
                        $moduleNames = [];

                        foreach ($answerANDquestionData as $item) {
                            if (isset($item->module_name)) {
                                $moduleName = $item->module_name;
                                $moduleNames[] = $moduleName;
                            }
                        }
                        $firstModuleName = isset($moduleNames[0]) ? $moduleNames[0] : null;

                        return response()->json([
                            'responseMessage' => 'User Question And Answer fetch successfully',
                            'responseCode' => 200,
                            'responseStatus' => true,
                            'module_name' => $firstModuleName,
                            'data' => $answerANDquestionData,
                        ]);

                        } 
                        elseif($questionisnotask) {
                          
                            $moduleNames = [];

                            foreach ($questionisnotask as $item) {
                                if (isset($item->module_name)) {
                                    $moduleName = $item->module_name;
                                    $moduleNames[] = $moduleName;
                                }
                            }
                            $firstModuleName = isset($moduleNames[0]) ? $moduleNames[0] : null;
    

                            return response()->json([
                                'responseMessage' => 'Chat is open.',
                                'responseCode' => 200,
                                'responseStatus' => true,
                                'module_name' => $firstModuleName,
                                'data' => $questionisnotask,
                            ]);
                        }

                        else {
                          
                          

                            return response()->json([
                                'responseMessage' => 'Chat is closed.',
                                'responseCode' => 401,
                                'responseStatus' => false,
                                
                            ]);
                        }
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
