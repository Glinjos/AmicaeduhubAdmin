<?php

/**
 * Created by phpStorm.
 * Use: Module Wise Exam(Exam Bank)
 * View Modules,View Submodules,View Questions and Answers
 */

namespace App\Http\Controllers;

use App\Models\ExamBankModels\dailyExamHistoryModel;

use App\Models\ExamBankModels\dailyexamModel;
use App\Models\ExamBankModels\moduleModel;
use App\Models\ExamBankModels\QuestionModel;
use App\Models\ExamBankModels\SubmoduleModel;
use App\Models\ExamBankModels\tempQuestDailyExamModel;
use Illuminate\Http\Request;
use DB;

class ApiExamBankController extends Controller
{

//all module view for module wise exam
    public function show_module()
    {
        try {
            $data = moduleModel::select()->where('isAvail',0)->get();
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

//all submodule view for module wise exam
    public function show_submodule()
    {
        $mId = request('mId');
        if ($mId == "") {
            return response()->json([
                'responseMessage' => 'mId is mandatory',
                'responseCode' => 401,
                'responseStatus' => false,
            ]);
        } else {
            $gz_submodule = SubmoduleModel::where('mId', $mId)->where('isAvail', 0)->orderby('smName','asc')->get(); 
            $count = $gz_submodule->count();
            if ($count > 0) {
                return response()->json([
                    'responseMessage' => 'all submodules',
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

//all questions and answers view for module wise exam
    public function show_examAns(Request $request)
    {
        $method = $request->method();
        if ($method=="POST"){
            $smId = request('smId');
            if($smId==""){
                return response()->json([
                    'responseMessage' => 'smId is mandatory',
                    'responseCode' => 404,
                    'responseStatus' =>false,
                ]);
            }else{
                
                $input_limit = request('limit');
                if($input_limit==""){
                   
                    $questions_with_answers = QuestionModel::with('get_answers')
                    ->where('smId', $smId)->where('isAvail',0)
                    ->inRandomOrder()
                   // ->limit()
                    ->get();

                    $count = $questions_with_answers->Count();
                    if($count>0){
                        return response()->json([
                            'responseMessage' => 'all questions and answers',
                            'responseCode' => 200,
                            'responseStatus' =>true,
                            'data'=>$questions_with_answers,
                        ]);
                    }else{
                        return response()->json([
                            'responseMessage' => 'NO QUESTIONS',
                            'responseCode' => 404,
                            'responseStatus' =>false,
                        ]);
                    }
                   
                }else{
                    
                    
                $questions_with_answers = QuestionModel::with('get_answers')
                    ->where('smId', $smId)->where('isAvail',0)
                    ->inRandomOrder()
                    ->limit($input_limit)
                    ->get();

                $count = $questions_with_answers->Count();
                if($count>0){
                    return response()->json([
                        'responseMessage' => 'all questions and answers',
                        'responseCode' => 200,
                        'responseStatus' =>true,
                        'data'=>$questions_with_answers,
                    ]);
                }else{
                    return response()->json([
                        'responseMessage' => 'NO QUESTIONS',
                        'responseCode' => 404,
                        'responseStatus' =>false,
                    ]);
                }
            }//for limit
            }//for smId
        }else{
            return response()->json([
                'responseMessage' => 'NO METHOD ACCESS NOT FOUND',
                'responseCode' => 404,
                'responseStatus' =>false,
            ]);
        }
    }

//DAILY EXAM START
//all schedule Daily Exam
    public function show_scheduleDailyExam()
    {
        try {

            // $data = DB::select("SELECT t2.modulesId, GROUP_CONCAT(t1.mName SEPARATOR ',') AS moduleNames, t2.*
            // FROM (
            //   SELECT *
            //   FROM `daily_exam`
            // ) AS t2
            // INNER JOIN `module` AS t1 ON FIND_IN_SET(t1.mId, t2.modulesId)
            // WHERE FIND_IN_SET(t1.mId, t2.modulesId) > 0
           
            // GROUP BY t2.modulesId, t2.dId, t2.examName, t2.examdate, t2.timeFrom, t2.timeTo,
            //  t2.noOfQuestions, t2.postiveMark, t2.negativeMark
            //  ORDER BY
            //  t2.examdate DESC;");
            $data = DB::select("SELECT t2.modulesId, GROUP_CONCAT(t1.mName SEPARATOR ', ') AS moduleNames, t2.*
            FROM (
              SELECT *
              FROM `daily_exam`
            ) AS t2
            INNER JOIN `module` AS t1 ON FIND_IN_SET(t1.mId, t2.modulesId)
            WHERE FIND_IN_SET(t1.mId, t2.modulesId) > 0
            AND t2.isExpired IN (1)
            GROUP BY t2.modulesId, t2.dId, t2.examName, t2.examdate, t2.timeFrom, t2.timeTo,
             t2.noOfQuestions, t2.postiveMark, t2.negativeMark
             
             ORDER BY
             t2.examdate DESC;");

            // return response()->json([
            //     'responseMessage' => 'Schedule Daily Exam',
            //     'responseCode' => 200,
            //     'responseStatus' =>true,
            //     'data'=>$data,
            // ]);

            if (count($data) > 0) {
                return response()->json([
                    'responseMessage' => 'Schedule Daily Exam',
                    'responseCode' => 200,
                    'responseStatus' => true,
                    'data' => $data,
                ]);
            } else {
                return response()->json([
                    'responseMessage' => 'No data found',
                    'responseCode' => 404, 
                    'responseStatus' => false,
                ]);
            }


        } catch (\Exception $e) {
            return response()->json([
                'responseMessage' => 'An error occurred',
                'responseCode' => 500,
                'responseStatus' =>false,
            ]);
        }
    }
    //show all question and answers in daily exam
    public function show_questionsAns(Request $request)
    {
       
        $method = $request->method();
        if ($method=="POST"){
            $dId = request('dId');
            if($dId==""){
                return response()->json([
                    'responseMessage' => 'dId is mandatory',
                    'responseCode' => 404,
                    'responseStatus' =>false,
                ]);
            }else{
                
                $questions_with_answers = tempQuestDailyExamModel::with('get_answers')
                    ->where('dId', $dId)
                   // ->where('isAvail',0)
                    ->inRandomOrder()
                    //->limit(1)
                    ->get();
                // try {
                //         $questions_with_answers = tempQuestDailyExamModel::with('get_answers')
                //             ->where('dId', $dId)
                //             ->where('isAvail', 0)
                //             ->inRandomOrder()
                //             ->get();
                //     } catch (\Exception $e) {
                //         // Handle and log the exception
                //         dd($e->getMessage());
                //     }
                    
                   

                $count = $questions_with_answers->Count();
                if($count>0){
                    return response()->json([
                        'responseMessage' => 'all questions and answers',
                        'responseCode' => 200,
                        'responseStatus' =>true,
                        'data'=>$questions_with_answers,
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
//DAILY EXAM END


//---------------------DAILY EXAM HISTORY-------------
//insert  daily exam history
public function storeDailyExamHistory(Request $request)
{
    $method = $request->method();
    if ($method == "POST")
    {
        date_default_timezone_set('Asia/Calcutta');
        $dateAndTime = date('Y-m-d H:i:s');

        $dId=request('dId');
        if($dId==""){
            return response()->json([
                'responseStatus' => false,
                'responseCode' => 400,
                'responseMessage' => 'dId is mandatory.',
            ]);
        }
        else{

       
        $uId=request('uId');
        if($uId==""){
            return response()->json([
                'responseStatus' => false,
                'responseCode' => 400,
                'responseMessage' => 'uId is mandatory.',
            ]);
        }
        else{

        $totalMark=request('totalMark');
        if($totalMark==""){
            return response()->json([
                'responseStatus' => false,
                'responseCode' => 400,
                'responseMessage' => 'totalMark is mandatory.',
            ]);
        }
        else{

        $rightAns=request('rightAns');
        if($rightAns==""){
            return response()->json([
                'responseStatus' => false,
                'responseCode' => 400,
                'responseMessage' => 'rightAns is mandatory.',
            ]);
        }
        else{

        $wrongAns=request('wrongAns');
        if($wrongAns==""){
            return response()->json([
                'responseStatus' => false,
                'responseCode' => 400,
                'responseMessage' => 'wrongAns is mandatory.',
            ]);
        }
        else{

        $created_by = request('created_by');
        $updated_by = request('updated_by');

        try {

           // print_r('hi');die;
            $existingRecord = dailyExamHistoryModel::where('dId', $dId)
            ->where('uId', $uId)
            ->value('historyId');

           // print_r($existingRecord);die;

            if ($existingRecord) {
               $updateEXMHist=dailyExamHistoryModel::where('historyId',$existingRecord)
               ->update([
                'dId' => $dId,
                'uId' => $uId,
                'totalMark' => $totalMark,
                'rightAns' => $rightAns,
                'wrongAns' => $wrongAns,
               ]);

               return response()->json([
                'responseStatus' =>true,
                'responseCode' => 200,
                'responseMessage' => 'Record saved successfully',
            ]);


            }else{
   
            $storeDailyExamHistory = new dailyExamHistoryModel();
            $storeDailyExamHistory->dId        =$dId;
            $storeDailyExamHistory->uId        =$uId;
            $storeDailyExamHistory->totalMark  =$totalMark;
            $storeDailyExamHistory->rightAns   =$rightAns;
            $storeDailyExamHistory->wrongAns   =$wrongAns;
            $storeDailyExamHistory->created_by =$uId;
            $storeDailyExamHistory->updated_by ='0';
            $storeDailyExamHistory->save();

           

            return response()->json([
                'responseStatus' =>true,
                'responseCode' => 200,
                'responseMessage' => 'Record saved successfully',
            ]);

        }// else success
           
        } catch (\Exception $e) {
            return response()->json([
                'responseStatus' => false,
                'responseCode' => 400,
                'responseMessage' => 'Something went wrong, record not saved '. $e,
            ]);
        }



    }//wrongAns
    }//rightAns
    }//totalMark
    }//uid
    }//did




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

// public function storeDailyExamHistory(Request $request)
// {
//     $method = $request->method();
//     if ($method == "POST")
//     {
//         date_default_timezone_set('Asia/Calcutta');
//         $dateAndTime = date('Y-m-d H:i:s');

//         $dId=request('dId');
//         $uId=request('uId');
//         $totalMark=request('totalMark');
//         $rightAns=request('rightAns');
//         $wrongAns=request('wrongAns');

//         $created_by = request('created_by');
//         $updated_by = request('updated_by');

//         try {
//             $storeDailyExamHistory = new dailyExamHistoryModel();

//             $data = [

//                 'dId' => $dId,
//                 'uId' => $uId,
//                 'totalMark' => $totalMark,
//                 'rightAns' => $rightAns,
//                 'wrongAns' => $wrongAns,

//                 'created_by' => '1',
//                 'updated_by' => '0',
//             ];

//             $data = array_filter($data, function ($value) {
//                 return $value !== null;
//             });

//             $storeDailyExamHistory->fill($data);
//             $storeDailyExamHistory->save();


//             return response()->json([
//                 'responseStatus' =>true,
//                 'responseCode' => 200,
//                 'responseMessage' => 'Record saved successfully',
//             ]);
//         } catch (\Exception $e) {
//             return response()->json([
//                 'responseStatus' => false,
//                 'responseCode' => 400,
//                 'responseMessage' => 'Something went wrong, record not saved '. $e,
//             ]);
//         }
//     }
//     else
//     {
//         return response()->json([
//             'responseStatus' =>false,
//             'responseCode' => 404,
//             'responseMessage' => 'INCORRECT METHOD, ACCESS DENIED',
//         ]);
//     }
// }

//show daily exam history
public function showDailyExamHistory()
{
    $uId = request('uId');
    if ($uId == "") {
        return response()->json([
            'responseMessage' => 'uId is mandatory',
            'responseCode' => 401,
            'responseStatus' => false,
        ]);
    } else {
        // $data = DB::table('daily_exam_history as t1')
        //     ->select('t1.*', 't2.*', 't3.name','t4.mName')
        //     ->join('daily_exam as t2', 't2.dId', '=', 't1.dId')
        //     ->join('module as t4', function ($join) {
        //         $join->on('t2.modulesId', 'LIKE', DB::raw("CONCAT('%', t4.mId, '%')"));
        //     })
        //     ->join('user_details as t3', 't3.uId', '=', 't1.uId')
        //     ->where('t1.uId', '=', $uId)
       
        //     ->orderBy('t1.historyId', 'DESC')
        //     ->get();
        
         $data = DB::table('daily_exam_history AS t1')
                    ->select('t1.*', 't2.*', 't3.name', 't4.mNames')
                    ->join('daily_exam AS t2', 't2.dId', '=', 't1.dId')
                    ->join('user_details AS t3', 't3.uId', '=', 't1.uId')
                    ->leftJoin(DB::raw('(SELECT t2.dId, GROUP_CONCAT(t4.mName SEPARATOR ", ") AS mNames
                                            FROM daily_exam AS t2
                                            INNER JOIN module AS t4 ON t2.modulesId LIKE CONCAT("%", t4.mId, "%")
                                            GROUP BY t2.dId) AS t4'), 't2.dId', '=', 't4.dId')
                    ->where('t1.uId', '=', $uId)
                    ->orderByDesc('t1.historyId')
                    ->get();
       

      


        $count = $data->Count();
        if ($count > 0) {
            return response()->json([
                'responseMessage' => 'daily exam history',
                'responseCode' => 200,
                'responseStatus' => true,
                'data' => $data,
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

//show daily exam winners
public function showDailyExamWinners()
{
    $dId = request('dId');
    if ($dId == "") {
        return response()->json([
            'responseMessage' => 'dId is mandatory',
            'responseCode' => 401,
            'responseStatus' => false,
        ]);
    } else {
        $data =DB::table('daily_exam_history as t1')
            ->select('t1.*', 't2.*', 't3.*')
            ->join('daily_exam as t2', 't2.dId', '=', 't1.dId')
            ->join('user_details as t3', 't3.uId', '=', 't1.uId')
            ->where('t1.dId', $dId)
            ->orderBy('t1.totalMark', 'DESC')
            ->limit(10)
            ->get();

        $count = $data->Count();
        if ($count > 0) {
            return response()->json([
                'responseMessage' => 'daily exam history',
                'responseCode' => 200,
                'responseStatus' => true,
                'data' => $data,
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


//show schedule exam for exam bank module show winners list
public function showDailyExamForViewWinners()
{
    try {
        $data = dailyexamModel::whereIn('isExpired', [1, 2])->orderBy('examdate', 'desc')->get();

        return response()->json([
            'responseMessage' => 'all scheduled exam',
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




//daily exam history using uId
public function check_userInScheduleDailyExam(){
    $uId = request('uId');
    $dId = request('dId');
    if ($uId == "") {
        return response()->json([
            'responseMessage' => 'uId is mandatory',
            'responseCode' => 401,
            'responseStatus' => false,
        ]);
    }
    if ($dId == "") {
        return response()->json([
            'responseMessage' => 'dId is mandatory',
            'responseCode' => 401,
            'responseStatus' => false,
        ]);
    } else {

       // print_r($dId);die;
        $data = DB::table('daily_exam_history')
            ->where('uId','=',$uId)
            ->where('dId','=', $dId)
            ->get()
            ->toArray();

        //print($data);die;

        if (empty($data)) {
            return response()->json([
                'responseMessage' => 'Sorry, no data found.',
                'responseCode' => 401,
                'responseStatus' => false,
            ]);
        } else {
            return response()->json([
                'responseMessage' => 'User has already attended this exam.',
                'responseCode' => 200,
                'responseStatus' => true,
            ]);
        }

    }
}



}
