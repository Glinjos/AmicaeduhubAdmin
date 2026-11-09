<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ModelExamMEModels\modelExamMEAnswerModel;
use App\Models\ModelExamMEModels\modelExamMENameModel;
use App\Models\ModelExamMEModels\modelExamMEQuestionModel;

use App\Models\SubscriptionModels\planSubscribersModel;
use App\Models\userdevicetokenModel;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use PhpParser\JsonDecoder;
use function Symfony\Component\HttpKernel\DataCollector\getMessage;

use App\Models\GenaralQuestionModels\ModuleModel;
use App\Models\GenaralQuestionModels\SubModuleModel;
use App\Models\GenaralQuestionModels\QuestionModel;
use App\Models\GenaralQuestionModels\AnswerModel;

use Illuminate\Routing\Controller;


use DB;
use Illuminate\Support\Facades\Crypt;


use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Session;



class QwiseModelExamController extends Controller
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


    // add model exam 
    public function modelexams_Form(){

        $ModelExam=DB::select("SELECT exam.isAvail,exam.meId,exam.meName,exam.meDescription,count( quest.meqId) as no_of_quest 
        FROM model_exam_me as exam
        JOIN model_exam_me_question as quest on quest.meId = exam.meId
        JOIN model_exam_me_answer as ans on ans.meqId = quest.meqId
        WHERE exam.isAvail IN (0,2)
        GROUP by exam.meId,exam.meName,exam.meDescription,exam.isAvail
        ORDER by exam.meId desc;");
        $module=ModuleModel::select('mId','mName')->where('isAvail','=','0')->get();

        return view('model_exam.add_model_exam',compact('module','ModelExam'));
    }
    public function ChapterWisemodelexmmodulecheck(Request $request){

        $mId = request('mId');

        $chapter =SubModuleModel::select('smId','smName')->where('mId',$mId)->get();
        
        return $chapter;

    }

   //return quest
    public function modelexmreturnquest(Request $request)
        {
            try {
                $desiredSmIds = $request->input('smId');
                // $desiredSmIds = SubModuleModel::where('mId', $mId)->pluck('smId')->toArray();

                $allMidQuest1 = [];

               // foreach ($desiredSmIds as $subModule) {
                    $cqIds = DB::table('cooperation_question')->where('smId', $desiredSmIds)->where('isAvail',0)->pluck('cqId')->toArray();

                    if (!empty($cqIds)) {
                        $questions = DB::table('cooperation_question')->select('cqId','question')->whereIn('cqId', $cqIds)->where('isAvail',0)->get()->toArray();
                        $allMidQuest1 = array_merge($allMidQuest1, $questions);
                    }
               // }

                return $allMidQuest1;
                // You can return the collected questions as JSON
                // return response()->json(['questions' => $allMidQuest1]);

            } catch (\Exception $e) {
                // \Log::error($e->getTraceAsString());
                // return response()->json(['error' => 'Server Error'], 500);
            }
        }

    

    //insert
    public function addModel_Exam(Request $request){
        $validatedData = $request->validate([
            'modelexamName' => 'required',
            'modelexamDesc' => 'required',
            'dailyexampostiveMark' => 'required',
            'dailyexamnegativeMark' => 'required',
            

        ], [
            'modelexamName.required' => 'This field is required.',
            'modelexamDesc.required' => 'This field is required.',
            'dailyexampostiveMark.required' => 'This field is required.',
            'dailyexamnegativeMark.required' => 'This field is required.',
           
        ]);

        $examName=request('modelexamName');
        $examDesc=request('modelexamDesc');
        
        $dailyexampostiveMark=request('dailyexampostiveMark');
        $dailyexamnegativeMark=request('dailyexamnegativeMark');
       // print_r($dailyexamnegativeMark);die;
        
        $created_by=request('user_id');
        // $moduleIdString = $request->input('moduleId', []);
        // $moduleId = implode(',', $moduleIdString);

        // $submoduleIdstring = $request->input('submoduleId', []);
        // $submoduleId = implode(',', $submoduleIdstring);

        $cqIdstring = $request->input('questionId', []);
        $cqId = implode(',', $cqIdstring);
       

        $insertExam= new modelExamMENameModel();
        $insertExam->meName  =$examName;
        $insertExam->meDescription  =$examDesc;
        $insertExam->positiveMark  =$dailyexampostiveMark;
        $insertExam->negativeMark  =$dailyexamnegativeMark;
        $insertExam->created_by  =$created_by;
        $insertExam->save();
        $lastInsertedId = $insertExam->meId;

        $getQuestions = QuestionModel::select('cqId', 'question', 'optA', 'optB', 'optC', 'optD')
        ->whereIn('cqId', explode(',', $cqId))
        ->get();

     foreach ($getQuestions as $question) {
        $saveQuest = new modelExamMEQuestionModel();
        $saveQuest->meId      = $lastInsertedId;
        $saveQuest->question  = $question->question;
        $saveQuest->optionA   = $question->optA;
        $saveQuest->optionB   = $question->optB;
        $saveQuest->optionC   = $question->optC;
        $saveQuest->optionD   = $question->optD;
        $saveQuest->created_by = $created_by;
    
        $saveQuest->save();
    
        //  last inserted ID 
        $lastQuestId = $saveQuest->meqId;
    
        // cqId
        $getAnswer = AnswerModel::select('caId', 'cqId', 'optA', 'optB', 'optC', 'optD')
            ->where('cqId', $question->cqId)
            ->first();
    
        if ($getAnswer) {
            $saveAns = new modelExamMEAnswerModel();
    
            $saveAns->meqId      = $lastQuestId;
            $saveAns->optionA    = $getAnswer->optA;
            $saveAns->optionB    = $getAnswer->optB;
            $saveAns->optionC    = $getAnswer->optC;
            $saveAns->optionD    = $getAnswer->optD;
            $saveAns->created_by = $created_by;
    
            $saveAns->save();
        }
    }
    

        return redirect()->back()->with('success','Exam  Added');

    }

    //delete exam
    function modelexamdelete_me($meId)
    {

        $isAvail = 1;
        
        modelExamMENameModel::where('meId',$meId)->update(['isAvail'=>$isAvail]);
        $questions = modelExamMEQuestionModel::where('meId', $meId)->get(['meqId']);
        modelExamMEQuestionModel::where('meId', $meId)->delete();

        modelExamMEAnswerModel::whereIn('meqId', $questions->pluck('meqId'))->delete();
        
        return redirect()->back()->with('success','Exam Deleted');
    }
            
    
    
    
    
    
    
    
    
    
    
    
    // update form for quest
    public function update_ModelExamQuestionForm($cqId, Request $request){

        //$cqId = $request->input('cqId');
       // $encodedMId = $request->input('encodedMId');
       // $decodedMId = urldecode(urldecode($encodedMId));

      
        
        $allQuestions=
            (
            DB::select("SELECT a.* ,
            (SELECT `mId` FROM `sub_module` WHERE `smId`=(a.smId)) as mId,
            (SELECT `mName` FROM `module` WHERE `mId`=(SELECT `mId` FROM `sub_module`WHERE `smId`=(a.smId)))as mName,
            (SELECT `smName` FROM `sub_module` WHERE `smId`=(a.smId))as smName,
            b.`optA` as ansA,b.`optB` as ansB,b.`optC` as ansC,b.`optD` as ansD,a.question_level as level FROM `cooperation_question` as a JOIN `cooperation_answer` as b on a.`cqId`=`b`.`cqId`  where a.`cqId`=$cqId"));
        
        // return view('model_exam.update_MEQ_Form',compact('allQuestions'));
        return $allQuestions;
    }
    
    //update
    public function ModelExamquestionUpdate(Request $request){

        $cqId = request('cqId');
        $qCode = request('qCode');
        
        $mId = request('mId');
        
        $smIdfrominput = request('smId');
        $smIdfromdropdown = request('showsubmoduledropdown');
        // print_r($smIdfrominput."hi".$smIdfromdropdown);die();
        if($smIdfromdropdown==""){
            $smId=$smIdfrominput;//NO DROPDOWN SELECTED
        }else{
            $smId=$smIdfromdropdown;//SUBMODULE CHANGED
            $cqIdq=DB::select("SELECT max(`currentCode`)+1 as currentcode FROM `sub_module` WHERE `smId`=$smId");
            $currentCode=$cqIdq[0]->currentcode;
            DB::update("UPDATE `sub_module` SET `currentCode`='$currentCode' WHERE `smId` =$smId ");
            $qCode=$currentCode;
        }


        $question = request('question');
        $option1 = request('option1');
        $option2 = request('option2');
        $option3 = request('option3');
        $option4 = request('option4');
        $answer = request('answer');
        $question_level = request('question_level');
        
        $updated_by = request('user_id');                 
        /////////////from SESSION VALUE
        $updated_at=$this->currentDateTime;   
        /////////////from date
        $isAvail="0";

        //check the answers

        if($answer=="option1")
        {$value1=1;$value2=0;$value3=0;$value4=0;}
        else if($answer=="option2")
        {$value1=0;$value2=1;$value3=0;$value4=0;}
        else if($answer=="option3")
        {$value1=0;$value2=0;$value3=1;$value4=0;}
        else if($answer=="option4")
        {$value1=0;$value2=0;$value3=0;$value4=1;}

        //UPDATE QUESTIONS TO QUESTION TABLE

        $qmodule = QuestionModel::find($cqId);

        $updateResult =$qmodule->update([
            'smId' =>  $smId,
            'qCode'=>$qCode,  //if have change need to change currentCode
            'question'=>$question,
            'optA'=> $option1,
            'optB'=> $option2,
            'optC'=> $option3,
            'optD'=> $option4,
            'question_level' =>$question_level,
            'isAvail'=>$isAvail,
            'updated_at'=>$updated_at,
            'updated_by'=>$updated_by
        ]);
        //UPDATE ANSWER TO ANSWERS TABLE
        DB::update("UPDATE `cooperation_answer` SET `optA`=$value1,`optB`=$value2,`optC`=$value3,`optD`=$value4,`isAvail`=$isAvail,`updated_by`=$updated_by WHERE `cqId`=$cqId");


        if ($updateResult) {
            return 'success';
        } else {
            return 'failed';
        }

    }
    
    
    
    
    
    
    // enable and disable option functions 
     public function ModelEXAMDisable($meId)
    {
        $isAvail=2;
        $getsessionuId = session()->get('user_id');
        modelExamMENameModel::where('meId',$meId)->update([
            'isAvail'=>$isAvail,
            'updated_by'=>$getsessionuId
        ]);

        modelExamMEQuestionModel::where('meId',$meId)->update(['isAvail'=>$isAvail,'updated_by'=>$getsessionuId]);
        $selectMODELWXAMQUESTId=(DB::select("SELECT `meqId` FROM `model_exam_me_question` WHERE `meId`='$meId'"));
            foreach($selectMODELWXAMQUESTId as $row)
            {
                $meqId = $row->meqId;
                modelExamMEAnswerModel::where('meqId',$meqId)->update(['isAvail'=>$isAvail,'updated_by'=>$getsessionuId]);
            }
       

        return redirect()->back()->with('success','Model Exam Disabled');
    }

    public function ModelEXAMEnable($meId)
    {
        $isAvail=0;
        $getsessionuId = session()->get('user_id');
        modelExamMENameModel::where('meId',$meId)->update(['isAvail'=>$isAvail,'updated_by'=>$getsessionuId]);

        modelExamMEQuestionModel::where('meId',$meId)->update(['isAvail'=>$isAvail,'updated_by'=>$getsessionuId]);
        $selectMODELWXAMQUESTId=(DB::select("SELECT `meqId` FROM `model_exam_me_question` WHERE `meId`='$meId'"));
            foreach($selectMODELWXAMQUESTId as $row)
            {
                $meqId = $row->meqId;
                modelExamMEAnswerModel::where('meqId',$meqId)->update(['isAvail'=>$isAvail,'updated_by'=>$getsessionuId]);
            }
       

        return redirect()->back()->with('success','Model Exam Activated');
    }
    
    
    
    
    // additional model updations----
    // show questions
   
    // additional 26-12
    
    public function addedQuestionsINmOdelExam(Request $request) {
      
        $qIdsString = $request->input('qId');
    
 
        $qIdsArray = explode(',', $qIdsString);
    
        $questions = DB::table('cooperation_question')
            ->select('cqId', 'question')
            ->whereIn('cqId', $qIdsArray)
            //->where('isAvail', 0)
            ->get();
  
        return response()->json(['questions' => $questions]);
    }
    
    
    //insert
    public function ModelExamArrayQuestinonInserting(Request $request){

        $examName=request('ExamName');
        $examDesc=request('ExamDesc');
        
        $dailyexampostiveMark=request('ExamPost');
        $dailyexamnegativeMark=request('ExamNega');
      
        
        $created_by=session()->get('user_id');

        //dd($examName);
      
        $cqIdstring = $request->input('addedQuestions', []);
        $cqId = implode(',', $cqIdstring);
       

        $insertExam= new modelExamMENameModel();
        $insertExam->meName  =$examName;
        $insertExam->meDescription  =$examDesc;
        $insertExam->positiveMark  =$dailyexampostiveMark;
        $insertExam->negativeMark  =$dailyexamnegativeMark;
        $insertExam->created_by  =$created_by;
        $insertExam->save();
        $lastInsertedId = $insertExam->meId;

        $getQuestions = QuestionModel::select('cqId', 'question', 'optA', 'optB', 'optC', 'optD')
        ->whereIn('cqId', explode(',', $cqId))
        ->get();

     foreach ($getQuestions as $question) {
        $saveQuest = new modelExamMEQuestionModel();
        $saveQuest->meId      = $lastInsertedId;
        $saveQuest->question  = $question->question;
        $saveQuest->optionA   = $question->optA;
        $saveQuest->optionB   = $question->optB;
        $saveQuest->optionC   = $question->optC;
        $saveQuest->optionD   = $question->optD;
        $saveQuest->created_by = $created_by;
    
        $saveQuest->save();
    
        //  last inserted ID 
        $lastQuestId = $saveQuest->meqId;
    
        // cqId
        $getAnswer = AnswerModel::select('caId', 'cqId', 'optA', 'optB', 'optC', 'optD')
            ->where('cqId', $question->cqId)
            ->first();
    
        if ($getAnswer) {
            $saveAns = new modelExamMEAnswerModel();
    
            $saveAns->meqId      = $lastQuestId;
            $saveAns->optionA    = $getAnswer->optA;
            $saveAns->optionB    = $getAnswer->optB;
            $saveAns->optionC    = $getAnswer->optC;
            $saveAns->optionD    = $getAnswer->optD;
            $saveAns->created_by = $created_by;
    
            $saveAns->save();
        }
    }
    

    if ($getAnswer) {
        return 'success';
    } else {
        return 'failed';
    }


    }
    
    
    
    
    
    
    
    
     // percentage wise model exam
    public function addpercentagewisemodelexams_Form(Request $request){

        $getPercModelexam=modelExamMENameModel::select('meId','meName','meDescription','noOfQuestions','positiveMark','negativeMark','isAvail')
        ->where('isAvail',0)
        ->whereNotNull('noOfQuestions')
        ->orderby('meId','desc')
        ->get();


        $module=ModuleModel::select('mId','mName')->where('isAvail','=','0')->get();
        return view('percentage_Modelexam.add_model_percentageExam',compact('module','getPercModelexam'));
    }

    public function percentagewisemodelexamexmmodulecheck(Request $request){

        $mId = request('mId');

        $chapter =SubModuleModel::select('smId','smName')->where('mId',$mId)->get();
        
        return $chapter;

    }
    

    function addpercentModel_Exam(Request $request)
    {
        $validatedData = $request->validate([
            'percentModelexamName' => 'required',
            'modelexamDesc' => 'required',
            
            'percModelexamQuest' => 'required',
            'percModelexampostiveMark' => 'required',
            'percModelexamnegativeMark' => 'required',

        ], [
            'percentModelexamName.required' => 'This field is required.',
            'modelexamDesc.required' => 'This field is required.',
           
            'percModelexamQuest.required' => 'This field is required.',
            'percModelexampostiveMark.required' => 'This field is required.',
            'percModelexamnegativeMark.required' => 'This field is required.',
        ]);

        $dailyexamName=request('percentModelexamName');
       
        $modelexamDesc=request('modelexamDesc');
       
        $moduleIdString = $request->input('moduleId', []);
        $moduleId = implode(',', $moduleIdString);

        // EXTRA ADDED CODE HERE
       
        $percentstring = $request->input('percent', []);
        $percentstring = array_filter($percentstring);
        $percentages = implode(',', $percentstring);
      
        $TotalQuestion=request('percModelexamQuest');

      
       // print_r($percentageUseTakequestCounts);die;

        $dailyexampostiveMark=request('percModelexampostiveMark');
        $dailyexamnegativeMark=request('percModelexamnegativeMark');

        $created_by = request('user_id');


      

//INSERT QUESTIONS TO QUESTION TABLE

$exam = modelExamMENameModel::create([
            'meName'=>$dailyexamName,
            'meDescription'=>$modelexamDesc,
            'noOfQuestions'=>$TotalQuestion,
            'positiveMark'=>$dailyexampostiveMark,
            'negativeMark'=>$dailyexamnegativeMark,
            'created_by'=>$created_by,
            //'updated_by'=>"0"

        ]);

        $meId = $exam->meId;
       // print_r($meId);die;
       
       $percentageArray = explode(',', $percentages);
       $percentageSum = array_sum($percentageArray);
       
       if ($percentageSum != 100) {
           $defaultPercentage = 100 / count($percentageArray);
           $percentages = implode(',', array_fill(0, count($percentageArray), $defaultPercentage));
       }
       
       $percentageUseTakequestCounts = [];
       foreach ($percentageArray as $percentage) {
           $percentageUseTakequestCounts[] = round(($percentage / 100) * $TotalQuestion);
       }
       
       // Create a comma-separated list of counts
       $countsString = implode(',', $percentageUseTakequestCounts);
       
       $submoduleIdstring = $request->input('submoduleId', []);
       $submoduleId = implode(',', $submoduleIdstring);






       
       foreach ($submoduleIdstring as $index => $submoduleIdz) {
        
        $questionsForSubmodule = $percentageUseTakequestCounts[$index]; 
        
       // print_r("submoduleIdz => " . $submoduleIdz . ",");
       // print_r("questionsForSubmodule => " . $questionsForSubmodule . ",");
        
        $sqlQueries[] = "
            (SELECT t1.*, t2.*, t3.*, t4.*,
                t1.`optA` AS ansA, t1.`optB` AS ansB, t1.`optC` AS ansC, t1.`optD` AS ansD
            FROM `cooperation_question` t4
            INNER JOIN `cooperation_answer` t1 ON t1.cqId = t4.cqId
            INNER JOIN `sub_module` t3 ON t3.smId = t4.smId
            INNER JOIN `module` t2 ON t2.mId = t3.mId
            WHERE t3.smId = $submoduleIdz
            AND t4.isAvail = 0
            AND t1.isAvail = 0
            ORDER BY RAND() LIMIT $questionsForSubmodule)
        ";
    }
    
       
        //die;
        $sql = implode(" UNION ALL ", $sqlQueries);

        $temp = DB::select($sql);
       // dd($temp);

       
       
       

   
   
        
        foreach ($temp as $question) {
           // print_r($question->question);die;
            $tempexam = modelExamMEQuestionModel::create([
                'meId' => $meId,
                'question' => $question->question,
                'optionA' => $question->optA,
                'optionB' => $question->optB,
                'optionC' => $question->optC,
                'optionD' => $question->optD,
                'created_by' => $created_by,
                //'updated_by' => $updated_by
            ]);
        //}


     $meqId = $tempexam->meqId;

    modelExamMEAnswerModel::create([
            'meqId'=>$meqId,
            'optionA'=>$question->ansA,
            'optionB'=>$question->ansB,
            'optionC'=>$question->ansC,
            'optionD'=>$question->ansD,
            'created_by'=>$created_by,
            //'updated_by'=>$updated_by
        ]);
    }
      
       return redirect()->back()->with('success',' Model Exam  Added');
      
    }
    
    
    
    #delete
    public function deletethePercentModel_exam(Request $request, $meId){
        $isAvail = 1;
        
        modelExamMENameModel::where('meId',$meId)->update(['isAvail'=>$isAvail]);

        $modelExamQuestions = modelExamMEQuestionModel::where('meId', $meId)->get();
        $meqIddelete=modelExamMEQuestionModel::where('meId',$meId)->delete();
       
        foreach ($modelExamQuestions as $question) {
           
            modelExamMEAnswerModel::where('meqId', $question->meqId)->delete();
        }
        return redirect()->back()->with('success','Model Exam Deleted');
    }

    
  
    
    
    
    
    // GET PERCENTAGE ADDED SUBMODULE QUESTIONS PREVIEW-----------------
    
    function getSubmoduleIdandPercentagematchQuestion(Request $request){

        $submoduleId = request('submoduleId');
        $questionsForSubmodule = request('percent');
        
        $results = DB::table('cooperation_question as t4')
            ->select('t4.cqId', 't4.question', 't4.smId', 't1.optA as ansA', 't1.optB as ansB', 't1.optC as ansC', 't1.optD as ansD')
            ->distinct()
            ->join('cooperation_answer as t1', 't1.cqId', '=', 't4.cqId')
            ->join('sub_module as t3', 't3.smId', '=', 't4.smId')
            ->join('module as t2', 't2.mId', '=', 't3.mId')
            ->where('t3.smId', $submoduleId)
            ->where('t4.isAvail', 0)
            ->where('t1.isAvail', 0)
            ->inRandomOrder()
            ->limit($questionsForSubmodule)
            ->get();
        
        return $results;

    }
    
    //END PREVIEW
    
    
    public function savepercentage_wisemodelexam(Request $request){

        $examName=request('examname');
        $examDesc=request('decription');
        $numberQ=request('numberQ');
        $exampostiveMark=request('positive');
        $examnegativeMark=request('negative'); 
        $created_by=session()->get('user_id');

        $insertExam= new modelExamMENameModel();
        $insertExam->meName  =$examName;
        $insertExam->meDescription  =$examDesc;
        $insertExam->noOfQuestions  =$numberQ;
        $insertExam->positiveMark  =$exampostiveMark;
        $insertExam->negativeMark  =$examnegativeMark;
        $insertExam->created_by  =$created_by;
        $insertExam->save();
        $lastInsertedId = $insertExam->meId;
        //next function work

       
        $cqIdArrays = $request->input('cqIdArrays', []); 
        $cqIdstring = array_column($cqIdArrays, 'cqId'); 
       // dd($cqIdstring);
        $cqId = implode(',', $cqIdstring);
        

        $getQuestions = QuestionModel::select('cqId', 'question', 'optA', 'optB', 'optC', 'optD')
        ->whereIn('cqId', explode(',', $cqId))
        ->get();

        foreach ($getQuestions as $question) {
            $saveQuest = new modelExamMEQuestionModel();
            $saveQuest->meId      = $lastInsertedId;
            $saveQuest->question  = $question->question;
            $saveQuest->optionA   = $question->optA;
            $saveQuest->optionB   = $question->optB;
            $saveQuest->optionC   = $question->optC;
            $saveQuest->optionD   = $question->optD;
            $saveQuest->created_by = $created_by;
            $saveQuest->save();
            //  last inserted ID 
            $lastQuestId = $saveQuest->meqId;
            // cqId
            $getAnswer = AnswerModel::select('caId', 'cqId', 'optA', 'optB', 'optC', 'optD')
                ->where('cqId', $question->cqId)
                ->first();
        
            if ($getAnswer) {
                $saveAns = new modelExamMEAnswerModel();
                $saveAns->meqId      = $lastQuestId;
                $saveAns->optionA    = $getAnswer->optA;
                $saveAns->optionB    = $getAnswer->optB;
                $saveAns->optionC    = $getAnswer->optC;
                $saveAns->optionD    = $getAnswer->optD;
                $saveAns->created_by = $created_by;
                $saveAns->save();
            }
        }
    

        if ($getAnswer) {
            return 'success';
        } else {
            return 'failed';
        }


    }
    
    
    
    
    
    
    
    
    
    

    
    
    
    
    
    



}
