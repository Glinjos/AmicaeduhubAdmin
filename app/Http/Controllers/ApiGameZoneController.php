<?php

namespace App\Http\Controllers;

use App\Models\GameZoneModels\gzhistoryModel;
use App\Models\GameZoneModels\gzinitializeModel;
use App\Models\GameZoneModels\gzmoduleModel;
use App\Models\GameZoneModels\gzquestionModel;
use App\Models\GameZoneModels\gzsubmoduleModel;
use App\Models\GameZoneModels\gzuserDetailsModel;
use App\Models\GameZoneModels\gzquestionidModel;
use App\Models\gzinitializationacceptanceModel;
use App\Models\temptestsummaryModel;
use App\Models\userdevicetokenModel;
use App\Models\SubscriptionModels\planSubscribersModel;
use App\Models\SubscriptionModels\SubscriptionModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ApiGameZoneController extends Controller
{
    // initialising a game challenge
    // storing init data when game challenge being created
    public function storeGZInit(Request $request)
    {
        $method = $request->method();
        if ($method == "POST")
        {
                $gameType = request('gameType');
                if($gameType == "") 
                {
                    return response()->json([
                        'responseStatus' => false,
                        'responseCode' => 400,
                        'responseMessage' => 'gameType is mandatory',
                    ]);
                } 
                else 
                {
                    $date_time = request('date_time');
                    if($date_time == "") 
                    {
                        return response()->json([
                            'responseStatus' => false,
                            'responseCode' => 400,
                            'responseMessage' => 'date_time is mandatory',
                        ]);
                    } 
                    else 
                    {
                        $moduleId = request('moduleId');
                        if($moduleId == "") 
                        {
                            return response()->json([
                                'responseStatus' => false,
                                'responseCode' => 400,
                                'responseMessage' => 'moduleId is mandatory',
                            ]);
                        } 
                        else 
                        {
                            $chapterId = request('chapterId');
                            if($chapterId == "") 
                            {
                                return response()->json([
                                    'responseStatus' => false,
                                    'responseCode' => 400,
                                    'responseMessage' => 'chapterId is mandatory',
                                ]);
                            }
                            else
                            {
                                $gameMode = request('gameMode');
                                if($gameMode == "") 
                                {
                                    return response()->json([
                                        'responseStatus' => false,
                                        'responseCode' => 400,
                                        'responseMessage' => 'gameMode is mandatory',
                                    ]);
                                }
                                else
                                {
                                    $noOfQuestions = request('noOfQuestions');
                                    if($noOfQuestions == "") 
                                    {
                                        return response()->json([
                                            'responseStatus' => false,
                                            'responseCode' => 400,
                                            'responseMessage' => 'noOfQuestions is mandatory',
                                        ]);
                                    }
                                    else
                                    {
                                        $playerId = request('playerId');
                                        if($playerId == "") 
                                        {
                                            return response()->json([
                                                'responseStatus' => false,
                                                'responseCode' => 400,
                                                'responseMessage' => 'playerId is mandatory',
                                            ]);
                                        }
                                        else
                                        {
                                            $opponentId = request('opponentId');
                                            if($opponentId == "") 
                                            {
                                                return response()->json([
                                                    'responseStatus' => false,
                                                    'responseCode' => 400,
                                                    'responseMessage' => 'opponentId is mandatory',
                                                ]);
                                            }
                                            else
                                            {
                                                $firstOpponentId = request('firstOpponentId');
                                                if($firstOpponentId == "") 
                                                {
                                                    return response()->json([
                                                        'responseStatus' => false,
                                                        'responseCode' => 400,
                                                        'responseMessage' => 'firstOpponentId is mandatory',
                                                    ]);
                                                }
                                                else
                                                {
                                                    // $cratedBy = request('createdBy');
                                                    // $updatedBy = request('updatedBy');

                                                    try {
                                                        $store_data = new gzinitializeModel();
                                                        $store_data->gameType = $gameType;
                                                        $store_data->date_time = $date_time;
                                                        $store_data->moduleId = $moduleId;
                                                        $store_data->chapterId = $chapterId;
                                                        $store_data->gameMode = $gameMode;
                                                        $store_data->noOfQuestions = $noOfQuestions;
                                                        $store_data->playerId = $playerId;
                                                        $store_data->opponentId = $opponentId;
                                                        $store_data->firstOpponentId = $firstOpponentId;
                                                        $store_data->created_by = $playerId;
                                                        $store_data->updated_by = $playerId;
                                                        $store_data->save();

                                                        if($store_data){
                                                            $gameInitData = gzinitializeModel::where('playerId', $playerId)
                                                                ->where('date_time', $date_time)
                                                                ->where('gameType', $gameType)
                                                                ->latest()
                                                                ->first();

                                                            $gameId = $gameInitData['giId'];

                                                            $store_acceptance_data = new gzinitializationacceptanceModel();
                                                            $store_acceptance_data->giId = $gameId;
                                                            $store_acceptance_data->opponentId = $opponentId;
                                                            $store_acceptance_data->acceptedOpponents = "[0]";
                                                            $store_acceptance_data->declinedOpponents = "[0]";
                                                            $store_acceptance_data->created_by = $playerId;
                                                            $store_acceptance_data->updated_by = $playerId;
                                                            $store_acceptance_data->save();

                                                            $smIdArray = json_decode($chapterId);

                                                            if ($gameMode == 0) {
                                                                if ($smIdArray == [0]) {
                                                                    $list_cqid = gzquestionModel::select('cqId')
                                                                    ->where('isAvail', '0')
                                                                    ->inRandomOrder()
                                                                    ->limit($noOfQuestions)
                                                                    ->get();
                                                                } else {
                                                                    $list_cqid = gzquestionModel::select('cqId')
                                                                    ->whereIn('smId', $smIdArray)
                                                                    ->where('isAvail', '0')
                                                                    ->inRandomOrder()
                                                                    ->limit($noOfQuestions)
                                                                    ->get();
                                                                }
                                                            } else {
                                                                if ($smIdArray == [0]) {
                                                                    $list_cqid = gzquestionModel::select('cqId')
                                                                    ->where('question_level', $gameMode)
                                                                    ->where('isAvail', '0')
                                                                    ->inRandomOrder()
                                                                    ->limit($noOfQuestions)
                                                                    ->get();
                                                                } else {
                                                                    $list_cqid = gzquestionModel::select('cqId')
                                                                    ->whereIn('smId', $smIdArray)
                                                                    ->where('question_level', $gameMode)
                                                                    ->where('isAvail', '0')
                                                                    ->inRandomOrder()
                                                                    ->limit($noOfQuestions)
                                                                    ->get();
                                                                }
                                                            }

                                                            $list_cqid_length = sizeof($list_cqid);
    
                                                            $list_ofcqid_big_final = array();
                                                            for($i = 0; $i < $list_cqid_length; $i++)
                                                            {
                                                                $list_ofcqid_big_final[] = $list_cqid[$i]["cqId"];
                                                            }
    
                                                            $list_questionid_values = implode(",", $list_ofcqid_big_final);

                                                            $store_question_ids = new gzquestionidModel();
                                                            $store_question_ids->giId = $gameId;
                                                            $store_question_ids->qId = $list_questionid_values;
                                                            $store_question_ids->created_by = $playerId;
                                                            $store_question_ids->updated_by = $playerId;
                                                            $store_question_ids->save();
                                                        }

                                                        if($store_data){
                                                            $playerName = gzuserDetailsModel::select('name')->where('uId', $playerId)->get();
                                                            $playerName = $playerName[0]["name"];

                                                            // $opponentId = json_decode($opponentId);
                                                            // $deviceTokendata = userdevicetokenModel::select('deviceToken')->whereIn('uId', $opponentId)->get();
                                                            // $deviceTokendataCount = count($deviceTokendata);
                                                            // $deviceTokenList = [];

                                                            // for($i = 0; $i< $deviceTokendataCount;$i++){
                                                            //     array_push($deviceTokenList, $deviceTokendata[$i]["deviceToken"]);
                                                            // }

                                                            $title = 'Gamezone '.$gameType.' challenge';
                                                            $body = $playerName.' challenging you with '.$gameType.' game';
                                                            // $tokenString = json_encode($deviceTokenList);

                                                            $response = Http::post('http://admin.amicaeduhub.com/api/send-notification', [
                                                                'title' => $title,
                                                                'body' => $body,
                                                                'users' => $opponentId
                                                                // 'tokens' => $tokenString
                                                            ]);
                                                        }

                                                        return response()->json([
                                                            'responseStatus' =>true,
                                                            'responseCode' => 200,
                                                            'responseMessage' => 'Record saved and notification sent successfully',
                                                            // 'aaa' => $gameInitData,
                                                            // 'aaabbb' => $gameId
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
                                }
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

    // storing game history
    // storing game history data after finishing the game challenge
    public function storeGZInitHistoryData(Request $request)
    {
        $method = $request->method();
        if ($method == "POST")
        {
            $giId = request('giId');
            if ($giId == "") 
            {
                return response()->json([
                    'responseStatus' => false,
                    'responseCode' => 401,
                    'responseMessage' => 'giId is mandatory',
                ]);
            } 
            else 
            {
                $userId = request('userId');
                if ($userId == "") 
                {
                    return response()->json([
                        'responseStatus' => false,
                        'responseCode' => 401,
                        'responseMessage' => 'userId is mandatory',
                    ]);
                } 
                else 
                {
                    $winnerId = request('winnerId');
                    if ($winnerId == "") 
                    {
                        return response()->json([
                            'responseStatus' => false,
                            'responseCode' => 401,
                            'responseMessage' => 'winnerId is mandatory',
                        ]);
                    }
                    else 
                    {
                        $totalQuestion = request('totalQuestion');
                        if ($totalQuestion == "") 
                        {
                            return response()->json([
                                'responseStatus' => false,
                                'responseCode' => 401,
                                'responseMessage' => 'totalQuestion is mandatory',
                            ]);
                        } 
                        else 
                        {
                            $attendedQuestions = request('attendedQuestions');
                            if ($attendedQuestions == "") 
                            {
                                return response()->json([
                                    'responseStatus' => false,
                                    'responseCode' => 401,
                                    'responseMessage' => 'attendedQuestions is mandatory',
                                    
                                    
                                ]);
                            } 
                            else 
                            {
                                $rightAns = request('rightAns');
                                if ($rightAns == "") 
                                {
                                    return response()->json([
                                        'responseStatus' => false,
                                        'responseCode' => 401,
                                        'responseMessage' => 'rightAns is mandatory',
                                    ]);
                                } 
                                else 
                                {
                                    $wrongAns = request('wrongAns');
                                    if ($wrongAns == "") 
                                    {
                                        return response()->json([
                                            'responseStatus' => false,
                                            'responseCode' => 401,
                                            'responseMessage' => 'wrongAns is mandatory',
                                        ]);
                                    } 
                                    else 
                                    {
                                        $score = request('score');
                                        if ($score == "") 
                                        {
                                            return response()->json([
                                                'responseStatus' => false,
                                                'responseCode' => 401,
                                                'responseMessage' => 'score is mandatory',
                                            ]);
                                        } 
                                        else 
                                        {
                                            $isPlayer = request('isPlayer');
                                            if ($isPlayer == "") 
                                            {
                                                return response()->json([
                                                    'responseStatus' => false,
                                                    'responseCode' => 401,
                                                    'responseMessage' => 'isPlayer is mandatory',
                                                ]);
                                            } 
                                            else 
                                            {
                                                $isOpponent = request('isOpponent');
                                                if ($isOpponent == "") 
                                                {
                                                    return response()->json([
                                                        'responseStatus' => false,
                                                        'responseCode' => 401,
                                                        'responseMessage' => 'isOpponent is mandatory',
                                                    ]);
                                                }       
                                                else 
                                                {
                                                    $startDateTime = request('startDateTime');
                                                    if ($startDateTime == "") 
                                                    {
                                                        return response()->json([
                                                            'responseStatus' => false,
                                                            'responseCode' => 401,
                                                            'responseMessage' => 'startDateTime is mandatory',
                                                        ]);
                                                    } 
                                                    else 
                                                    {
                                                        $endDateTime = request('endDateTime');
                                                        if ($endDateTime == "") 
                                                        {
                                                            return response()->json([
                                                                'responseStatus' => false,
                                                                'responseCode' => 401,
                                                                'responseMessage' => 'endDateTime is mandatory',
                                                            ]);
                                                        } 
                                                        else 
                                                        {
                                                            try {

                                                                $opponentIdOfInit = gzinitializeModel::select('opponentId')
                                                                ->where('giId',$giId)
                                                                ->get();
                                                                $opponentIdOfInit = $opponentIdOfInit[0]['opponentId'];
                                                                $opponentIdOfInitDecoded = json_decode($opponentIdOfInit, true);
                                                                $opponentIdCount = count($opponentIdOfInitDecoded);

                                                                $resultCount = gzhistoryModel::where('giId',$giId)->count('ghId');
                                                                $resultCountDecoded = json_decode($resultCount);

                                                                $current_winner_array = gzhistoryModel::select('winnerId')->where('giId',$giId)->get();
                                                                if($current_winner_array == null || $current_winner_array == "" || $current_winner_array == "[]")
                                                                {
                                                                    $current_winner_decoded = 0;
                                                                }
                                                                else
                                                                {
                                                                    $current_winner = $current_winner_array[0]["winnerId"];
                                                                    $current_winner_decoded = json_decode($current_winner, true);
                                                                }

                                                                $high_score = gzhistoryModel::where('giId',$giId)->max('score');
                                                                if($high_score == null || $high_score == "")
                                                                {
                                                                    $high_score_decoded = 0;
                                                                }
                                                                else
                                                                {
                                                                    $high_score_decoded = json_decode($high_score, true);
                                                                }

                                                                if($current_winner_decoded == 0)
                                                                {
                                                                    if($opponentIdCount == $resultCountDecoded)
                                                                    {
                                                                        $updateGZInit = gzinitializeModel::where('giId',$giId)->update([
                                                                        'isAccepted'=>'1',
                                                                        'isExpired'=>'1'
                                                                        ]);

                                                                        $storeGZHistory = new gzhistoryModel();
                                                                        $storeGZHistory->giId = $giId;
                                                                        $storeGZHistory->userId = $userId;
                                                                        $storeGZHistory->winnerId = $userId;
                                                                        $storeGZHistory->totalQuestion = $totalQuestion;
                                                                        $storeGZHistory->attendedQuestions = $attendedQuestions;
                                                                        $storeGZHistory->rightAns = $rightAns;
                                                                        $storeGZHistory->wrongAns = $wrongAns;
                                                                        $storeGZHistory->score = $score;
                                                                        $storeGZHistory->isPlayer = $isPlayer;
                                                                        $storeGZHistory->isOpponent = $isOpponent;
                                                                        $storeGZHistory->created_by = $userId;
                                                                        $storeGZHistory->created_at = $startDateTime;
                                                                        $storeGZHistory->updated_by = $userId;
                                                                        $storeGZHistory->updated_at = $endDateTime;
                                                                        $storeGZHistory->save();
                                                                    }
                                                                    else
                                                                    {
                                                                        $storeGZHistory = new gzhistoryModel();
                                                                        $storeGZHistory->giId = $giId;
                                                                        $storeGZHistory->userId = $userId;
                                                                        $storeGZHistory->winnerId = $userId;
                                                                        $storeGZHistory->totalQuestion = $totalQuestion;
                                                                        $storeGZHistory->attendedQuestions = $attendedQuestions;
                                                                        $storeGZHistory->rightAns = $rightAns;
                                                                        $storeGZHistory->wrongAns = $wrongAns;
                                                                        $storeGZHistory->score = $score;
                                                                        $storeGZHistory->isPlayer = $isPlayer;
                                                                        $storeGZHistory->isOpponent = $isOpponent;
                                                                        $storeGZHistory->created_by = $userId;
                                                                        $storeGZHistory->created_at = $startDateTime;
                                                                        $storeGZHistory->updated_by = $userId;
                                                                        $storeGZHistory->updated_at = $endDateTime;
                                                                        $storeGZHistory->save();
                                                                    } 
                                                                }
                                                                else
                                                                {
                                                                    if($high_score_decoded < $score)
                                                                    {
                                                                        if($opponentIdCount == $resultCountDecoded)
                                                                        {
                                                                            $updateGZInit = gzinitializeModel::where('giId',$giId)->update([
                                                                                'isAccepted'=>'1',
                                                                                'isExpired'=>'1'
                                                                                ]);

                                                                            $storeGZHistory = new gzhistoryModel();
                                                                            $storeGZHistory->giId = $giId;
                                                                            $storeGZHistory->userId = $userId;
                                                                            $storeGZHistory->winnerId = $userId;
                                                                            $storeGZHistory->totalQuestion = $totalQuestion;
                                                                            $storeGZHistory->attendedQuestions = $attendedQuestions;
                                                                            $storeGZHistory->rightAns = $rightAns;
                                                                            $storeGZHistory->wrongAns = $wrongAns;
                                                                            $storeGZHistory->score = $score;
                                                                            $storeGZHistory->isPlayer = $isPlayer;
                                                                            $storeGZHistory->isOpponent = $isOpponent;
                                                                            $storeGZHistory->created_by = $userId;
                                                                            $storeGZHistory->created_at = $startDateTime;
                                                                            $storeGZHistory->updated_by = $userId;
                                                                            $storeGZHistory->updated_at = $endDateTime;
                                                                            $storeGZHistory->save();

                                                                            $update_all_winnerId = gzhistoryModel::where('giId',$giId)->update([
                                                                                'winnerId' => $userId
                                                                            ]);
                                                                        }
                                                                        else
                                                                        {
                                                                            $storeGZHistory = new gzhistoryModel();
                                                                            $storeGZHistory->giId = $giId;
                                                                            $storeGZHistory->userId = $userId;
                                                                            $storeGZHistory->winnerId = $userId;
                                                                            $storeGZHistory->totalQuestion = $totalQuestion;
                                                                            $storeGZHistory->attendedQuestions = $attendedQuestions;
                                                                            $storeGZHistory->rightAns = $rightAns;
                                                                            $storeGZHistory->wrongAns = $wrongAns;
                                                                            $storeGZHistory->score = $score;
                                                                            $storeGZHistory->isPlayer = $isPlayer;
                                                                            $storeGZHistory->isOpponent = $isOpponent;
                                                                            $storeGZHistory->created_by = $userId;
                                                                            $storeGZHistory->created_at = $startDateTime;
                                                                            $storeGZHistory->updated_by = $userId;
                                                                            $storeGZHistory->updated_at = $endDateTime;
                                                                            $storeGZHistory->save();

                                                                            $update_all_winnerId = gzhistoryModel::where('giId',$giId)->update([
                                                                                'winnerId' => $userId
                                                                            ]);
                                                                        }
                                                                    }
                                                                    else
                                                                    {
                                                                        if($opponentIdCount == $resultCountDecoded)
                                                                        {
                                                                            $updateGZInit = gzinitializeModel::where('giId',$giId)->update([
                                                                                'isAccepted'=>'1',
                                                                                'isExpired'=>'1'
                                                                                ]);

                                                                            $storeGZHistory = new gzhistoryModel();
                                                                            $storeGZHistory->giId = $giId;
                                                                            $storeGZHistory->userId = $userId;
                                                                            $storeGZHistory->winnerId = $current_winner;
                                                                            $storeGZHistory->totalQuestion = $totalQuestion;
                                                                            $storeGZHistory->attendedQuestions = $attendedQuestions;
                                                                            $storeGZHistory->rightAns = $rightAns;
                                                                            $storeGZHistory->wrongAns = $wrongAns;
                                                                            $storeGZHistory->score = $score;
                                                                            $storeGZHistory->isPlayer = $isPlayer;
                                                                            $storeGZHistory->isOpponent = $isOpponent;
                                                                            $storeGZHistory->created_by = $userId;
                                                                            $storeGZHistory->created_at = $startDateTime;
                                                                            $storeGZHistory->updated_by = $userId;
                                                                            $storeGZHistory->updated_at = $endDateTime;
                                                                            $storeGZHistory->save();

                                                                            $update_all_winnerId = gzhistoryModel::where('giId',$giId)->update([
                                                                                'winnerId' => $current_winner
                                                                            ]);
                                                                        }
                                                                        else
                                                                        {
                                                                            $storeGZHistory = new gzhistoryModel();
                                                                            $storeGZHistory->giId = $giId;
                                                                            $storeGZHistory->userId = $userId;
                                                                            $storeGZHistory->winnerId = $current_winner;
                                                                            $storeGZHistory->totalQuestion = $totalQuestion;
                                                                            $storeGZHistory->attendedQuestions = $attendedQuestions;
                                                                            $storeGZHistory->rightAns = $rightAns;
                                                                            $storeGZHistory->wrongAns = $wrongAns;
                                                                            $storeGZHistory->score = $score;
                                                                            $storeGZHistory->isPlayer = $isPlayer;
                                                                            $storeGZHistory->isOpponent = $isOpponent;
                                                                            $storeGZHistory->created_by = $userId;
                                                                            $storeGZHistory->created_at = $startDateTime;
                                                                            $storeGZHistory->updated_by = $userId;
                                                                            $storeGZHistory->updated_at = $endDateTime;
                                                                            $storeGZHistory->save();

                                                                            $update_all_winnerId = gzhistoryModel::where('giId',$giId)->update([
                                                                                'winnerId' => $current_winner
                                                                            ]);
                                                                        }
                                                                    }
                                                                }

                                                                return response()->json([
                                                                    'responseStatus' =>true,
                                                                    'responseCode' => 200,
                                                                    'responseMessage' => 'Record saved successfully',
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
                                        }
                                    }
                                }
                            }
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


    //All modules
    public function show_gz_module()
    {
        try {
            $data = gzmoduleModel::select(
                'mId',
                'mCode',
                'mName',
                'isAvail',
            )
            ->where('isAvail','0')
            ->get();
            return response()->json([
                'responseMessage' => 'all module',
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


    //All Submodules
    public function show_gz_submodule()
    {
            $mId = request('mId');
            if ($mId == "") {
                return response()->json([
                    'responseMessage' => 'mId is mandatory',
                    'responseCode' => 401,
                    'responseStatus' => false,
                ]);
            } else {
                $gz_submodule = gzsubmoduleModel::select(
                    'smId',
                    'mId',
                    'smCode',
                    'smName',
                    'currentCode',
                    'isAvail',
                )
                ->where('mId', $mId)
                ->where('isAvail','0')
                ->get();
                $count = $gz_submodule->Count();
                if ($count > 0) {
                    return response()->json([
                        'responseMessage' => 'all modules',
                        'responseCode' => 200,
                        'responseStatus' => true,
                        'data' => $gz_submodule,
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


    //All Question and Answers
    public function show_gz_examAns(Request $request)
    {
        $method = $request->method();
        if ($method=="POST")
        {
            $smId = request('smId');
            if($smId=="")
            {
                return response()->json([
                    'responseMessage' => 'smId is mandatory',
                    'responseCode' => 404,
                    'responseStatus' =>false,
                ]);
            }
            else
            {
                $gameMode = request('gameMode');
                if($gameMode=="")
                {
                    return response()->json([
                        'responseMessage' => 'gameMode is mandatory',
                        'responseCode' => 404,
                        'responseStatus' =>false,
                    ]);
                }
                else
                {
                    $noOfQuestions = request('noOfQuestions');
                    if($noOfQuestions=="")
                    {
                        return response()->json([
                            'responseMessage' => 'noOfQuestions is mandatory',
                            'responseCode' => 404,
                            'responseStatus' =>false,
                        ]);
                    }
                    else
                    {

                        $gameId = request('gameId');
                        if($gameId=="")
                        {
                            return response()->json([
                                'responseMessage' => 'gameId is mandatory',
                                'responseCode' => 404,
                                'responseStatus' =>false,
                            ]);
                        }
                        else
                        {
                            $questionId = gzquestionidModel::select('qId')
                            ->where('giId', $gameId)
                            ->value('qId');

                            $finalString = "[" . $questionId . "]";
                            $finalString = json_decode($finalString);

                            $questions_with_answers = gzquestionModel::select(
                                'cqId',
                                'smId',
                                'qCode',
                                'question',
                                'optA',
                                'optB',
                                'optC',
                                'optD',
                                'question_level',
                                'isAvail',
                            )
                            ->with(['get_answers' => function ($query) {
                                    $query->select(
                                        'caId',
                                        'cqId',
                                        'optA',
                                        'optB',
                                        'optC',
                                        'optD',
                                        'isAvail',
                                    );
                                }])
                            ->whereIn('cqId', $finalString)
                            ->where('isAvail','0')
                            ->inRandomOrder()
                            ->get();

                            $count = $questions_with_answers->Count();
                            if($count>0)
                            {
                                return response()->json([
                                    'responseMessage' => 'questions and answers for game challenge',
                                    'responseCode' => 200,
                                    'responseStatus' =>true,
                                    'data' => $questions_with_answers,
                                ]);
                            }
                            else
                            {
                                return response()->json([
                                    'responseMessage' => 'NO QUESTIONS',
                                    'responseCode' => 404,
                                    'responseStatus' =>false,
                                ]);
                            }
                        }
                    }
                }
            }
        }
        else
        {
            return response()->json([
                'responseMessage' => 'NO METHOD ACCESS NOT FOUND',
                'responseCode' => 404,
                'responseStatus' =>false,
            ]);
        }
    }

    //All gamezone users
    public function show_gz_user()
    {
        try {
            // $data = gzuserDetailsModel::select()->get();

            $data = SubscriptionModel::select(
                'user_details.uId',
                'user_details.name',
                'user_details.mobile',
                'user_details.userImage'
                )
            ->join('app_plan_subscribers', 'app_plan_subscribers.planId', '=', 'subscriptions.planId')
            ->join('user_details', 'user_details.uId', '=', 'app_plan_subscribers.uId')
            ->where('subscriptions.gameZone', 1)
            ->where('app_plan_subscribers.isExpired', 0)
            ->get();

            return response()->json([
                'responseMessage' => 'all gamezone users',
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

    // getting game invite by me
    public function getGzInviteByMe(Request $request)
    {

        $uid = request('uid');
        try {
            $twentyFourHoursAgo = Carbon::now()->subHours(24);
            $formattedTwentyFourHoursAgo = $twentyFourHoursAgo->format('Y-m-d H:i:s');

        //     $data = gzinitializeModel::select(
        //         'gz_initialization.*',
        //         'gz_initialization.isAvail AS gameIsAvail',
        //         'user_details.*',
        //         'module.*'
        // )
            $data = gzinitializeModel::select(
                'gz_initialization.giId',
                'gz_initialization.gameType',
                'gz_initialization.date_time',
                'gz_initialization.moduleId',
                'gz_initialization.chapterId',
                'gz_initialization.gameMode',
                'gz_initialization.noOfQuestions',
                'gz_initialization.playerId',
                'gz_initialization.opponentId',
                'gz_initialization.firstOpponentId',
                'gz_initialization.isAccepted',
                'gz_initialization.isExpired',
                'gz_initialization.isAvail',
                'gz_initialization.isAvail AS gameIsAvail',
                'user_details.name',
                'user_details.userImage',
                'module.mId',
                'module.mName',
        )

            ->where('gz_initialization.playerId',$uid)
            ->where('gz_initialization.date_time','>=',$formattedTwentyFourHoursAgo)
            ->where('gz_initialization.gameType','!=','Subjectwise')
            ->join('user_details','user_details.uId','=','gz_initialization.firstOpponentId')
            ->leftJoin('module', function ($join) {
                $join->on('module.mId', '=', 'gz_initialization.moduleId')
                    ->where(function ($query) {
                        $query->where('gz_initialization.moduleId', '!=', 0)
                            ->orWhereNull('gz_initialization.moduleId');
                    });
            })
            ->orderBy('gz_initialization.giId', 'DESC')
            ->get();

            $data_count = count($data);
            for($i=0; $i<$data_count;$i++){
                $gameId = $data[$i]['giId'];
                $resultData = gzhistoryModel::where('giId', $gameId)
                    ->where('userId', $uid)
                    ->get();

                $resultDataCount = count($resultData);

                $newKeyForResultCount = "resultCount";
                if ($resultDataCount > 0) {
                    $newValueForResultCount = 1;
                } else {
                    $newValueForResultCount = 0;
                }
                
                $data[$i][$newKeyForResultCount] = $newValueForResultCount;
            }
            
            return response()->json([
                'responseStatus' => true,
                'responseCode' => 200,
                'responseMessage' => 'Game invite send by me',
                'gzInitMe' => $data,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'responseStatus' =>false,
                'responseCode' => 401,
                'responseMessage' => 'sorry, something went wrong' + $e,
            ]);
        }
    }
    // getting game invite by others
    public function getGzInviteByOthers(Request $request)
    {
        $uid = request('uid');
        try {
            $twentyFourHoursAgo = Carbon::now()->subHours(24);
            $formattedTwentyFourHoursAgo = $twentyFourHoursAgo->format('Y-m-d H:i:s');

            // $data = gzinitializeModel::select(
            //     'gz_initialization.*',
            //     'gz_initialization.isAvail AS gameIsAvail',
            //     'user_details.*',
            //     'module.*',
            //     'gz_initialization_acceptance.acceptedOpponents AS acceptOpp',
            //     'gz_initialization_acceptance.declinedOpponents AS declineOpp',
            // )

            $data = gzinitializeModel::select(
                'gz_initialization.giId',
                'gz_initialization.gameType',
                'gz_initialization.date_time',
                'gz_initialization.moduleId',
                'gz_initialization.chapterId',
                'gz_initialization.gameMode',
                'gz_initialization.noOfQuestions',
                'gz_initialization.playerId',
                'gz_initialization.opponentId',
                'gz_initialization.firstOpponentId',
                'gz_initialization.isAccepted',
                'gz_initialization.isExpired',
                'gz_initialization.isAvail',
                'gz_initialization.isAvail AS gameIsAvail',
                'user_details.name',
                'user_details.userImage',
                'module.mId',
                'module.mName',
                'gz_initialization_acceptance.acceptedOpponents AS acceptOpp',
                'gz_initialization_acceptance.declinedOpponents AS declineOpp',
            )

                ->whereRaw('FIND_IN_SET(?, REPLACE(REPLACE(REPLACE(gz_initialization.opponentId, "[", ""), "]", ""), " ", "")) > 0', [$uid])
                ->where('gz_initialization.date_time','>=',$formattedTwentyFourHoursAgo)
                ->where('gz_initialization.gameType','!=','Subjectwise')
                ->join('user_details', 'user_details.uId', '=', 'gz_initialization.playerId')
                ->leftJoin('gz_initialization_acceptance', function ($join) {
                    $join->on('gz_initialization_acceptance.giId', '=', 'gz_initialization.giId')
                        ->where(function ($query) {
                            $query->whereNotNull('gz_initialization.giId');
                        });
                })
                ->leftJoin('module', function ($join) {
                    $join->on('module.mId', '=', 'gz_initialization.moduleId')
                        ->where(function ($query) {
                            $query->whereNotNull('gz_initialization.moduleId');
                        });
                })
                ->orderBy('gz_initialization.giId', 'DESC')
                ->get();

                $data_count = count($data);
                for($i=0; $i<$data_count;$i++){
                    $gameId = $data[$i]['giId'];
                    $resultData = gzhistoryModel::where('giId', $gameId)
                        ->where('userId', $uid)
                        ->get();

                    $resultDataCount = count($resultData);

                    $newKeyForResultCount = "resultCount";
                    if ($resultDataCount > 0) {
                        $newValueForResultCount = 1;
                    } else {
                        $newValueForResultCount = 0;
                    }
                    
                    $data[$i][$newKeyForResultCount] = $newValueForResultCount;

                    $acceptedList = $data[$i]['acceptOpp'];
                    $acceptedListDecoded = json_decode($acceptedList, true);
                    $declinedList = $data[$i]['declineOpp'];
                    $declinedListDecoded =json_decode($declinedList, true);

                    $newKeyForAcceptance = "acceptedOrDeclinedOrNot";

                    if ($acceptedListDecoded !== null && in_array($uid, $acceptedListDecoded)) {
                        $newValueForAcceptance = 1;
                    } else if ($declinedListDecoded !== null && in_array($uid, $declinedListDecoded)) {
                        $newValueForAcceptance = 2;
                    } else {
                        $newValueForAcceptance = 0;
                    }

                    $data[$i][$newKeyForAcceptance] = $newValueForAcceptance;
                }

            return response()->json([
                'responseStatus' => true,
                'responseCode' => 200,
                'responseMessage' => 'Game invite send by others',
                'gzInitOthers' => $data,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'responseStatus' =>false,
                'responseCode' => 401,
                'responseMessage' => 'sorry, something went wrong',
            ]);
        }
    }
    // to accept the game invite
    public function acceptGzInvite(Request $request)
    {
        $giId = request('giId');
        $userId = request('userId');
        try {
            $intUserId = (int)$userId;
            $gameAccaptanceData = gzinitializationacceptanceModel::select('acceptedOpponents')
                ->where('giId', $giId)
                ->get();

            $acceptedList = $gameAccaptanceData[0]['acceptedOpponents'];
            $acceptedListDecoded = json_decode($acceptedList, true);

            if (in_array(0,$acceptedListDecoded)) {
                $arrayAfterZeroRemoval = array_diff($acceptedListDecoded, [0]);
                $finalArray = $arrayAfterZeroRemoval;
                array_push($finalArray, $intUserId);
            } else {
                $finalArray = $acceptedListDecoded;
                array_push($finalArray, $intUserId);
            }

            $finalArrayString = json_encode($finalArray);

            $response = gzinitializationacceptanceModel::where('giId', $giId)
                ->update(['acceptedOpponents' => $finalArrayString, 'updated_by' => $userId]);

            return response()->json([
                'responseStatus' => true,
                'responseCode' => 200,
                'responseMessage' => 'accepted the gz invite',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'responseStatus' =>false,
                'responseCode' => 401,
                'responseMessage' => 'sorry, something went wrong',
            ]);
        }
    }
    // to decline the game invite
    public function declineGzInvite(Request $request)
    {
        $giId = request('giId');
        $userId = request('userId');
        try {
            $intUserId = (int)$userId;
            $gameAccaptanceData = gzinitializationacceptanceModel::select('declinedOpponents')
                ->where('giId', $giId)
                ->get();

            $declinedList = $gameAccaptanceData[0]['declinedOpponents'];
            $declinedListDecoded = json_decode($declinedList, true);

            if (in_array(0,$declinedListDecoded)) {
                $arrayAfterZeroRemoval = array_diff($declinedListDecoded, [0]);
                $finalArray = $arrayAfterZeroRemoval;
                array_push($finalArray, $intUserId);
            } else {
                $finalArray = $declinedListDecoded;
                array_push($finalArray, $intUserId);
            }

            $finalArrayString = json_encode($finalArray);

            $response = gzinitializationacceptanceModel::where('giId', $giId)
                ->update(['declinedOpponents' => $finalArrayString, 'updated_by' => $userId]);

            return response()->json([
                'responseStatus' => true,
                'responseCode' => 200,
                'responseMessage' => 'declined the gz invite',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'responseStatus' =>false,
                'responseCode' => 401,
                'responseMessage' => 'sorry, something went wrong',
            ]);
        }
    }

    // getting game challenge history for showing result in game challenge summary page
    public function getGzHistory(Request $request)
    {
        $giId = request('giId');
        $userId = request('userId');
        try {
            $history_me = gzhistoryModel::select(
                'gz_history.ghId',
                'gz_history.giId',
                'gz_history.userId',
                'gz_history.winnerId',
                'gz_history.totalQuestion',
                'gz_history.attendedQuestions',
                'gz_history.rightAns', 'gz_history.wrongAns',
                'gz_history.score', 'gz_history.isPlayer',
                'gz_history.isOpponent',
                'gz_history.isAvail',
                'user_details.name AS winnerName'
                )
            ->where('gz_history.giId', $giId)
            ->where('gz_history.userId', $userId)
            ->join('user_details', 'user_details.uId', '=', 'gz_history.winnerId')
            ->get();
            
            $history_others = gzhistoryModel::select(
                'gz_history.ghId',
                'gz_history.giId',
                'gz_history.userId',
                'gz_history.winnerId',
                'gz_history.totalQuestion',
                'gz_history.attendedQuestions',
                'gz_history.rightAns',
                'gz_history.wrongAns',
                'gz_history.score',
                'gz_history.isPlayer',
                'gz_history.isOpponent',
                'gz_history.isAvail',
                'user_details.uId',
                'user_details.name',
                'winner.name AS winnerName'
                )
            ->where('gz_history.giId', $giId)
            ->where('gz_history.userId', '!=', $userId)
            ->join('user_details', 'user_details.uId', '=', 'gz_history.userId')
            ->join('user_details AS winner', 'winner.uId', '=', 'gz_history.winnerId')
            ->get();

            return response()->json([
                'responseStatus' => true,
                'responseCode' => 200,
                'responseMessage' => 'game history data based on giId',
                'historyDataMe' => $history_me,
                'historyDataOthers' => $history_others,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'responseStatus' =>false,
                'responseCode' => 401,
                'responseMessage' => 'sorry, something went wrong'+$e,
            ]);
        }
    }

    //get no. of wins of a user to show in gamezone home
    public function getWinCount(Request $request)
    {
        $userId = request('userId');
        try {
            $win_count = gzhistoryModel::where('winnerId',$userId)->count();

            return response()->json([
                'responseStatus' => true,
                'responseCode' => 200,
                'responseMessage' => 'count of win of user',
                'winCount' => $win_count,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'responseStatus' =>false,
                'responseCode' => 401,
                'responseMessage' => 'sorry, something went wrong',
            ]);
        }
    }
    //get sum of score of a user to show in gamezone home
    public function getScoreSum(Request $request)
    {
        $userId = request('userId');
        try {
            $score_sum = gzhistoryModel::where('userId',$userId)->sum('score');
            $string_score_sum = (string) $score_sum;

            return response()->json([
                'responseStatus' => true,
                'responseCode' => 200,
                'responseMessage' => 'sum of score of user',
                'scoreSum' => $string_score_sum,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'responseStatus' =>false,
                'responseCode' => 401,
                'responseMessage' => 'sorry, something went wrong',
            ]);
        }
    }

    // get details of friends in the game
    public function getGZFriendsList(Request $request)
    {
        $giId = request('giId');
        try {
            $data = gzinitializeModel::select('opponentId')->where('giId', $giId)->get();
            $opponentsList = $data[0]["opponentId"];
            $opponentsList = json_decode($opponentsList, true);
            $data_user = gzuserDetailsModel::select('name')->whereIn('uId', $opponentsList)->get();

            return response()->json([
                'responseStatus' => true,
                'responseCode' => 200,
                'responseMessage' => 'data of users in a game',
                // 'data' => $data,
                // "list" => $opponentsList,
                'user_data' => $data_user,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'responseStatus' =>false,
                'responseCode' => 401,
                'responseMessage' => 'sorry, something went wrong'+$e,
            ]);
        }
    }

    // get details of the chapters of the game
    public function getGZChapterList(Request $request)
    {
        $giId = request('giId');
        try {
            $data = gzinitializeModel::select('chapterId')->where('giId', $giId)->get();
            $chaptersList = $data[0]["chapterId"];
            $chaptersList = json_decode($chaptersList, true);
            $data_user = gzsubmoduleModel::select(
                'smId',
                'mId',
                'smCode',
                'smName',
                'currentCode',
                'isAvail'
                )
                ->whereIn('smId', $chaptersList)->get();

            return response()->json([
                'responseStatus' => true,
                'responseCode' => 200,
                'responseMessage' => 'data of chapters in a game',
                // 'data' => $data,
                // "list" => $opponentsList,
                'chapter_data' => $data_user,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'responseStatus' =>false,
                'responseCode' => 401,
                'responseMessage' => 'sorry, something went wrong'+$e,
            ]);
        }
    }

    // get gameinit details of the subjectwise game
    public function getGZInitSubjectwise(Request $request)
    {
        $uid = request('uid');
        $datetime = request('datetime');
        $gztype = request('gztype');

        try {
            $data = gzinitializeModel::select()
            ->where('playerId',$uid)
            ->where('date_time',$datetime)
            ->where('gameType',$gztype)
            ->leftJoin('module', function ($join) {
                $join->on('module.mId', '=', 'gz_initialization.moduleId')
                    ->where(function ($query) {
                        $query->where('gz_initialization.moduleId', '!=', 0)
                            ->orWhereNull('gz_initialization.moduleId');
                    });
            })
            ->get();

            return response()->json([
                'responseStatus' => true,
                'responseCode' => 200,
                'responseMessage' => 'data of chapters in a game',
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'responseStatus' =>false,
                'responseCode' => 401,
                'responseMessage' => 'sorry, something went wrong'+$e,
            ]);
        }
    }

    // checking gamezone result exist or not
    public function isGzResultExist(Request $request) 
    {
        $userId = request('userId');
        $giId = request('giId');
        
        try {
            $result = gzhistoryModel::select('gz_history.ghId')
            ->where('gz_history.giId', $giId)
            ->where('gz_history.userId', $userId)
            ->get();

            $count = $result->Count();
            if($count>0)
            {
                return response()->json([
                    'responseStatus' => true,
                    'responseCode' => 200,
                    'responseMessage' => 'result exists',
                    'resultExist' => '1',
                    // 'result' => $result
                ]);
            }
            else 
            {
                return response()->json([
                    'responseStatus' => true,
                    'responseCode' => 200,
                    'responseMessage' => 'result not exists',
                    'resultExist' => '0'
                ]);
            }
            
        } catch (\Exception $e) {
            return response()->json([
                'responseStatus' =>false,
                'responseCode' => 401,
                'responseMessage' => 'sorry, something went wrong'+$e,
            ]);
        }
    }
}