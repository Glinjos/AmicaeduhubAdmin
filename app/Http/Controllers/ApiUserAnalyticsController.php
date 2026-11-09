<?php

namespace App\Http\Controllers;

use App\Models\useranalyticsModel;
use Illuminate\Http\Request;

class ApiUserAnalyticsController extends Controller
{
    // user analytics
    // storing user analytics data of app usage
    public function storeUserAnalyticsData(Request $request)
    {
        $method = $request->method();
        if ($method == "POST")
        {
            date_default_timezone_set('Asia/Calcutta'); 
            $dateAndTime = date('Y-m-d H:i:s');
            $courseType = request('courseType');
            $userId = request('userId');
            $examTypeId = request('examTypeId');
            $examModuleId = request('examModuleId');
            $examSubModuleId = request('examSubModuleId');
            $vcChapterVideoId = request('vcChapterVideoId');
            $totalQuestions = request('totalQuestions');
            $QuestionsAttended = request('QuestionsAttended');
            $rightAns = request('rightAns');
            $wrongAns = request('wrongAns');
            $score = request('score');
            $percentage = request('percentage');
            $playerId = request('playerId');
            $opponentId = request('opponentId');
            $playerAttended = request('playerAttended');
            $playerRightAns = request('playerRightAns');
            $playerWrongAns = request('playerWrongAns');
            $playerScore = request('playerScore');
            $playerPercentage = request('playerPercentage');
            $opponentAttended = request('opponentAttended');
            $opponentRightAns = request('opponentRightAns');
            $opponentWrongAns = request('opponentWrongAns');
            $opponentScore = request('opponentScore');
            $opponentPercentage = request('opponentPercentage');
            $winnerId = request('winnerId');

            $created_by = request('created_by');
            $updated_by = request('updated_by');

            try {
                // $store_analytics_data = new useranalyticsModel();
                // $store_analytics_data->dateAndTime = $dateAndTime;
                // $store_analytics_data->courseType = $courseType;
                // $store_analytics_data->userId = $userId;
                // $store_analytics_data->examTypeId = $examTypeId;
                // $store_analytics_data->examModuleId = $examModuleId;
                // $store_analytics_data->examSubModuleId = $examSubModuleId;
                // $store_analytics_data->vcChapterVideoId = $vcChapterVideoId;
                // $store_analytics_data->totalQuestions = $totalQuestions;
                // $store_analytics_data->QuestionsAttended = $QuestionsAttended;
                // $store_analytics_data->rightAns = $rightAns;
                // $store_analytics_data->wrongAns = $wrongAns;
                // $store_analytics_data->score = $score;
                // $store_analytics_data->percentage = $percentage;
                // $store_analytics_data->playerId = $playerId;
                // $store_analytics_data->opponentId = $opponentId;
                // $store_analytics_data->playerAttended = $playerAttended;
                // $store_analytics_data->playerRightAns = $playerRightAns;
                // $store_analytics_data->playerWrongAns = $playerWrongAns;
                // $store_analytics_data->playerScore = $playerScore;
                // $store_analytics_data->playerPercentage = $playerPercentage;
                // $store_analytics_data->opponentAttended = $opponentAttended;
                // $store_analytics_data->opponentRightAns = $opponentRightAns;
                // $store_analytics_data->opponentWrongAns = $opponentWrongAns;
                // $store_analytics_data->opponentScore = $opponentScore;
                // $store_analytics_data->opponentPercentage = $opponentPercentage;
                // $store_analytics_data->winnerId = $winnerId;
                // $store_analytics_data->created_by = '1';
                // $store_analytics_data->updated_by = '1';

                $store_analytics_data = new useranalyticsModel();

                $data = [
                    'dateAndTime' => $dateAndTime,
                    'courseType' => $courseType,
                    'userId' => $userId,
                    'examTypeId' => $examTypeId,
                    'examModuleId' => $examModuleId,
                    'examSubModuleId' => $examSubModuleId,
                    'vcChapterVideoId' => $vcChapterVideoId,
                    'totalQuestions' => $totalQuestions,
                    'QuestionsAttended' => $QuestionsAttended,
                    'rightAns' => $rightAns,
                    'wrongAns' => $wrongAns,
                    'score' => $score,
                    'percentage' => $percentage,
                    'playerId' => $playerId,
                    'opponentId' => $opponentId,
                    'playerAttended' => $playerAttended,
                    'playerRightAns' => $playerRightAns,
                    'playerWrongAns' => $playerWrongAns,
                    'playerScore' => $playerScore,
                    'playerPercentage' => $playerPercentage,
                    'opponentAttended' => $opponentAttended,
                    'opponentRightAns' => $opponentRightAns,
                    'opponentWrongAns' => $opponentWrongAns,
                    'opponentScore' => $opponentScore,
                    'opponentPercentage' => $opponentPercentage,
                    'winnerId' => $winnerId,
                    'created_by' => '1',
                    'updated_by' => '1',
                ];

                $data = array_filter($data, function ($value) {
                    return $value !== null;
                });

                $store_analytics_data->fill($data);

                $store_analytics_data->save();


                return response()->json([
                    'responseStatus' =>true,
                    'responseCode' => 200,
                    'responseMessage' => 'Record saved successfully',
                ]); 
            } catch (\Exception $e) {
                return response()->json([
                    'responseStatus' => false,
                    'responseCode' => 400,
                    'responseMessage' => 'Something went wrong, record not saved '+ $e,
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

    // view user analytics
    // showing the data is stored in user analytics table
    public function showUserAnalyticsData(Request $request)
    {
        $method = $request->method();
        if ($request->isMethod('post'))
        {
            try{
                $analytics_data = useranalyticsModel::orderBy('aId', 'DESC')->get();
                return response()->json([
                    'responseStatus' =>true,
                    'responseCode' => 200,
                    'responseMessage' => 'all analytics data',
                    'data'=>$analytics_data,
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'responseStatus' =>false,
                    'responseCode' => 401,
                    'responseMessage' => 'sorry, no data found',
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
