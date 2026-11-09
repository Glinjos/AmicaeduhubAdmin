<?php

/**
 * Created by vsCode.
 * Use: Model Exam
 * model exam cred operation
 */

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use App\Models\ExamDailyModels\dailyexamModel;
use App\Models\ExamDailyModels\tempAnsDailyExmModel;
use App\Models\ExamDailyModels\tempQuestDailyExmModel;
use App\Models\ExamDailyModels\dailyExamHistoryModel;
use App\Models\ExamDailyModels\dailyExamChapterModel;

use App\Models\SubscriptionModels\planSubscribersModel;
use App\Models\userdevicetokenModel;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use PhpParser\JsonDecoder;
use function Symfony\Component\HttpKernel\DataCollector\getMessage;

use App\Models\GenaralQuestionModels\ModuleModel;
use App\Models\GenaralQuestionModels\SubModuleModel;
use Illuminate\Routing\Controller;


use DB;
use Illuminate\Support\Facades\Crypt;


use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Session;

class ModelExmController extends Controller
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

  /// ADD DAILY EXAM FORM  ----------
    function dailyExamAdding()
    {

        $dailyExam=DB::select("SELECT t2.modulesId, GROUP_CONCAT(t1.mName SEPARATOR ',') AS moduleNames, t2.*
        FROM (
          SELECT *
          FROM `daily_exam`
        ) AS t2
        INNER JOIN `module` AS t1 ON FIND_IN_SET(t1.mId, t2.modulesId)
        WHERE FIND_IN_SET(t1.mId, t2.modulesId) > 0
       AND t2.isExpired =0
        
        GROUP BY t2.modulesId, t2.dId, t2.examName, t2.examdate, t2.timeFrom, t2.timeTo,
         t2.noOfQuestions, t2.postiveMark, t2.negativeMark
         
         
          
         ORDER BY
         t2.dId DESC; ");
        $module=ModuleModel::select('mId','mName')->where('isAvail','=','0')->get();
       // print_r($module);die;
        return view('daily_exam.addmodelexam',compact('module','dailyExam'));
      
    }

    // INSERTING THE BLADE DATA----
    function InsertDailyExamblade(Request $request)
    {
        $validatedData = $request->validate([
            'dailyexamName' => 'required',
            'dailyexamDate' => 'required',
            'dailyexamTimeFrom' => 'required',
            'dailyexamTimeTo' => 'required',
            'dailyexamQuest' => 'required',
            'dailyexampostiveMark' => 'required',
            'dailyexamnegativeMark' => 'required',

        ], [
            'dailyexamName.required' => 'This field is required.',
            'dailyexamDate.required' => 'This field is required.',
            'dailyexamTimeFrom.required' => 'This field is required.',
            'dailyexamTimeTo.required' => 'This field is required.',
            'dailyexamQuest.required' => 'This field is required.',
            'dailyexampostiveMark.required' => 'This field is required.',
            'dailyexamnegativeMark.required' => 'This field is required.',
        ]);

        $dailyexamName=request('dailyexamName');
        $dailyexamDate=request('dailyexamDate');
        $dailyexamTimeFrom=request('dailyexamTimeFrom');
        $dailyexamTimeTo=request('dailyexamTimeTo');
       
        $moduleIdString = $request->input('moduleId', []);
        $moduleId = implode(',', $moduleIdString);

        $dailyexamQuest=request('dailyexamQuest');
        $dailyexampostiveMark=request('dailyexampostiveMark');
        $dailyexamnegativeMark=request('dailyexamnegativeMark');

        $created_by = request('user_id');


       

//INSERT QUESTIONS TO QUESTION TABLE

$exam = dailyexamModel::create([
            'examName'=>$dailyexamName,//pqsmid
            'examdate'=>$dailyexamDate,
            'timeFrom'=>$dailyexamTimeFrom,
            'timeTo'=>$dailyexamTimeTo,
            'modulesId'=>$moduleId,
            'noOfQuestions'=>$dailyexamQuest,
            'postiveMark'=>$dailyexampostiveMark,
            'negativeMark'=>$dailyexamnegativeMark,
            'created_by'=>$created_by,
            //'updated_by'=>"0"

        ]);

        $dId = $exam->dId;
       // print_r($dId);die;
    //$dId=dailyexamModel::get()->max('dId');

    $temp = DB::select("
    SELECT t1.*, t2.*, t3.*, t4.*,t1.`optA` AS ansA, t1.`optB` AS ansB, t1.`optC` AS ansC, t1.`optD` AS ansD
    FROM `cooperation_question` t4
    INNER JOIN `cooperation_answer` t1 ON t1.cqId = t4.cqId
    INNER JOIN `sub_module` t3 ON t3.smId = t4.smId
    INNER JOIN `module` t2 ON t2.mId = t3.mId
    WHERE t2.mId IN ($moduleId)
    AND t4.isAvail =0
    AND t1.isAvail =0
    ORDER BY RAND()
    LIMIT $dailyexamQuest;
    
        ");

        foreach ($temp as $question) {
           // print_r($question->question);die;
            $tempexam = tempQuestDailyExmModel::create([
                'dId' => $dId,
                'question' => $question->question,
                'optionA' => $question->optA,
                'optionB' => $question->optB,
                'optionC' => $question->optC,
                'optionD' => $question->optD,
                'created_by' => $created_by,
                //'updated_by' => $updated_by
            ]);
        //}


     $tdqId = $tempexam->tdqId;
//    // print_r($tdqId);die;
//    // $tdqId=tempQuestDailyExmModel::get()->max('tdqId');

//     foreach ($temp as $answer) {
        tempAnsDailyExmModel::create([
            'tdqId'=>$tdqId,
            'optionA'=>$question->ansA,
            'optionB'=>$question->ansB,
            'optionC'=>$question->ansC,
            'optionD'=>$question->ansD,
            'created_by'=>$created_by,
            //'updated_by'=>$updated_by
        ]);
    }
    
    
    
    
    
    // NOTIFICATION START
    
//     $subscribers = planSubscribersModel::select('uId')
//     ->where('isExpired', 0)
//     ->orderBy('created_at', 'desc')
//     ->get();

//     $subscribers_id = []; 

//     foreach ($subscribers as $subscriber) {
//          $subscribers_id[] =$subscriber->uId;
//     }


//     $deviceTokendata = userdevicetokenModel::select('deviceToken')->whereIn('uId',$subscribers_id)->get();
//   // print_r($deviceTokendata);die;
//     $deviceTokendataCount = count($deviceTokendata);
//     $deviceTokenList = [];

//     for($i = 0; $i< $deviceTokendataCount;$i++){
//         array_push($deviceTokenList, $deviceTokendata[$i]["deviceToken"]);
//     }
    
//     $tokenString = json_encode($deviceTokenList);

//   // print_r($deviceTokendata);die;
//     try {

       
//           //  http://admin.amicaeduhub.com/api/send-notification
//           // http://localhost/LARAVEL/AMICA HUB/admin.amicaeduhub.com/api/send-notification
//             $client = new Client();
//             $url = 'http://admin.amicaeduhub.com/api/send-notification';
//           // print_r($tokenString);die;
//             $form_params = [
//                 'title' => $request['dailyexamName'],
//                 'body' =>  "Date Of Exam " . $dailyexamDate . " Starts At " . $dailyexamTimeFrom . " And Ends At  " . $dailyexamTimeTo,
//                 'tokens'=> $tokenString,
//                 ];

//         $response = $client->post($url, ['form_params' => $form_params]);
//         // if($response)
//         // {
          
//         //  return redirect()->with('success','Notification Sent.');
        
//         // }
//         // else
//         // {
//         //     return redirect()->with('error','Execution Failed.');
//         // }
//     }
//     catch(GuzzleException $g) {
//         echo $g;
//     }

    // END NOTIFICATION

      
       return redirect()->back()->with('success','Exam  Added');
      
    }



    // delete the daily exam and also delete the temp quest and ans table-----------

    function deleteDailyExam($dId)
    {

        $isExpired = 3;
        
        dailyexamModel::where('dId',$dId)->update(['isExpired'=>$isExpired]);
        $tdqId=tempQuestDailyExmModel::select('tdqId','dId')->where('dId',$dId)->delete();
        tempAnsDailyExmModel::where('tdqId',$tdqId)->delete();
        return redirect("/dailyexamform")->with('success','Exam Deleted');
    }


    ///  expired and enable

    function expireddailyexam($dId)
    {
        $isExpired=2;
        $expired = dailyexamModel::where('dId',$dId)->update(['isExpired'=>$isExpired]);
 
        return redirect()->back()->with('success','Exam Expired');

    }
    function activedailyexam($dId)
    {
        $isExpired=0;
        $expired = dailyexamModel::where('dId',$dId)->update(['isExpired'=>$isExpired]);
 
        return redirect()->back()->with('success','Exam Activated');

    }
    
    
     /// showing daily exam winners------------------------------
    function dailyexmwinnersform()
    {

        // $winners=DB::select("SELECT
        //                             deh.dId,
        //                             de.dId,
        //                             de.examName,
        //                             de.examdate,
        //                             ud.uId,
        //                             ud.name,
        //                             deh.*,
        //                             deh.totalMark AS mark
        //                             FROM
        //                             daily_exam_history deh
        //                             INNER JOIN
        //                             daily_exam de ON deh.dId = de.dId
        //                             INNER JOIN
        //                             user_details ud ON deh.uId = ud.uId
        //                             INNER JOIN
        //                             (
        //                                 SELECT
        //                                     dId,
        //                                     MAX(totalMark) AS maxMark
        //                                 FROM
        //                                     daily_exam_history
        //                                 GROUP BY
        //                                     dId
        //                             ) maxMarks ON deh.dId = maxMarks.dId AND deh.totalMark = maxMarks.maxMark
        //                         ORDER BY
        //                         deh.dId, mark DESC;");
        
        
        // $winners=DB::select("SELECT
        //                             deh.dId,
        //                             de.dId,
        //                             de.examName,
        //                             de.examdate,
        //                             ud.uId,
        //                             ud.name,
        //                             deh.*,
        //                             deh.totalMark AS mark
        //                             FROM
        //                             daily_exam_history deh
        //                             INNER JOIN
        //                             daily_exam de ON deh.dId = de.dId
        //                             INNER JOIN
        //                             user_details ud ON deh.uId = ud.uId
        //                             INNER JOIN
        //                             (
        //                                 SELECT
        //                                     dId,
        //                                     MAX(totalMark) AS maxMark
        //                                 FROM
        //                                     daily_exam_history
        //                                 GROUP BY
        //                                     dId
        //                             ) maxMarks ON deh.dId = maxMarks.dId AND deh.totalMark = maxMarks.maxMark
        //                             WHERE de.isExpired = 2
        //                         ORDER BY
        //                         de.examdate DESC;");
        $winners=DB::select("SELECT 
    dId,
    examName,
    examDate,
    uId,
    name,
    mark,
    created_at
FROM (
    SELECT 
        de.dId,
        de.examName,
        de.examdate,
        ud.uId,
        ud.name,
        deh.totalMark AS mark,
        deh.created_at,
        IF(@prevDId = de.dId, @row_number := @row_number + 1, @row_number := 1) AS rnk,
        @prevDId := de.dId
    FROM 
        (SELECT @row_number := 0, @prevDId := NULL) AS init
    CROSS JOIN 
        daily_exam_history deh
    LEFT JOIN 
        daily_exam de ON deh.dId = de.dId
    LEFT JOIN 
        user_details ud ON deh.uId = ud.uId
    WHERE 
        de.isExpired = 2
    ORDER BY 
        de.dId, deh.totalMark DESC, deh.created_at ASC
) AS rankedResults
WHERE 
    rnk = 1
ORDER BY 
    examDate DESC;");
                                
                                

        return view('daily_exam.dailyexam_winners',compact('winners'));
    }

    // top ten winners sorting --------
    function toptenwinnerssort()
    {
        $dId=request('dId');
        //print_r($examdate);die;
        $topten=DB::select("
        SELECT t1.*, t2.*, t3.*
        FROM `daily_exam_history` AS t1
        INNER JOIN `daily_exam` AS t2 ON t2.dId = t1.dId
        INNER JOIN `user_details` AS t3 ON t3.uId = t1.uId
        WHERE t2.dId = '$dId'
        ORDER BY t1.totalMark DESC
        LIMIT 10;
        ");

        return $topten;
    }
    
    
    
    
    
    
    
    
     // DAILY EXAM CHAPTER WISE STARTED HERE-- AND
   // use App\Models\GenaralQuestionModels\SubModuleModel;
   // USING ONE SUMBODULE MODEL

    public function addchapterwisedailyexam(){

        $dailyExam=DB::select("SELECT t2.modulesId, GROUP_CONCAT(t1.mName SEPARATOR ',') AS moduleNames, t2.*
        FROM (
          SELECT *
          FROM `daily_exam`
        ) AS t2
        INNER JOIN `module` AS t1 ON FIND_IN_SET(t1.mId, t2.modulesId)
        WHERE FIND_IN_SET(t1.mId, t2.modulesId) > 0
       AND t2.isExpired =0
        
        GROUP BY t2.modulesId, t2.dId, t2.examName, t2.examdate, t2.timeFrom, t2.timeTo,
         t2.noOfQuestions, t2.postiveMark, t2.negativeMark
         
         
          
         ORDER BY
         t2.dId DESC; ");
        $module=ModuleModel::select('mId','mName')->where('isAvail','=','0')->get();

        return view('daily_exam.addchapterwiseExm',compact('module','dailyExam'));
    }

    public function ChapterWiseDailyexmmodulecheck(Request $request){

        $mId = request('mId');

        $chapter =SubModuleModel::select('smId','smName')->where('mId',$mId)->get();
        
        return $chapter;

    }

    // INSERTING THE BLADE DATA----
    function addDailyChapterExam(Request $request)
    {
        $validatedData = $request->validate([
            'dailyexamName' => 'required',
            'dailyexamDate' => 'required',
            'dailyexamTimeFrom' => 'required',
            'dailyexamTimeTo' => 'required',
            'dailyexamQuest' => 'required',
            'dailyexampostiveMark' => 'required',
            'dailyexamnegativeMark' => 'required',

        ], [
            'dailyexamName.required' => 'This field is required.',
            'dailyexamDate.required' => 'This field is required.',
            'dailyexamTimeFrom.required' => 'This field is required.',
            'dailyexamTimeTo.required' => 'This field is required.',
            'dailyexamQuest.required' => 'This field is required.',
            'dailyexampostiveMark.required' => 'This field is required.',
            'dailyexamnegativeMark.required' => 'This field is required.',
        ]);

        $dailyexamName=request('dailyexamName');
        $dailyexamDate=request('dailyexamDate');
        $dailyexamTimeFrom=request('dailyexamTimeFrom');
        $dailyexamTimeTo=request('dailyexamTimeTo');
       
        $moduleIdString = $request->input('moduleId', []);
        $moduleId = implode(',', $moduleIdString);

        // EXTRA ADDED CODE HERE
        $submoduleIdstring = $request->input('submoduleId', []);
        $submoduleId = implode(',', $submoduleIdstring);
        //end
       // print_r($submoduleId);die;

        $dailyexamQuest=request('dailyexamQuest');
        $dailyexampostiveMark=request('dailyexampostiveMark');
        $dailyexamnegativeMark=request('dailyexamnegativeMark');

        $created_by = request('user_id');


       

//INSERT QUESTIONS TO QUESTION TABLE

$exam = dailyexamModel::create([
            'examName'=>$dailyexamName,//pqsmid
            'examdate'=>$dailyexamDate,
            'timeFrom'=>$dailyexamTimeFrom,
            'timeTo'=>$dailyexamTimeTo,
            'modulesId'=>$moduleId,
            'noOfQuestions'=>$dailyexamQuest,
            'postiveMark'=>$dailyexampostiveMark,
            'negativeMark'=>$dailyexamnegativeMark,
            'created_by'=>$created_by,
            //'updated_by'=>"0"

        ]);

        $dId = $exam->dId;
       // print_r($dId);die;
       
        // insert chapter table
        $chapter___exam = dailyExamChapterModel::create([
            'dId'=>$dId,//examid
            'examName'=>$dailyexamName,
            'examdate'=>$dailyexamDate,
            'modulesId'=>$moduleId,
            'chapterId'=>$submoduleId,
        
        ]);
        
    //$dId=dailyexamModel::get()->max('dId');

    $temp = DB::select("
    SELECT t1.*, t2.*, t3.*, t4.*,t1.`optA` AS ansA, t1.`optB` AS ansB, t1.`optC` AS ansC, t1.`optD` AS ansD
    FROM `cooperation_question` t4
    INNER JOIN `cooperation_answer` t1 ON t1.cqId = t4.cqId
    INNER JOIN `sub_module` t3 ON t3.smId = t4.smId
    INNER JOIN `module` t2 ON t2.mId = t3.mId
    WHERE t3.smId IN ($submoduleId)
    AND t4.isAvail =0
    AND t1.isAvail =0
    ORDER BY RAND()
    LIMIT $dailyexamQuest;
    
        ");

        foreach ($temp as $question) {
           // print_r($question->question);die;
            $tempexam = tempQuestDailyExmModel::create([
                'dId' => $dId,
                'question' => $question->question,
                'optionA' => $question->optA,
                'optionB' => $question->optB,
                'optionC' => $question->optC,
                'optionD' => $question->optD,
                'created_by' => $created_by,
                //'updated_by' => $updated_by
            ]);
        //}


     $tdqId = $tempexam->tdqId;
//    // print_r($tdqId);die;
//    // $tdqId=tempQuestDailyExmModel::get()->max('tdqId');

//     foreach ($temp as $answer) {
        tempAnsDailyExmModel::create([
            'tdqId'=>$tdqId,
            'optionA'=>$question->ansA,
            'optionB'=>$question->ansB,
            'optionC'=>$question->ansC,
            'optionD'=>$question->ansD,
            'created_by'=>$created_by,
            //'updated_by'=>$updated_by
        ]);
    }
      
       return redirect()->back()->with('success','Exam  Added');
      
    }

    function deletechapterwisetheexam($dId)
    {

        $isExpired = 2;
        
        dailyexamModel::where('dId',$dId)->update(['isExpired'=>$isExpired]);
        $tdqId=tempQuestDailyExmModel::select('tdqId','dId')->where('dId',$dId)->delete();
        tempAnsDailyExmModel::where('tdqId',$tdqId)->delete();
        return redirect("/add_chapter_wise_daily-exam")->with('success','Exam Deleted');
    }
    
    
    // ENDING CHAPTER WISE EXAM 
    
    
    
     // daily exam added question show
    public function view_exam_questions(Request $request){

        $dId= request('dId');

        $getExamName_and_Date = dailyexamModel::where('dId', $dId)->first();

        $getModuleIdFIRST = dailyexamModel::where('dId', $dId)->value('modulesId');
        $moduleIdsArray = explode(',', $getModuleIdFIRST);

        $getModelName = ModuleModel::select('mName')
        ->whereIn('mId',$moduleIdsArray)
        ->get();

        
        $getQuestions=DB::select("SELECT a.tdqId AS questionId,a.question,
        a.optionA as optionA, a.optionB as optionB,a.optionC as optionC,a.optionD as optionD,
        b.optionA as a,b.optionB as b,b.optionC as c,b.optionD as d
        FROM `temp_dailyexam_quest`as a 
        JOIN `temp_dailyexam_ans` as b ON a.tdqId=b.tdqId
        JOIN `daily_exam` as c ON c.dId=a.dId
        WHERE a.dId = $dId;");

        return view('daily_exam.show_added_dailyEXmQuest', compact('getExamName_and_Date', 'getModelName','getQuestions'));

    }
    //end showing the questions
    
    //question take
    public function DailyEXAMquestionTake(Request $request){
        $tdqId=request()->get('tdqId');
        $allQuestions=DB::select("SELECT a.question,a.optionA as optA,a.optionB as optB,a.optionC as optC,a.optionD as optD,
            b.`optionA` as ansA,b.`optionB` as ansB,b.`optionC` as ansC,b.`optionD` as ansD
            FROM `temp_dailyexam_quest` as a
            JOIN `temp_dailyexam_ans` as b on a.tdqId=b.tdqId 
            where a.tdqId = $tdqId;");
        return $allQuestions;
    }
    //end daily exam question show
    
    
    
    
    
    
    
    
    
    
}
