<?php

namespace App\Http\Controllers;

use App\Models\ExamBankModels\QuestionModel;
use Illuminate\Routing\Controller;
use App\Models\CrashCourse\courseMasterModel;
use App\Models\CrashCourse\courseHistoryModel;
use App\Models\CrashCourse\courseBatchesModel;
use Illuminate\Support\Facades\DB;
use App\Models\CrashCourse\courseSubscribersModel;

class ApiCrashCourseController extends Controller
{
    //Show crash course subscriptions
    public function show_ccSubscription()
    {
        try {
            $data = courseMasterModel::where('isClosed',0)->get();
            return response()->json([
                'responseMessage' => 'Crash Course Subscription',
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

    //show crash course batch using user id
    public function show_ccBatch()
    {
        $uId = request('uId');
        if ($uId == "") {
            return response()->json([
                'responseMessage' => 'uId is mandatory',
                'responseCode' => 401,
                'responseStatus' => false,
            ]);
        } else {
            $Batch = DB::table('course_batches')
                ->distinct()
                ->select('course_batches.*')
                ->join('course_subscribers', 'course_batches.cmId', '=', 'course_subscribers.cmId')
                ->where('course_batches.isClosed', '=', 0)
                ->where('course_subscribers.uId', '=', $uId)
                ->get();
                
               // print_r($Batch);die;
            $count = $Batch->count();
            if ($count > 0) {
                return response()->json([
                    'responseMessage' => 'User Batch',
                    'responseCode' => 200,
                    'responseStatus' => true,
                    'data' => $Batch,
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

  //show crash course batch days using batch id
  public function show_ccBatchDays()
  {
      $cbId = request('cbId');
      $uId = request('uId');
      if ($cbId == "") {
          return response()->json([
              'responseMessage' => 'cbId is mandatory',
              'responseCode' => 401,
              'responseStatus' => false,
          ]);
      }
      if ($uId == "") {
          return response()->json([
              'responseMessage' => 'uId is mandatory',
              'responseCode' => 401,
              'responseStatus' => false,
          ]);
      } else {
          
          
          $BatchDays = courseBatchesModel:: select('course_batch_days.cbdId', 'course_batch_days.Date', 'course_batch_days.dayName',
              'course_batch_days.mId', 'course_batch_days.smId', 'course_batch_days.cbId', 'course_batch_days.isActive',
              'course_batch_days.isExam', 'course_batches.cbId AS course_batch_id', 'course_batches.cbatchName',
              'course_history.totalQuestions AS total_quest', 'course_history.QuestionsAttended AS total_attend_quest',
              'course_history.score AS total_score','course_history.percentage AS percentage')
              ->leftJoin('course_batch_days', 'course_batches.cbId', '=', 'course_batch_days.cbId')
              ->leftJoin('course_history', function($join) use ($uId) {
                  $join->on('course_batch_days.cbdId', '=', 'course_history.cbdId')
                      ->where('course_history.uId', '=', $uId);
              })
              ->where('course_batches.cbId', '=', $cbId)->where('course_batch_days.isActive','0')
              ->get();

          $count = $BatchDays->count();
          if ($count > 0) {
              return response()->json([
                  'responseMessage' => 'User Batch Days',
                  'responseCode' => 200,
                  'responseStatus' => true,
                  'data' => $BatchDays,
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

    public function show_ccQuestionAns()
    {

            $smId = request('smId');
            if ($smId == "") {
                return response()->json([
                    'responseMessage' => 'smId is mandatory',
                    'responseCode' => 404,
                    'responseStatus' => false,
                ]);
            } else {
                $smIdArray = json_decode($smId);
                $questions_with_answers = QuestionModel::with('get_answers')
                    ->where('isAvail',0)
                    ->whereIn('smId', $smIdArray)
                    ->inRandomOrder()
                    ->get();
                $count = $questions_with_answers->Count();
                if ($count > 0) {
                    return response()->json([
                        'responseMessage' => 'all questions and answers',
                        'responseCode' => 200,
                        'responseStatus' => true,
                        'data' => $questions_with_answers,
                    ]);
                } else {
                    return response()->json([
                        'responseMessage' => 'NO QUESTIONS',
                        'responseCode' => 404,
                        'responseStatus' => false,
                    ]);
                }
            }
        }




         //store crash course exam history
    public function storeCcExamHistory()
    {
        date_default_timezone_set("Asia/Calcutta");   //India time (GMT+5:30)

        $currentDateTime = date('Y-m-d H:i:s');
        $currentDate = date('Y-m-d');
        $currentTime = date('H:i:s');

        $this->currentDate = $currentDate;
        $this->currentTime = $currentTime;
        $this->currentDateTime = $currentDateTime;
    

            $cbId= request('cbId');
            $cbdId= request('cbdId');
            $mId= request('mId');
            $smId= request('smId');
            $uId= request('uId');
            $totalQuestions= request('totalQuestions');
            $QuestionsAttended= request('QuestionsAttended');
            $rightAns= request('rightAns');
            $wrongAns= request('wrongAns');
            $score= request('score');
            $percentage= request('percentage');
            $created_by = request('created_by');
            $updated_by = request('updated_by');

            try {
                
                $getcbdId=courseHistoryModel::where('cbdId',$cbdId)->where('uId',$uId)->value('chId');
                
                if($getcbdId){
                    
                    $updatedatas=courseHistoryModel::where('chId',$getcbdId)
                    ->update([
                        'dateAndTime'=>$currentDate,
                        'totalQuestions'=>$totalQuestions,
                        'QuestionsAttended'=>$QuestionsAttended,
                        'rightAns'=>$rightAns,
                        'wrongAns'=>$wrongAns,
                        'score'=>$score,
                        'percentage'=>$percentage
                        
                        ]);
                         return response()->json([
                            'responseStatus' =>true,
                            'responseCode' => 200,
                            'responseMessage' => 'Record saved successfully',
                        ]);
                    
                }else{
                    
                     $storeDailyExamHistory = new courseHistoryModel();
                $data = [

                    'cbId'=>$cbId,
                    'dateAndTime'=>$currentDate,
                    'cbdId'=>$cbdId,
                    'mId'=>$mId,
                    'smId'=>$smId,
                    'uId'=>$uId,
                    'totalQuestions'=>$totalQuestions,
                    'QuestionsAttended'=>$QuestionsAttended,
                    'rightAns'=>$rightAns,
                    'wrongAns'=>$wrongAns,
                    'score'=>$score,
                    'percentage'=>$percentage,
                   // 'created_at'=>$created_by,
                   // 'updated_at'=>$updated_by
                ];
                $data = array_filter($data, function ($value) {
                    return $value !== null;
                });
                $storeDailyExamHistory->fill($data);
                $storeDailyExamHistory->save();
                return response()->json([
                    'responseStatus' =>true,
                    'responseCode' => 200,
                    'responseMessage' => 'Record saved successfully',
                ]);
                    
                }
                
                
               
            } catch (\Exception $e) {
                return response()->json([
                    'responseStatus' => false,
                    'responseCode' => 400,
                    'responseMessage' => 'Something went wrong, record not saved '. $e,
                ]);
            }
    }
       

    //view crash course exam history
    public function show_CcExamHistory()
    {
        $uId = request('uId');
        $cbId = request('cbId');
        if ($cbId == "") {
            return response()->json([
                'responseMessage' => 'cbId is mandatory',
                'responseCode' => 401,
                'responseStatus' => false,
            ]);
        }
        if ($uId == "") {
            return response()->json([
                'responseMessage' => 'uId is mandatory',
                'responseCode' => 401,
                'responseStatus' => false,
            ]);
        }
        else {
                $history = courseBatchesModel::select('course_batches.cbId', 'course_batches.cbatchName')
                    ->selectRaw('SUM(course_history.totalQuestions) AS total_quest')
                    ->selectRaw('SUM(course_history.QuestionsAttended) AS total_attend_quest')
                    ->selectRaw('SUM(course_history.rightAns) AS total_right_Ans')
                    ->selectRaw('SUM(course_history.wrongAns) AS total_wrongAns')
                    ->selectRaw('SUM(course_history.score) AS total_score')
                    ->join('course_history', 'course_batches.cbId', '=', 'course_history.cbId')
                    ->where('course_history.cbId', $cbId)
                    ->where('course_history.uId', $uId)
                    ->groupBy('course_batches.cbId', 'course_batches.cbatchName')
                    ->get();

                $count = $history->count();
                if ($count > 0) {
                    return response()->json([
                        'responseMessage' => 'User Batch Days',
                        'responseCode' => 200,
                        'responseStatus' => true,
                        'data' => $history,
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






    
    //store crash course user subscription LAST COMMENTED 30-09-2023
    // public function storeCcUserSubscription()
    // {
    //     date_default_timezone_set("Asia/Calcutta");   //India time (GMT+5:30)
    //     $currentDate = date('Y-m-d');
    //     $this->currentDate = $currentDate;
    //     $cmId= request('cmId');
    //     $uId= request('uId');
    //     $transactionNumber= request('transactionNumber');
    //     try {
    //         $storeDailyExamHistory = new courseSubscribersModel();
    //         $data = [
    //             'cmId'=>$cmId,
    //             'uId'=>$uId,
    //             'transactionNumber'=>$transactionNumber,
    //             'csDate'=>$currentDate,
    //         ];
    //         $data = array_filter($data, function ($value) {
    //             return $value !== null;
    //         });
    //         $storeDailyExamHistory->fill($data);
    //         $storeDailyExamHistory->save();
    //         return response()->json([
    //             'responseStatus' =>true,
    //             'responseCode' => 200,
    //             'responseMessage' => 'Record saved successfully',
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'responseStatus' => false,
    //             'responseCode' => 400,
    //             'responseMessage' => 'Something went wrong, record not saved '. $e,
    //         ]);
    //     }
    // }
    //LAST UPDATED 30-09-2023
    //store crash course user subscription
    public function storeCcUserSubscription()
    {
        date_default_timezone_set("Asia/Calcutta");   //India time (GMT+5:30)
        $currentDate = date('Y-m-d');
        $this->currentDate = $currentDate;
        $cmId= request('cmId');
        $uId= request('uId');
        $transactionNumber= request('transactionNumber');
        $netPayableAmount= request('netPayableAmount');
        try {
            $storeDailyExamHistory = new courseSubscribersModel();
            $data = [
                'cmId'=>$cmId,
                'uId'=>$uId,
                'transactionNumber'=>$transactionNumber,
                'netPayableAmount'=>$netPayableAmount,
                'csDate'=>$currentDate,
            ];
            $data = array_filter($data, function ($value) {
                return $value !== null;
            });
            $storeDailyExamHistory->fill($data);
            $storeDailyExamHistory->save();
            return response()->json([
                'responseStatus' =>true,
                'responseCode' => 200,
                'responseMessage' => 'Record saved successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'responseStatus' => false,
                'responseCode' => 400,
                'responseMessage' => 'Something went wrong, record not saved '. $e,
            ]);
        }
    }
    
    
    
    
    
     //check user Id in crash course subscription table
     public function checkUidCcSub(){
        $uId = request('uId');
        if ($uId == "") {
            return response()->json([
                'responseMessage' => 'uId is mandatory',
                'responseCode' => 401,
                'responseStatus' => false,
            ]);
        }
        else {
            $data =courseSubscribersModel::where('uId', $uId)->count();
            if ($data == 1) {
                return response()->json([
                    'responseMessage' => 'User in crash course sub',
                    'responseCode' => 200,
                    'responseStatus' => true,
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
