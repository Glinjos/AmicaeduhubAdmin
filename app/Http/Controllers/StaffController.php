<?php

/**
 * Created by vsCode.
 * Use: Staff Controlling PQ,VC
 * Questions Adding 
 */

namespace App\Http\Controllers;

use App\Models\GenaralQuestionModels\ModuleModel;
use App\Models\GenaralQuestionModels\SubModuleModel;
use App\Models\GenaralQuestionModels\QuestionModel;
use App\Models\GenaralQuestionModels\AnswerModel;
use App\Models\User;

use App\Models\PreviousQuestionModels\egoryviewegoryModel;
use App\Models\PreviousQuestionModels\PQAnswerModel;
use App\Models\PreviousQuestionModels\PQuestionModel;
use App\Models\PreviousQuestionModels\SubCategoryModel;
use App\Models\PreviousQuestionModels\CategoryModel;

use App\Models\VideoClassesModels\vcmoduleModel;
use App\Models\VideoClassesModels\vcchapterModel;
use App\Models\VideoClassesModels\vcexamModel;
use App\Models\VideoClassesModels\vcansModel;
use App\Models\VideoClassesModels\vcmoreVideoModel;

use App\Models\pqmainModel;
use Illuminate\Routing\Controller;

use Illuminate\Http\Request;

use DB;


use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Session;


class StaffController extends Controller
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



    public function index()
    {
       
        return view('staffs.dashboard');
       
    }

    function addPQA()
    {

        $select3 =pqmainModel::select('pqmainId','pqmainName')->where('isAvail','=','0')->get();
       // $categoryView = CategoryModel::select()->orderBy('isAvail', 'ASC')->where('isAvail','0')->get();
        $categoryView = CategoryModel::select()->orderBy('isAvail', 'ASC')->get();
       
        return view('staffs/PQ_add_form',compact('categoryView','select3'));
    }

    function pqModuleCheckformain()
    {

        $pqmainid=request()->get('pqmainId');
       // $pq_submodule_view = CategoryModel::select()->where('pqmainId',$pqmainid)->where('isAvail','0')->get();
        $pq_submodule_view = CategoryModel::select()->where('pqmainId',$pqmainid)->orderBy('pqmName', 'ASC')->get();
        return $pq_submodule_view;
    }

    function pqSubModuleCheck()
    {

        $pqmid=request()->get('pqmid');
       // $pq_submodule_view = SubCategoryModel::select()->where('pqmId',$pqmid)->where('isAvail','0')->get();
        $pq_submodule_view = SubCategoryModel::select()->where('pqmId',$pqmid)->orderBy('pqsmName', 'ASC')->get();
        return $pq_submodule_view;
    }

    public function postPreQues(Request $Request)
    {

        $validatedData = $Request->validate([
            'question' => 'required',
            'option1' => 'required',
            'option2' => 'required',
            'option3' => 'required',
            'option4' => 'required',

        ], [
            'question.required' => 'Spell Something!',
            'option1.required' => 'Spell Something!',
            'option2.required' => 'Spell Something!',
            'option3.required' => 'Spell Something!',
            'option4.required' => 'Spell Something!',
        ]);

        $pqmainid= request('examtype');

        $pqmid= request('module');
       
        $pqsmid = request('smodule');
        // print_r($pqsmid);die();

        $question = request('question');
        $option1 = request('option1');
        $option2 = request('option2');
        $option3 = request('option3');
        $option4 = request('option4');
        $answer = request('answer');

        $created_by = request('user_id');
        $updated_by = "0";
        $isAvail = "2";

//check the answers

        if($answer=="option1")
        {
            $value1=1;
            $value2=0;
            $value3=0;
            $value4=0;
        }
        else if($answer=="option2")
        {
            $value1=0;
            $value2=1;
            $value3=0;
            $value4=0;
        }
        else if($answer=="option3")
        {
            $value1=0;
            $value2=0;
            $value3=1;
            $value4=0;
        }
        else if($answer=="option4")
        {
            $value1=0;
            $value2=0;
            $value3=0;
            $value4=1;
        }

//INSERT QUESTIONS TO QUESTION TABLE

        PQuestionModel::create([
            'pqsmId'=>$pqsmid,//pqsmid
            'question'=>$question,
            'optionA'=>$option1,
            'optionB'=>$option2,
            'optionC'=>$option3,
            'optionD'=>$option4,
            'isAvail'=>$isAvail,
            'created_by'=>$created_by,
            'updated_by'=>$updated_by

        ]);

        $pqId=PQuestionModel::get()->max('pqId');

//INSERT ANSWER TO PQANSWERS TABLE
        PQAnswerModel::create([
            'pqId'=>$pqId,
            'optionA'=>$value1,
            'optionB'=>$value2,
            'optionC'=>$value3,
            'optionD'=>$value4,
            'isAvail'=>$isAvail,
            'created_by'=>$created_by,
            'updated_by'=>$updated_by
        ]);

//update CURRENT CODE AND UPDATED BY INTO PQSUBMODULE

        DB::update("UPDATE `pq_submodule` SET`updated_by`= $updated_by where `pqsmId`=$pqsmid");

       // return redirect()->back()->with('success','Question Added');
        return redirect()->back()->with([
            'success' => 'Question Added',
            'pqmainid' =>$pqmainid,
            'pqmid' => $pqmid,
            'pqsmid' =>$pqsmid
        ]); 
    }




    public function showPQA(Request $request)
    {
        $user_id = $request->session()->get('user_id');
        $module_view=CategoryModel::select()->get();

        $question=DB::select("SELECT  a.pqId AS questionId, a.pqsmId AS subModuleId,a.question,
        a.optionA as optionA,
        a.optionB as optionB,
        a.optionC as optionC,
        a.optionD as optionD,
        b.optionA as a,
        b.optionB as b,
        b.optionC as c,
        b.optionD as d, 
    f.pqmainName as PmainName,f.pqmainId AS PmainId,
    c.pqsmName as PsubModuleName, c.pqsmId AS PsubModuleId,
    d.pqmName as PmoduleName,d.pqmId as PmoduleId    
        FROM `p_questions`as a 
         
        JOIN `pq_submodule` as c
        ON c.pqsmId=a.pqsmId
        
        JOIN `pq_module` as d
        ON c.pqmId=d.pqmId
        
        JOIN `pq_main` as f
        
         ON f.pqmainId=d.pqmainId 
        
        JOIN  `p_answers`as b  
        ON a.`pqId`=b.`pqId`
         WHERE a.`isAvail`=2
            AND b.`isAvail`=2 
            AND d.`isAvail` IN (0,1)
            AND c.`isAvail` IN (0,1)
            AND f.`isAvail`=0
            AND a.created_by = '$user_id'
            ORDER BY b.pqId DESC;");
        return view('staffs/PQAshow',compact('module_view','question'));
    }

    function PquestionTake()
    {
        $pqId=request()->get('pqId');
        $allQuestions=
            // (DB::select("SELECT a.* , (SELECT `pqmId` FROM `pq_submodule` WHERE `pqsmId`=(a.pqsmId)) as pqmId,
            //  (SELECT `pqmName` FROM `pq_module` WHERE `pqmId`=(SELECT `pqmId` FROM `pq_submodule`WHERE `pqsmId`=(a.pqsmId)))as pqmName, 
            //  (SELECT `pqsmName` FROM `pq_submodule` WHERE `pqsmId`=(a.pqsmId))as pqsmName,
            //   b.`optionA` as ansA,b.`optionB` as ansB,b.`optionC` as ansC,b.`optionD` as ansD FROM `p_questions` 
            //   as a JOIN `p_answers` as b on a.`pqId`=`b`.`pqId` where a.`pqId`=$pqId;"));
              (DB::select("SELECT t1.*, t2.*, t3.*, t4.*, b.`optionA` as ansA, b.`optionB` as ansB, b.`optionC` as ansC, b.`optionD` as ansD
              FROM `p_questions` t4
              INNER JOIN `pq_submodule` t3 ON t4.pqsmId = t3.pqsmId
              INNER JOIN `pq_module` t2 ON t3.pqmId = t2.pqmId
              INNER JOIN `pq_main` t1 ON t2.pqmainId = t1.pqmainId
              INNER JOIN `p_answers` b ON t4.`pqId` = b.`pqId`
              WHERE t4.`pqId` =$pqId;"));
        return $allQuestions;
    }

    function PmoduleShow(){
        $pqmodule= DB::select("SELECT * from `pq_module`");
        return $pqmodule;
    }
    public function deletePQuestion($questionId)
    {
        PQuestionModel::where('pqId',$questionId)->delete();
        PQAnswerModel::where('pqId',$questionId)->delete();
        return redirect("/staffshowPQA")->with('success','Question Deleted');
    }


    public function PquestionUpdate(Request $request)
    {
        $pqId = request('pqId');

        $smIdfrominput = request('pqsmId');
        $smIdfromdropdown = request('showsubmoduledropdown');
        if($smIdfromdropdown==""){
            $pqsmId=$smIdfrominput;//NO DROPDOWN SELECTED
        }else{
            $pqsmId=$smIdfromdropdown;//SUBCATEGORY CHANGED
        }

        $question = request('question');
        $option1 = request('option1');
        $option2 = request('option2');
        $option3 = request('option3');
        $option4 = request('option4');
        $answer = request('answer');

        $updated_by = request('user_id');                  /////////////from SESSION VALUE
        $updated_at= $this->currentDateTime; 
        $isAvail="2";
          /////////////from date

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

        $pqmodule = PQuestionModel::find($pqId);
        //print_r($pqId);die;

        $pqmodule->update([
            'pqsmId' =>  $pqsmId,
            'question'=>$question,
            'optionA'=> $option1,
            'optionB'=> $option2,
            'optionC'=> $option3,
            'optionD'=> $option4,
            'isAvail'=> $isAvail,
            'updated_at'=>$updated_at,
            'updated_by'=>$updated_by]);
        //UPDATE ANSWER TO ANSWERS TABLE
        DB::update("UPDATE `p_answers` SET `optionA`=$value1,`optionB`=$value2,`optionC`=$value3,`optionD`=$value4,`isAvail`=$isAvail,`updated_by`=$updated_by WHERE `pqId`=$pqId");

        return redirect("/staffshowPQA")->with('success','Question Updated');
    }
   
    function Categoryshow(){
        $pqmainId=request()->get('pqmainId');
       // $category=  CategoryModel::select()->where('pqmainId',$pqmainId)->where('isAvail','0')->get();
        $category=  CategoryModel::select()->where('pqmainId',$pqmainId)->get();
        return $category;
    }

    function subCategoryshow()
    {
        $pqmId=request()->get('pqmId');
       // $subcategory = SubCategoryModel::select()->where('pqmId',$pqmId)->where('isAvail','0')->get();
        $subcategory = SubCategoryModel::select()->where('pqmId',$pqmId)->get();
        return $subcategory;
    }
    function ExamTypeshow(){
        $category= DB::select("SELECT * from `pq_main` WHERE `isAvail`='0'");
        return $category;
    }
    function updatePreviousQuestionForm()
    {
        $pqId=request('pqId');
        // $allQuestions=(DB::select("SELECT a.* , (SELECT `pqmId` FROM `pq_submodule` WHERE `pqsmId`=(a.pqsmId)) as pqmId,
        //  (SELECT `pqmName` FROM `pq_module` WHERE `pqmId`=(SELECT `pqmId` FROM `pq_submodule`WHERE `pqsmId`=(a.pqsmId)))as pqmName,
        //   (SELECT `pqsmName` FROM `pq_submodule` WHERE `pqsmId`=(a.pqsmId))as pqsmName, b.`optionA` as ansA,b.`optionB` as ansB,b.`optionC` as ansC,b.`optionD` as ansD FROM `p_questions`
        //    as a JOIN `p_answers`
        //  as b on a.`pqId`=`b`.`pqId` where a.`pqId`=$pqId;"));
         $allQuestions=(DB::select("SELECT t1.*, t2.*, t3.*, t4.*, b.`optionA` as ansA, b.`optionB` as ansB, b.`optionC` as ansC, b.`optionD` as ansD
         FROM `p_questions` t4
         INNER JOIN `pq_submodule` t3 ON t4.pqsmId = t3.pqsmId
         INNER JOIN `pq_module` t2 ON t3.pqmId = t2.pqmId
         INNER JOIN `pq_main` t1 ON t2.pqmainId = t1.pqmainId
         INNER JOIN `p_answers` b ON t4.`pqId` = b.`pqId`
         WHERE t4.`pqId` =$pqId;"));
        return view('staffs/edit_pq_question',compact('allQuestions'));
    }



    ///////////// VIDEO CLASS STAFFS WORKS ----------------CONTROLLER--------------------------------
    //-----------------------------------------------------------------------------------------------
    //-----------------------------------------------------------------------------------------------
    //-----------------------------------------------------------------------------------------------

    function vcStaffAddExamForm()
    {

       // $select3 =pqmainModel::select('pqmainId','pqmainName')->where('isAvail','=','0')->get();
       // $categoryView = vcmoduleModel::select()->orderBy('isAvail', 'ASC')->where('isAvail','0')->get();
        $categoryView = vcmoduleModel::select()->orderBy('isAvail', 'ASC')->get();
       
        return view('staffs/add_vcExamQ',compact('categoryView'));
    }

    // function vcModuleCheckformaindtaa()
    // {

    //     $pqmainid=request()->get('pqmainId');
    //     $pq_submodule_view = vcmoduleModel::select()->where('pqmainId',$pqmainid)->where('isAvail','0')->get();
    //     return $pq_submodule_view;
    // }

    function vcStaffChaptersCheck()
    {

        $vcmid=request()->get('vcmid');
       // $pq_submodule_view = vcchapterModel::select()->where('vcmId',$vcmid)->where('isAvail','0')->get();
        $pq_submodule_view = vcchapterModel::select()->where('vcmId',$vcmid)->get();
        return $pq_submodule_view;
    }
    function videomoreStaffCheck()
    {

        $vcChapterId=request()->get('vcChapterId');
      //  $vc_morevideo_view = vcmoreVideoModel::select()->where('vcChapterId',$vcChapterId)->where('isPublished','0')->get();
        $vc_morevideo_view = vcmoreVideoModel::select()->where('vcChapterId',$vcChapterId)->get();
        return $vc_morevideo_view;
    }

    public function postvdeoClsQuesStaff(Request $Request)
    {

        $validatedData = $Request->validate([
            'question' => 'required',
            'option1' => 'required',
            'option2' => 'required',
            'option3' => 'required',
            'option4' => 'required',

        ], [
            'question.required' => 'Spell Something!',
            'option1.required' => 'Spell Something!',
            'option2.required' => 'Spell Something!',
            'option3.required' => 'Spell Something!',
            'option4.required' => 'Spell Something!',
        ]);

       // $pqmainid= request('examtype');

        $vcmid= request('subject');
       
        $vcChapterId = request('chapter');
        $videoId = request('video');
        //print_r($videoId);die;
        // print_r($pqsmid);die();

        $question = request('question');
        $option1 = request('option1');
        $option2 = request('option2');
        $option3 = request('option3');
        $option4 = request('option4');
        $answer = request('answer');

        $isAvail = "2";

        $created_by = request('user_id');
        $updated_by = "0";

//check the answers

        if($answer=="option1")
        {
            $value1=1;
            $value2=0;
            $value3=0;
            $value4=0;
        }
        else if($answer=="option2")
        {
            $value1=0;
            $value2=1;
            $value3=0;
            $value4=0;
        }
        else if($answer=="option3")
        {
            $value1=0;
            $value2=0;
            $value3=1;
            $value4=0;
        }
        else if($answer=="option4")
        {
            $value1=0;
            $value2=0;
            $value3=0;
            $value4=1;
        }

//INSERT QUESTIONS TO QUESTION TABLE
  //print_r($videoId);die;
        vcexamModel::create([
            'vcVDId'=>$videoId,
            'question'=>$question,
            'optionA'=>$option1,
            'optionB'=>$option2,
            'optionC'=>$option3,
            'optionD'=>$option4,
            'isAvail'=>$isAvail,
            'created_by'=>$created_by,
            'updated_by'=>$updated_by

        ]);

        $vcExamId=vcexamModel::get()->max('vcExamId');

//INSERT ANSWER TO VCANSWERS TABLE
        vcansModel::create([
            'vcExamId'=>$vcExamId,
            'optionA'=>$value1,
            'optionB'=>$value2,
            'optionC'=>$value3,
            'optionD'=>$value4,
            'isAvail'=>$isAvail,
            'created_by'=>$created_by,
            'updated_by'=>$updated_by
        ]);

//update CURRENT CODE AND UPDATED BY INTO VCCHAPTER

        DB::update("UPDATE `vc_chapters` SET`updated_by`= $updated_by where `vcChapterId`=$vcChapterId");

       // return redirect()->back()->with('success','Question Added');
        return redirect()->back()->with([
            'success' => 'Question Added',
            'vcVDId' =>$videoId,
            'vcmid' => $vcmid,
            'vcChapterId' =>$vcChapterId
        ]); 
    }


    //--------------------------------------------------------------------------------------------------------
   //--------------------------------------------------------------------------------------------------------
  //--------------------------------------------------------------------------------------------------------


    /// SHOW THE ADDED QUESTIONS AND ANSWERSS
    public function showstaffVCQA(Request $request)
    {
        $user_id = $request->session()->get('user_id');
        $module_view=vcmoduleModel::select()->get();

        $question=DB::select("SELECT DISTINCT
        a.vcExamId AS questionId,
        a.vcVDId AS moreVideochapterId,
        a.question,
        a.optionA AS optionA,
        a.optionB AS optionB,
        a.optionC AS optionC,
        a.optionD AS optionD,
        b.optionA AS optionA_b,
        b.optionB AS optionB_b,
        b.optionC AS optionC_b,
        b.optionD AS optionD_b,
        c.vcChapterName AS chapterName,
        c.vcChapterId AS vcChapterId,
        d.vcmName AS vcModuleName,
        d.vcmId AS vcModuleId,
        e.videoHeading AS videoHeading,
        e.vcVDId AS vcVDId
    FROM
        `vc_exams` AS a
        JOIN `vc_exam_ans` AS b ON b.vcExamId = a.vcExamId
        JOIN `vc_more_videos` AS e ON e.vcVDId = a.vcVDId
        JOIN `vc_chapters` AS c ON c.vcChapterId = e.vcChapterId
        JOIN `vc_module` AS d ON d.vcmId = c.vcmId
    WHERE
            a.isAvail = 2
        AND b.isAvail = 2
        AND c.isAvail IN (0,1)
        AND d.isAvail IN (0,1)
        AND e.isPublished IN (0,1)
        AND a.created_by = '$user_id'
    ORDER BY
        a.vcExamId DESC;");
        return view('staffs/show_vcExamQ',compact('module_view','question'));
    }

    function vCstaffquestionTake()
    {
        $vcExamId=request()->get('vcExamId');
        $allQuestions=
            // (DB::select("SELECT a.* , (SELECT `pqmId` FROM `pq_submodule` WHERE `pqsmId`=(a.pqsmId)) as pqmId,
            //  (SELECT `pqmName` FROM `pq_module` WHERE `pqmId`=(SELECT `pqmId` FROM `pq_submodule`WHERE `pqsmId`=(a.pqsmId)))as pqmName, 
            //  (SELECT `pqsmName` FROM `pq_submodule` WHERE `pqsmId`=(a.pqsmId))as pqsmName,
            //   b.`optionA` as ansA,b.`optionB` as ansB,b.`optionC` as ansC,b.`optionD` as ansD FROM `p_questions` 
            //   as a JOIN `p_answers` as b on a.`pqId`=`b`.`pqId` where a.`pqId`=$pqId;"));
              (DB::select("SELECT t1.*,t2.*, t3.*, t4.*, b.`optionA` as ansA, b.`optionB` as ansB, b.`optionC` as ansC, b.`optionD` as ansD
              FROM `vc_exams` t4
              
              INNER JOIN `vc_more_videos` t1 ON t4.vcVDId = t1.vcVDId
              INNER JOIN `vc_chapters` t3 ON t1.vcChapterId = t3.vcChapterId
              INNER JOIN `vc_module` t2 ON t3.vcmId = t2.vcmId
             
              INNER JOIN `vc_exam_ans` b ON t4.`vcExamId` = b.`vcExamId`
              WHERE t4.`vcExamId` =$vcExamId;"));
        return $allQuestions;
    }

   
    public function deletestaffVCQuestion($questionId)
    {
        $question=vcexamModel::where('vcExamId',$questionId);
        $question->update(['isAvail' => 1]);
        $answer=vcansModel::where('vcExamId',$questionId);
        $answer->update(['isAvail' => 1]);
        return redirect("/vcstaffshowexam")->with('success','Question Deleted');
    
    }

       

//     //---------------------------------Update Exam Start Here--------------------------------------
//      //------------------------------------------------------------------------------------------------------
//       //------------------------------------------------------------------------------------------------------

    function subjectstaffshow(){
   // $category= DB::select("SELECT * from `vc_module` where `isAvail`=0");
    $category= DB::select("SELECT * from `vc_module` ");
    return $category;
    }

    function chapterstaffshow()
    {
        $vcmId=request()->get('vcmId');
       // $subcategory = vcchapterModel::select()->where('vcmId',$vcmId)->where('isAvail','0')->get();
        $subcategory = vcchapterModel::select()->where('vcmId',$vcmId)->get();
        return $subcategory;
    }
    function morevideostaffcheck()
    {
        $vcChapterId=request()->get('vcChapterId');
       // $morevideo = vcmoreVideoModel::select()->where('vcChapterId',$vcChapterId)->where('isPublished','0')->get();
        $morevideo = vcmoreVideoModel::select()->where('vcChapterId',$vcChapterId)->get();
        return $morevideo;
    }


    function updatestaffVideoClassForm()
    {
        $questionId=request('questionId');
        //print_r($questionId);die;
       
       $allVcQuestions = DB::select("SELECT t1.*,t2.*, t3.*, t4.*, b.`optionA` as ansA, b.`optionB` as ansB,
        b.`optionC` as ansC, b.`optionD` as ansD
       FROM `vc_exams` t4
       
       INNER JOIN `vc_more_videos` t1 ON t4.vcVDId = t1.vcVDId
       INNER JOIN `vc_chapters` t3 ON t1.vcChapterId = t3.vcChapterId
       INNER JOIN `vc_module` t2 ON t3.vcmId = t2.vcmId
      
       INNER JOIN `vc_exam_ans` b ON t4.`vcExamId` = b.`vcExamId`
       WHERE t4.`vcExamId` = $questionId");
   
   
   return view('staffs/edit_vcExam_question', compact('allVcQuestions'));
   
    }


    public function VcstaffquestionUpdate(Request $request)
    {
        $vcExamId = request('vcExamId');

        $vcVDIdfrominput = request('vcVDId');
        $vcVDIdfromdropdown = request('showsubmoduledropdown');
        if($vcVDIdfromdropdown==""){
            $vcVDId=$vcVDIdfrominput;//NO DROPDOWN SELECTED
        }else{
            $vcVDId=$vcVDIdfromdropdown;//SUBCATEGORY CHANGED
        }

        $question = request('question');
        $option1 = request('option1');
        $option2 = request('option2');
        $option3 = request('option3');
        $option4 = request('option4');
        $answer = request('answer');

        $updated_by = request('user_id');                  /////////////from SESSION VALUE
        $updated_at= $this->currentDateTime;   /////////////from date
        $isAvail="2";

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

        $vcexam = vcexamModel::find($vcExamId);
        //print_r($pqId);die;

        $vcexam->update([
            'vcVDId' =>  $vcVDId,
            'question'=>$question,
            'optionA'=> $option1,
            'optionB'=> $option2,
            'optionC'=> $option3,
            'optionD'=> $option4,
            'isAvail'=>$isAvail,
            'updated_at'=>$updated_at,
            'updated_by'=>$updated_by]);
        //UPDATE ANSWER TO ANSWERS TABLE
        DB::update("UPDATE `vc_exam_ans` SET `optionA`=$value1,`optionB`=$value2,`optionC`=$value3,`optionD`=$value4,`isAvail`=$isAvail,`updated_by`=$updated_by WHERE `vcExamId`=$vcExamId");

        return redirect("/vcstaffshowexam")->with('success','Question Updated');
    }
   
//     //------------------------------------------------------------------------------------------------------
//      //------------------------------------------------------------------------------------------------------
//       //------------------------------------------------------------------------------------------------------

     ///////////// VIDEO CLASS STAFFS WORKS -------END---------CONTROLLER--------------------------------
    //-----------------------------------------------------------------------------------------------
    //-----------------------------------------------------------------------------------------------
    //-----------------------------------------------------------------------------------------------




    // MAIN EXAM---------------------

//////////////////question based functionalities starts here////////////////////

function viewQuestionAddingForm()
{
   // $isAvail='0';
   // $module_view = ModuleModel::select()->where('isAvail',$isAvail)->get();
    $module_view = ModuleModel::select()->orderBy('mName', 'ASC')->get();
    return view('staffs/question_add_form', compact('module_view'));
}

function subModuleStaffsCheck()
{
   // $isAvail='0';
    $mid=request()->get('mid');
   // $submodule_view = SubModuleModel::select()->where('mId',$mid)->where('isAvail',$isAvail)->get();
    $submodule_view = SubModuleModel::select()->where('mId',$mid)->orderBy('smName', 'ASC')->get();
    //print_($submodule_view);
    return $submodule_view;
    //return view('question_add_form', compact('submodule_view'));
}
public function poststaffQues(Request $Request)
{

    $validatedData = $Request->validate([
        'question' => 'required',
        'option1' => 'required',
        'option2' => 'required',
        'option3' => 'required',
        'option4' => 'required',

    ], [
        'question.required' => 'Spell Something!',
        'option1.required' => 'Spell Something!',
        'option2.required' => 'Spell Something!',
        'option3.required' => 'Spell Something!',
        'option4.required' => 'Spell Something!',
    ]);

    $mid= request('module');
   
    $smid = request('smodule');
    
    $question = request('question');
    $option1 = request('option1');
    $option2 = request('option2');
    $option3 = request('option3');
    $option4 = request('option4');
    $answer = request('answer');
    $question_level = request('question_level');

   // $user_id = request('user_id');
    
    $created_by =  request('user_id');
    $updated_by = "0";
    $isAvail ="2";

//check the answers

    if($answer=="option1")
    {
        $value1=1;
        $value2=0;
        $value3=0;
        $value4=0;
    }
    else if($answer=="option2")
    {
        $value1=0;
        $value2=1;
        $value3=0;
        $value4=0;
    }
    else if($answer=="option3")
    {
        $value1=0;
        $value2=0;
        $value3=1;
        $value4=0;
    }
    else if($answer=="option4")
    {
        $value1=0;
        $value2=0;
        $value3=0;
        $value4=1;
    }


//SELECT currentCode & increment from QCODE

    $qCode=(DB::select("SELECT `currentCode` from `sub_module` where `smId`=$smid")[0]->currentCode)+1;


//INSERT QUESTIONS TO QUESTION TABLE

    QuestionModel::create([
        'smId'=>$smid,      //smid
        'qCode'=>$qCode,      //qCode
        'question'=>$question,
        'optA'=>$option1,
        'optB'=>$option2,
        'optC'=>$option3,
        'optD'=>$option4,
        'question_level'=>$question_level,
        'isAvail'=>$isAvail,
        'created_by'=>$created_by,
        'updated_by'=>$updated_by

    ]);

//CHECK cqId and inserrt into answerrs

    $cqid =DB::select("SELECT max(`cqId`)as cqId FROM `cooperation_question` where  `qCode`=$qCode");
    $cqId=$cqid[0]->cqId;

//INSERT ANSWER TO ANSWERS TABLE
    AnswerModel::create([
        'cqId'=>$cqId,
        'optA'=>$value1,
        'optB'=>$value2,
        'optC'=>$value3,
        'optD'=>$value4,
        'isAvail'=>$isAvail,
        'created_by'=>$created_by,
        'updated_by'=>$updated_by
    ]);

//update CURRENT CODE AND UPDATED BY INTO SUBMODULE

    DB::update("UPDATE `sub_module` SET `currentCode` = $qCode ,`updated_by`= $updated_by where `smId`=$smid");

    
    return redirect()->back()->with([
        'success' => 'Question Added',
        'mid' => $mid,
        'smid' =>$smid
    ]); 
    
}


//show quest
public function showstaffQuestions(Request $request)
{
    $user_id = $request->session()->get('user_id');
    $module_view=ModuleModel::select()->get();

    $question=DB::select("SELECT 
                            a.cqId AS questionId,
                            a.smId AS subModuleId,
                            a.question,
                            a.qcode as questionCode,
                            a.optA as optionA,
                            a.optB as optionB,
                            a.optC as optionC,
                            a.optD as optionD,
                            b.optA as a,
                            b.optB as b,
                            b.optC as c,
                            b.optD as d,
                            c.smName as subModuleName,
                            c.smCode as subModuleCode,
                            c.smId AS subModuleId,
                            d.mName as moduleName,
                            d.mCode as moduleCode,
                            d.mId as moduleId
                            FROM `cooperation_question`as a 
                            JOIN `sub_module` as c
                            ON c.smId=a.smId
                            JOIN `module` as d
                            ON c.mId=d.mId
                            JOIN  `cooperation_answer`as b  
                            ON a.`cqId`=b.`cqId`
                            WHERE a.`isAvail`=2 
                            AND b.`isAvail`=2
                            AND d.`isAvail` IN (0,1)
                            AND c.`isAvail` IN (0,1)
                            AND a.created_by = '$user_id'; ");
    return view('staffs/questionShow',compact('module_view','question'));
}






public function questionstaffmainexmUpdate(Request $Request )
{
    $cqId = request('cqId');
    $qCode = request('qCode');
    

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
     //print_r("qid".$cqId."qcode".$qCode.$smId.$question.$option1.$option2.$option3.$option4.$answer);die();

    $updated_by = request('user_id');                  /////////////from SESSION VALUE
    $updated_at=$this->currentDateTime;   /////////////from date
    $isAvail="2";

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

    $qmodule->update([
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


    return redirect("/showstaffmainexamQA")->with('success','Question Updated');

}
public function deletestaffmainexamQuestion($questionId)
{
    DB::update("UPDATE `cooperation_question` SET `isAvail`='1' WHERE `cqId`=$questionId");

    DB::update("UPDATE `cooperation_answer` SET `isAvail`='1' WHERE `cqId`= $questionId");

    return redirect("/showstaffmainexamQA")->with('success','Question Deleted');
}

function subModulestaffupdateCheck()
{
   // $isAvail='0';
    $mid=request()->get('mid');
   // $submodule_view = SubModuleModel::select()->where('mId',$mid)->where('isAvail',$isAvail)->get();
    $submodule_view = SubModuleModel::select()->where('mId',$mid)->get();
    //print_($submodule_view);
    return $submodule_view;
    //return view('question_add_form', compact('submodule_view'));
}


//main exam question take
function questionstaffmaineexmTake()
{
    $cqId=request()->get('cqId');
    $allQuestions=
        (
        DB::select("SELECT a.* ,
      (SELECT `mId` FROM `sub_module` WHERE `smId`=(a.smId)) as mId,
     (SELECT `mName` FROM `module` WHERE `mId`=(SELECT `mId` FROM `sub_module`WHERE `smId`=(a.smId)))as mName,
     (SELECT `smName` FROM `sub_module` WHERE `smId`=(a.smId))as smName,
      b.`optA` as ansA,b.`optB` as ansB,b.`optC` as ansC,b.`optD` as ansD FROM `cooperation_question` as a JOIN `cooperation_answer` as b on a.`cqId`=`b`.`cqId`  where a.`cqId`=$cqId"));
    return $allQuestions;
}


function Modulestaffmainexmshow(){
   // $module= DB::select("SELECT * from `module` where `isAvail`=0");
    $module= DB::select("SELECT * from `module`");
    return $module;
}


function updatestaffmainexmQuestionForm(){
    //take value curresponding to questionid
    $cqId=request('cqId');
    
    $allQuestions=
        (
        DB::select("SELECT a.* ,
        (SELECT `mId` FROM `sub_module` WHERE `smId`=(a.smId)) as mId,
        (SELECT `mName` FROM `module` WHERE `mId`=(SELECT `mId` FROM `sub_module`WHERE `smId`=(a.smId)))as mName,
        (SELECT `smName` FROM `sub_module` WHERE `smId`=(a.smId))as smName,
        b.`optA` as ansA,b.`optB` as ansB,b.`optC` as ansC,b.`optD` as ansD,a.question_level as level FROM `cooperation_question` as a JOIN `cooperation_answer` as b on a.`cqId`=`b`.`cqId`  where a.`cqId`=$cqId"));
    
 
        return view('staffs/editQuestion',compact('allQuestions'));
    }












     //NANNANAN
    // USERS ENTERED QUESTION COUNT SHOWING AREA--START HERE----

    public function show_user_entered_quest(){

        return view('employee.show_useraddedquestcount');
    }

    public function report_useraddedquest_monthwise(Request $request){
        
        $fromdate = request('from_search');
        $todate = request('to_search');
        
        $fulldatematchdata=DB::select("SELECT
                ud.name,
                (
                    SELECT COUNT(cq.cqId)
                    FROM `cooperation_question` cq
                    WHERE cq.created_by = ud.id
                        AND DATE(cq.created_at) BETWEEN '$fromdate' AND '$todate'
                        AND cq.isAvail IN (0, 2)
                ) AS cq_count,
        COALESCE(
         CASE 
            WHEN ud.userType NOT IN (0, 2) THEN 'non-author'
            ELSE 
                  (
                    SELECT COUNT(cq.cqId)
                    FROM `cooperation_question` cq
                    WHERE (cq.created_by = ud.id OR cq.updated_by = ud.id)
                        AND DATE(cq.updated_at) BETWEEN '$fromdate' AND '$todate'
                        AND ud.userType IN (0, 2)
                )END, 0) AS mexam_approved,
                (
                    SELECT COUNT(pq.pqId)
                    FROM `p_questions` pq
                    WHERE pq.created_by = ud.id
                        AND DATE(pq.created_at) BETWEEN '$fromdate' AND '$todate'
                        AND pq.isAvail IN (0, 2)
                ) AS pq_count,
        COALESCE(
         CASE 
            WHEN ud.userType NOT IN (0, 2) THEN 'non-author'
            ELSE
                    (
                    SELECT COUNT(pq.pqId)
                    FROM `p_questions` pq
                    WHERE (pq.created_by = ud.id OR pq.updated_by = ud.id)
                        AND DATE(pq.updated_at) BETWEEN '$fromdate' AND '$todate'
                        AND ud.userType IN (0, 2)
                )END, 0) AS pq_approved,
                (
                    SELECT COUNT(vcq.vcExamId)
                    FROM `vc_exams` vcq
                    WHERE vcq.created_by = ud.id
                        AND DATE(vcq.created_at) BETWEEN '$fromdate' AND '$todate'
                        AND vcq.isAvail IN (0, 2)
                ) AS vcq_count,
        COALESCE(
         CASE 
            WHEN ud.userType NOT IN (0, 2) THEN 'non-author'
            ELSE
                   (
                    SELECT COUNT(vcq.vcExamId)
                    FROM `vc_exams` vcq
                    WHERE (vcq.created_by = ud.id OR vcq.updated_by = ud.id)
                        AND DATE(vcq.updated_at) BETWEEN '$fromdate' AND '$todate'
                        AND vcq.isAvail IN (0, 2)
                )END, 0) AS vcq_approved
            FROM `users` AS ud
            WHERE NOT ud.id IN (3, 9, 12, 35, 2, 5)
            ORDER BY ud.name ASC");

        // $fulldatematchdata=DB::select("SELECT ud.name,
        // (SELECT COUNT(cq.cqId) FROM `cooperation_question` cq 
        //  WHERE cq.created_by = ud.id 
        //   AND DATE(cq.created_at) BETWEEN '$fromdate' AND '$todate' 
        //   AND cq.isAvail IN (0, 2)) AS cq_count,
        // (SELECT COUNT(pq.pqId) FROM `p_questions` pq 
        //  WHERE pq.created_by = ud.id 
        //   AND DATE(pq.created_at) BETWEEN '$fromdate' AND '$todate' 
        //   AND pq.isAvail IN (0, 2)) AS pq_count,
        // (SELECT COUNT(vcq.vcExamId) FROM `vc_exams` vcq 
        //  WHERE vcq.created_by = ud.id 
        //   AND DATE(vcq.created_at) BETWEEN '$fromdate' AND '$todate' 
        //   AND vcq.isAvail IN (0, 2)) AS vcq_count
        // FROM `users` AS ud
        // WHERE NOT ud.id IN (3,9,12,35,2,5)
        // ORDER BY ud.name ASC;");

        return $fulldatematchdata;
    }













}
