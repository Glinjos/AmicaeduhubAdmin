<?php

namespace App\Http\Controllers;

use App\Models\ChatUsersModels\chatQuestionsMainModel;
use App\Models\chatSuggestionsModels\chatSuggestionSub;

use DB;
use Illuminate\Http\Request;

class ApichatSuggestionController extends Controller
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





    

    // inserting suggestion and ideas in chatquestionstable

    public function savesuggestionsMain(Request $request)
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
                     
                   
                     $assigned ='2';   
                                               
                    try {
                                        
                         $storeUSERchatDoubts = new chatQuestionsMainModel();
                         $storeUSERchatDoubts->uId        = $uId;
                         $storeUSERchatDoubts->chatTypeId = $chatTypeId;
                         $storeUSERchatDoubts->assigned = $assigned;
                                  
                       
                         $storeUSERchatDoubts->save();

                              return response()->json([
                              'responseStatus' =>true,
                              'responseCode' => 200,
                              'responseMessage' => 'Record saved successfully',
                              'chatQuestionId'=>$storeUSERchatDoubts->chatQuestionId,
                              'userId'=>$storeUSERchatDoubts->uId

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
        else
        {
            return response()->json([
                'responseStatus' =>false,
                'responseCode' => 404,
                'responseMessage' => 'INCORRECT METHOD, ACCESS DENIED',
            ]);
        }
    }




    

            //// inserting suggestions or ideas in chatsuggestionsubtable

            public function savesuggestionsSUB(Request $request)
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
                           
                                  $suggestions = request('suggestions');
                           
                                        if ($suggestions == "") 
                                        {
                                            return response()->json([
                                                'responseStatus' => false,
                                                'responseCode' => 401,
                                                'responseMessage' => 'suggestions is mandatory',
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
                                                
                                 $storeUSERchatSUGGESTION = new chatSuggestionSub();
                               
                                 $storeUSERchatSUGGESTION->chatQuestionId = $chatQuestionId;
                                
                                 $storeUSERchatSUGGESTION->suggestions    = $suggestions;
                                 $storeUSERchatSUGGESTION->chatDateTime   = $chatDateTime;
                                                    
                                 $storeUSERchatSUGGESTION->save();

                                      return response()->json([
                                      'responseStatus' =>true,
                                      'responseCode' => 200,
                                      'responseMessage' => 'Record saved successfully',
                                      'chatQuestionSubId'=>$storeUSERchatSUGGESTION->cssubId,
                                      'chatDateTime'=>$storeUSERchatSUGGESTION->chatDateTime,

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












}
