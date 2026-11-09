<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RevisionsModels\usersRevisionModel;

class ApiRevisionController extends Controller
{
    public function storeUserRevisionsData(Request $request)
    {
        $method = $request->method();
        if ($method == "POST")
        {
            //date_default_timezone_set('Asia/Calcutta'); 
            $dateAndTime = request('dateAndTime');
            if($dateAndTime == "") 
            {
                return response()->json([
                    'responseStatus' => false,
                    'responseCode' => 400,
                    'responseMessage' => 'dateAndTime is mandatory',
                ]);
            } 
            else{
            
            $userId = request('userId');
            if($userId == "") 
            {
                return response()->json([
                    'responseStatus' => false,
                    'responseCode' => 400,
                    'responseMessage' => 'userId is mandatory',
                ]);
            } 
            else{
           
            $totalQuestions = request('totalQuestions');
            if($totalQuestions == "") 
            {
                return response()->json([
                    'responseStatus' => false,
                    'responseCode' => 400,
                    'responseMessage' => 'totalQuestions is mandatory',
                ]);
            } 
            else{

            $QuestionsAttended = request('QuestionsAttended');
            if($QuestionsAttended == "") 
            {
                return response()->json([
                    'responseStatus' => false,
                    'responseCode' => 400,
                    'responseMessage' => 'QuestionsAttended is mandatory',
                ]);
            } 
            else{

            $rightAns = request('rightAns');
            if($rightAns == "") 
            {
                return response()->json([
                    'responseStatus' => false,
                    'responseCode' => 400,
                    'responseMessage' => 'rightAns is mandatory',
                ]);
            } 
            else{

           
            $percentage = request('percentage');
            if($percentage == "") 
            {
                return response()->json([
                    'responseStatus' => false,
                    'responseCode' => 400,
                    'responseMessage' => 'percentage is mandatory',
                ]);
            } 
            else{
           

            try {
                $store_revision_data = new usersRevisionModel();
                $store_revision_data->dateAndTime = $dateAndTime;
                $store_revision_data->userId    = $userId;
                $store_revision_data->totalQuestions = $totalQuestions;
                $store_revision_data->QuestionsAttended= $QuestionsAttended;
                $store_revision_data->rightAns = $rightAns;
                $store_revision_data->percentage = $percentage;
                $store_revision_data->save();
                return response()->json([
                    'responseStatus' =>true,
                    'responseCode' => 200,
                    'responseMessage' => 'Record saved successfully',
                ]); 

                } catch (\Exception $e) {
                    return response()->json([
                        'responseStatus' => false,
                        'responseCode' => 400,
                        'responseMessage' => 'Something went wrong, record not saved ',
                    ]);
                } 

            }//percentage

            }///rightAns

            }//QuestionsAttended
            }//totalQuestions

            }//userId

            }//dateandtime





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
