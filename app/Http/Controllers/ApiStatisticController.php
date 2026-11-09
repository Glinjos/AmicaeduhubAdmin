<?php

namespace App\Http\Controllers;

use App\Models\StatisticsModels\Statistics;
//use Illuminate\Http\Request;

class ApiStatisticController extends Controller
{
    //this function call for viewing statics
    public function show_Statistics(){
        $userId = request('userId');
        if ($userId =='') {
            return response()->json([
                'responseMessage' => 'userId is mandatory' .$userId,
                'responseCode' => 401,
                'responseStatus' => false,
            ]);
        } else {
            $mainExamTotalAttended = Statistics::where('courseType', 1)
                ->where('userId', $userId)
                ->count('QuestionsAttended');
            $previousQuestionsTotalAttended = Statistics::where('courseType', 2)
                ->where('userId', $userId)
                ->count('QuestionsAttended');
            $videoClassesTotalAttended = Statistics::where('courseType', 3)
                ->where('userId', $userId)
                ->count('QuestionsAttended');
            $result = [
                'MainExamTotalAttended' => $mainExamTotalAttended,
                'PreviousQuestionsTotalAttended' => $previousQuestionsTotalAttended,
                'VideoClassesTotalAttended' => $videoClassesTotalAttended,
            ];
            $count = count($result);
            if ($count > 0) {
                return response()->json([
                    'responseMessage' => 'Statistics',
                    'responseCode' => 200,
                    'responseStatus' => true,
                    'data' => $result,
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
}
