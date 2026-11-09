<?php

namespace App\Http\Controllers;

use App\Models\LiveGameModels\lgmasterModel;
use App\Models\LiveGameModels\lghistoryModel;
use App\Models\GameZoneModels\gzquestionModel;
use App\Models\GameZoneModels\gzanswerModel;
use App\Models\LiveGameModels\lgquestionModel;
use Illuminate\Http\Request;

class ApiLiveGameController extends Controller
{
    // initialising a live game
    // storing init data when live game being started
    public function storeLGMaster(Request $request)
    {
        $method = $request->method();
        if ($method == "POST")
        {
                
            $dateTime = request('dateTime');
            if($dateTime == "") 
            {
                return response()->json([
                    'responseStatus' => false,
                    'responseCode' => 400,
                    'responseMessage' => 'dateTime is mandatory',
                ]);
            } 
            else 
            {
                $userId = request('userId');
                if($userId == "") 
                {
                    return response()->json([
                        'responseStatus' => false,
                        'responseCode' => 400,
                        'responseMessage' => 'userId is mandatory',
                    ]);
                } 
                else 
                {
                    $nickname = request('nickname');
                    if($nickname == "") 
                    {
                        return response()->json([
                            'responseStatus' => false,
                            'responseCode' => 400,
                            'responseMessage' => 'nickname is mandatory',
                        ]);
                    }
                    else {
                        try {

                            $lgmdata = lgmasterModel::where('isAvail', '0')
                            ->inRandomOrder()
                            ->limit('1')
                            ->get();

                            $list_cqid = lgquestionModel::select('cqId')
                            ->where('isAvail', '0')
                            ->inRandomOrder()
                            ->limit('20')
                            ->get();

                            $list_cqid_length = sizeof($list_cqid);

                            $list_ofcqid_big_final = array();
                            for($i = 0; $i < $list_cqid_length; $i++)
                            {
                                $list_ofcqid_big_final[] = $list_cqid[$i]["cqId"];
                            }

                            $list_questionid_values = implode(",", $list_ofcqid_big_final);
                            
                            $count = count($lgmdata);
                            if($count == 0) {
                                $store_data = new lgmasterModel();
                                $store_data->dateTime = $dateTime;
                                $store_data->playerId = $userId;
                                $store_data->playerNickname = $nickname;
                                $store_data->opponentId = '0';
                                $store_data->opponentNickname = 'None';
                                $store_data->questionId = $list_questionid_values;
                                $store_data->created_by = $userId;
                                $store_data->save();
                            }
                            else {
                                $lgmId = $lgmdata[0]['lgmId'];
                                $store_data = lgmasterModel::where('lgmId',$lgmId)->update([
                                    'opponentId'=>$userId,
                                    'opponentNickname'=>$nickname,
                                    'isAvail'=>'1',
                                    'updated_by'=>$userId
                                ]);
                            }

                            return response()->json([
                                'responseStatus' =>true,
                                'responseCode' => 200,
                                'responseMessage' => 'Record saved successfully',
                                // 'count' => $count,
                                // 'cqidlist' => $list_cqid
                                // 'convertedlistintolistloop' => $list_questionid_values
                                
                            ]); 
                        } catch (\Exception $e) {
                            return response()->json([
                                'responseStatus' => false,
                                'responseCode' => 400,
                                'responseMessage' => 'Something went wrong, record not saved'+$e,
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

    //showing the live game details
    public function showLGMaster(Request $request)
    {
        $userId = request('userId');
        if($userId == "") 
        {
            return response()->json([
                'responseStatus' => false,
                'responseCode' => 400,
                'responseMessage' => 'userId is mandatory',
            ]);
        } 
        else 
        {
            try {
                $data = lgmasterModel::where(function ($query) use ($userId) {
                    $query->where('playerId', $userId)
                          ->orWhere('opponentId', $userId);
                })
                ->where('isAvail', '1')
                ->get();
        
                return response()->json([
                    'responseStatus' => true,
                    'responseCode' => 200,
                    'responseMessage' => 'live game you are in',
                    'data' => $data,
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'responseStatus' =>false,
                    'responseCode' => 401,
                    'responseMessage' => 'sorry, something went wrong',
                ]);
            }
        }
    }

    // show live game questions and answers
    public function showLGQues()
    {
        $questionId = request('questionId');
        if($questionId=="")
        {
            return response()->json([
                'responseMessage' => 'questionId is mandatory',
                'responseCode' => 404,
                'responseStatus' =>false,
            ]);
        }
        else
        {
            try 
            {
                $string_main = json_decode($questionId);
                $finalString = "[" . $string_main . "]";
                $finalString = json_decode($finalString);

                $questions_with_answers = gzquestionModel::with('get_answers')
                // ->where('isAvail','0')
                // ->limit('40')
                ->whereIn('cqId', $finalString)
                ->where('isAvail','0')
                ->inRandomOrder()
                ->get();
                
        
                $count = $questions_with_answers->Count();
                if($count>0)
                {
                    return response()->json([
                        'responseMessage' => 'all questions and answers',
                        'responseCode' => 200,
                        'responseStatus' =>true,
                        'data'=>$questions_with_answers,
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
            catch (\Exception $e) 
            {
                return response()->json([
                    'responseStatus' =>false,
                    'responseCode' => 401,
                    'responseMessage' => 'sorry, something went wrong',
                ]);
            }
        }
    }

    // storing live game history
    // storing live game history data after finishing the live game quiz
    public function storeLGHistory(Request $request)
    {
        $method = $request->method();
        if ($method == "POST")
        {
            $lgmId = request('lgmId');
            if ($lgmId == "") 
            {
                return response()->json([
                    'responseStatus' => false,
                    'responseCode' => 401,
                    'responseMessage' => 'lgmId is mandatory',
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
                    $nickname = request('nickname');
                    if ($nickname == "") 
                    {
                        return response()->json([
                            'responseStatus' => false,
                            'responseCode' => 401,
                            'responseMessage' => 'nickname is mandatory',
                        ]);
                    } 
                    else 
                    {

                        $totalQuestions = request('totalQuestions');
                        if ($totalQuestions == "") 
                        {
                            return response()->json([
                                'responseStatus' => false,
                                'responseCode' => 401,
                                'responseMessage' => 'totalQuestions is mandatory',
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
                                                    try 
                                                    {
                                                        // $resultCount = lghistoryModel::where('lgmId',$lgmId)->count('lghId');
                                                        // $resultCountDecoded = json_decode($resultCount);

                                                        $current_winner_array = lghistoryModel::select('winnerId')->where('lgmId',$lgmId)->get();
                                                        if($current_winner_array == null || $current_winner_array == "" || $current_winner_array == "[]")
                                                        {
                                                            $current_winner_decoded = 0;
                                                        }
                                                        else
                                                        {
                                                            $current_winner = $current_winner_array[0]["winnerId"];
                                                            $current_winner_decoded = json_decode($current_winner, true);
                                                        }

                                                        $high_score = lghistoryModel::where('lgmId',$lgmId)->max('score');
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
                                                            $storeLGHistory = new lghistoryModel();
                                                            $storeLGHistory->lgmId = $lgmId;
                                                            $storeLGHistory->userId = $userId;
                                                            $storeLGHistory->nickname = $nickname;
                                                            $storeLGHistory->winnerId = $userId;
                                                            $storeLGHistory->totalQuestions = $totalQuestions;
                                                            $storeLGHistory->attendedQuestions = $attendedQuestions;
                                                            $storeLGHistory->rightAns = $rightAns;
                                                            $storeLGHistory->wrongAns = $wrongAns;
                                                            $storeLGHistory->score = $score;
                                                            $storeLGHistory->created_by = $userId;
                                                            $storeLGHistory->created_at = $startDateTime;
                                                            $storeLGHistory->updated_by = $userId;
                                                            $storeLGHistory->updated_at = $endDateTime;
                                                            $storeLGHistory->save();
                                                        }
                                                        else
                                                        {
                                                            if($high_score_decoded < $score)
                                                            {
                                                                $storeLGHistory = new lghistoryModel();
                                                                $storeLGHistory->lgmId = $lgmId;
                                                                $storeLGHistory->userId = $userId;
                                                                $storeLGHistory->nickname = $nickname;
                                                                $storeLGHistory->winnerId = $userId;
                                                                $storeLGHistory->totalQuestions = $totalQuestions;
                                                                $storeLGHistory->attendedQuestions = $attendedQuestions;
                                                                $storeLGHistory->rightAns = $rightAns;
                                                                $storeLGHistory->wrongAns = $wrongAns;
                                                                $storeLGHistory->score = $score;
                                                                $storeLGHistory->created_by = $userId;
                                                                $storeLGHistory->created_at = $startDateTime;
                                                                $storeLGHistory->updated_by = $userId;
                                                                $storeLGHistory->updated_at = $endDateTime;
                                                                $storeLGHistory->save();

                                                                $update_all_winnerId = lghistoryModel::where('lgmId',$lgmId)->update([
                                                                    'winnerId' => $userId
                                                                ]);

                                                                $update_data = lgmasterModel::where('lgmId',$lgmId)->update([
                                                                    'isAvail'=>'2',
                                                                    'updated_by'=>$userId
                                                                ]);
                                                            }
                                                            else
                                                            {
                                                                $storeLGHistory = new lghistoryModel();
                                                                $storeLGHistory->lgmId = $lgmId;
                                                                $storeLGHistory->userId = $userId;
                                                                $storeLGHistory->nickname = $nickname;
                                                                $storeLGHistory->winnerId = $current_winner;
                                                                $storeLGHistory->totalQuestions = $totalQuestions;
                                                                $storeLGHistory->attendedQuestions = $attendedQuestions;
                                                                $storeLGHistory->rightAns = $rightAns;
                                                                $storeLGHistory->wrongAns = $wrongAns;
                                                                $storeLGHistory->score = $score;
                                                                $storeLGHistory->created_by = $userId;
                                                                $storeLGHistory->created_at = $startDateTime;
                                                                $storeLGHistory->updated_by = $userId;
                                                                $storeLGHistory->updated_at = $endDateTime;
                                                                $storeLGHistory->save();

                                                                $update_all_winnerId = lghistoryModel::where('lgmId',$lgmId)->update([
                                                                    'winnerId' => $current_winner
                                                                ]);

                                                                $update_data = lgmasterModel::where('lgmId',$lgmId)->update([
                                                                    'isAvail'=>'2',
                                                                    'updated_by'=>$userId
                                                                ]);
                                                            }
                                                        }

                                                        return response()->json([
                                                            'responseStatus' =>true,
                                                            'responseCode' => 200,
                                                            'responseMessage' => 'Record saved successfully',
                                                        ]); 
                                                    } 
                                                    catch (\Exception $e) 
                                                    {
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
        else
        {
            return response()->json([
                'responseStatus' =>false,
                'responseCode' => 404,
                'responseMessage' => 'INCORRECT METHOD, ACCESS DENIED',
            ]);
        }
    }

    //show live game result
    public function showLGHistory(Request $request)
    {
        $lgmId = request('lgmId');
        $userId = request('userId');
        try 
        {
            $history_me = lghistoryModel::select('livegame_history.userId','livegame_history.nickname','livegame_history.winnerId','livegame_history.score')
            ->where('livegame_history.lgmId', $lgmId)
            ->where('livegame_history.userId', $userId)
            ->get();

            $history_others = lghistoryModel::select('livegame_history.userId','livegame_history.nickname','livegame_history.winnerId','livegame_history.score')
            ->where('livegame_history.lgmId', $lgmId)
            ->where('livegame_history.userId', '!=', $userId)
            ->get();

            $lgmData = lgmasterModel::select('isAvail')->where('lgmId',$lgmId)->get();
            $lgmIsAvail = json_decode($lgmData[0]["isAvail"]);

            return response()->json([
                'responseStatus' => true,
                'responseCode' => 200,
                'responseMessage' => 'livegame history data based on lgmId and userId',
                'historyDataMe' => $history_me,
                'historyDataOthers' => $history_others,
                'lgmIsAvail' => $lgmIsAvail
            ]);
        } 
        catch (\Exception $e) 
        {
            return response()->json([
                'responseStatus' =>false,
                'responseCode' => 401,
                'responseMessage' => 'sorry, something went wrong'+$e,
            ]);
        }
    }

    //update live game master details when user exited the game
    public function lgExited()
    {
        $userId = request('userId');
        try 
        {
            $response = lgmasterModel::where(function ($query) use ($userId) {
                $query->where('playerId', $userId)
                      ->orWhere('opponentId', $userId);
            })
            ->whereIn('isAvail', ['0', '1'])
            ->update(['isAvail' => '3']);

            return response()->json([
                'responseStatus' => true,
                'responseCode' => 200,
                'responseMessage' => 'exited from this livegame',
            ]);
        } 
        catch (\Exception $e) 
        {
            return response()->json([
                'responseStatus' =>false,
                'responseCode' => 401,
                'responseMessage' => 'sorry, something went wrong',
            ]);
        }
    }
}
