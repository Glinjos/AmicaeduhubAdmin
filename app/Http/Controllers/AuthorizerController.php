<?php

/**
 * Created by vsCode.
 * Use: Author Controlling PQ,VC
 * Questions Adding and approving 
 */
namespace App\Http\Controllers;


use App\Models\GenaralQuestionModels\ModuleModel;
use App\Models\GenaralQuestionModels\SubModuleModel;
use App\Models\GenaralQuestionModels\QuestionModel;
use App\Models\GenaralQuestionModels\AnswerModel;

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

use DB;

use Illuminate\Support\Facades\Crypt;

use App\Models\pqmainModel;

use Illuminate\Http\Request;

class AuthorizerController extends Controller
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
       
        return view('authorizer.dashboard');
       
    }

    function addauthorPQA()
    {

        $select3 =pqmainModel::select('pqmainId','pqmainName')->where('isAvail','=','0')->get();
      //  $categoryView = CategoryModel::select()->orderBy('isAvail', 'ASC')->where('isAvail','0')->get();
        $categoryView = CategoryModel::select()->orderBy('isAvail', 'ASC')->get();
       
        return view('authorizer/PQ_add_form',compact('categoryView','select3'));
    }

    function pqModuleCheckformain()
    {

        $pqmainid=request()->get('pqmainId');
      //  $pq_submodule_view = CategoryModel::select()->where('pqmainId',$pqmainid)->where('isAvail','0')->get();
        $pq_submodule_view = CategoryModel::select()->where('pqmainId',$pqmainid)->orderBy('pqmName', 'ASC')->get();
        return $pq_submodule_view;
    }

    function pqSubModuleCheck()
    {

        $pqmid=request()->get('pqmid');
      //  $pq_submodule_view = SubCategoryModel::select()->where('pqmId',$pqmid)->where('isAvail','0')->get();
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




    public function showPQAauthor()
    {
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
         WHERE a.`isAvail`=0
            AND b.`isAvail`=0 
            AND d.`isAvail`=0
            AND c.`isAvail`=0
            AND f.`isAvail`=0
            ORDER BY b.pqId DESC;");
        return view('authorizer/PQAshow',compact('module_view','question'));
    }

    function PquestionTakeauthor()
    {
        $pqId=request()->get('pqId');
        $allQuestions=
           
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
    public function deletePQuestionauthor($questionId)
    {
        PQuestionModel::where('pqId',$questionId)->delete();
        PQAnswerModel::where('pqId',$questionId)->delete();
        return redirect("/authorshowPQA")->with('success','Question Deleted');
    }


    public function PquestionUpdateauthor(Request $request)
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

        return redirect("/authorshowPQA")->with('success','Question Updated');
    }
   
    function Categoryshowauthor(){
        $pqmainId=request()->get('pqmainId');
       // $category=  CategoryModel::select()->where('pqmainId',$pqmainId)->where('isAvail','0')->get();
        $category=  CategoryModel::select()->where('pqmainId',$pqmainId)->get();
        return $category;
    }

    function authorsubCategoryshow()
    {
        $pqmId=request()->get('pqmId');
       // $subcategory = SubCategoryModel::select()->where('pqmId',$pqmId)->where('isAvail','0')->get();
        $subcategory = SubCategoryModel::select()->where('pqmId',$pqmId)->get();
        return $subcategory;
    }
    function ExamTypeshowauthor(){
        $category= DB::select("SELECT * from `pq_main` WHERE `isAvail`='0'");
        return $category;
    }
    function updatePreviousQuestionForm()
    {
        $pqId=request('pqId');
        
         $allQuestions=(DB::select("SELECT t1.*, t2.*, t3.*, t4.*, b.`optionA` as ansA, b.`optionB` as ansB, b.`optionC` as ansC, b.`optionD` as ansD
         FROM `p_questions` t4
         INNER JOIN `pq_submodule` t3 ON t4.pqsmId = t3.pqsmId
         INNER JOIN `pq_module` t2 ON t3.pqmId = t2.pqmId
         INNER JOIN `pq_main` t1 ON t2.pqmainId = t1.pqmainId
         INNER JOIN `p_answers` b ON t4.`pqId` = b.`pqId`
         WHERE t4.`pqId` =$pqId;"));
        return view('authorizer/edit_pq_question',compact('allQuestions'));
    }




    /// APPROVING WORKERS ADDED QUESTIONS ------------------------------- DRAFT QUESTIONS RUD


    public function authorsShowQ()
    {
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
    d.pqmName as PmoduleName,d.pqmId as PmoduleId,
    a.isAvail as isAvail,b.isAvail as isAvail    
        FROM `p_questions`as a 
         
        JOIN `pq_submodule` as c
        ON c.pqsmId=a.pqsmId
        
        JOIN `pq_module` as d
        ON c.pqmId=d.pqmId
        
        JOIN `pq_main` as f
        
         ON f.pqmainId=d.pqmainId 
        
        JOIN  `p_answers`as b  
        ON a.`pqId`=b.`pqId`
         WHERE a.`isAvail` =2
            AND b.`isAvail` =2
            AND d.`isAvail` IN (0,1)
            AND c.`isAvail` IN (0,1)
            AND f.`isAvail`=0
            ORDER BY b.pqId DESC;");
        return view('authorizer/draftPQshow',compact('module_view','question'));
    }

    function draftPquestionTakeauthor()
    {
        $pqId=request()->get('pqId');
        $allQuestions=
           
              (DB::select("SELECT t1.*, t2.*, t3.*, t4.*, b.`optionA` as ansA, b.`optionB` as ansB, b.`optionC` as ansC, b.`optionD` as ansD
              FROM `p_questions` t4
              INNER JOIN `pq_submodule` t3 ON t4.pqsmId = t3.pqsmId
              INNER JOIN `pq_module` t2 ON t3.pqmId = t2.pqmId
              INNER JOIN `pq_main` t1 ON t2.pqmainId = t1.pqmainId
              INNER JOIN `p_answers` b ON t4.`pqId` = b.`pqId`
              WHERE t4.`pqId` =$pqId;"));
        return $allQuestions;
    }

    public function draftdeletePQuestionauthor($questionId)
    {
        PQuestionModel::where('pqId',$questionId)->delete();
        PQAnswerModel::where('pqId',$questionId)->delete();
        return redirect("/authordraftPQA")->with('success','Question Deleted');
    }


    public function draftPquestionUpdateauthor(Request $request)
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
        $updated_at= $this->currentDateTime;   /////////////from date
        $isAvail=2;

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

        return redirect("/authordraftPQA")->with('success','Question Updated');
    }
   
    function draftCategoryshowauthor(){
        $pqmainId=request()->get('pqmainId');
      //  $category=  CategoryModel::select()->where('pqmainId',$pqmainId)->where('isAvail','0')->get();
        $category=  CategoryModel::select()->where('pqmainId',$pqmainId)->get();
        return $category;
    }

    function draftsubCategoryshowauthor()
    {
        $pqmId=request()->get('pqmId');
       // $subcategory = SubCategoryModel::select()->where('pqmId',$pqmId)->where('isAvail','0')->get();
        $subcategory = SubCategoryModel::select()->where('pqmId',$pqmId)->get();
        return $subcategory;
    }
    function draftExamTypeshowauthor(){
        $category= DB::select("SELECT * from `pq_main` WHERE `isAvail`='0'");
        return $category;
    }
    function draftupdatePreviousQuestionFormauthor($pqId)
    {
       // $pqId=request('pqId');
       
         $allQuestions=(DB::select("SELECT t1.*, t2.*, t3.*, t4.*, b.`optionA` as ansA, b.`optionB` as ansB, b.`optionC` as ansC, b.`optionD` as ansD
         FROM `p_questions` t4
         INNER JOIN `pq_submodule` t3 ON t4.pqsmId = t3.pqsmId
         INNER JOIN `pq_module` t2 ON t3.pqmId = t2.pqmId
         INNER JOIN `pq_main` t1 ON t2.pqmainId = t1.pqmainId
         INNER JOIN `p_answers` b ON t4.`pqId` = b.`pqId`
         WHERE t4.`pqId` =$pqId;"));
        return view('authorizer/draftPQedit',compact('allQuestions'));
    }


    // /// APPROVING
    public function PQapprovingauthor($questionId)
    {
      
        $question = PQuestionModel::find($questionId);
        $answer = PQAnswerModel::find($questionId);
        
        $question->update(['isAvail' => 0]);
        $answer->update(['isAvail' => 0]);
  
  
        return redirect()->back()->with('success','Question Approved');
          
  
    }
    public function PQrefusingauthor($questionId)
    {
      
        $question = PQuestionModel::find($questionId);
        $answer = PQAnswerModel::find($questionId);
        
        $question->update(['isAvail' => 2]);
        $answer->update(['isAvail' => 2]);
  
  
        return redirect()->back()->with('success','Question Refused');
          
  
    }


































    /// video class-----------------

    ///////////// VIDEO CLASS authorizer  ----------------CONTROLLER--------------------------------
    //-----------------------------------------------------------------------------------------------
    //-----------------------------------------------------------------------------------------------
    //-----------------------------------------------------------------------------------------------

    function vcAuthorAddExamForm()
    {

       // $select3 =pqmainModel::select('pqmainId','pqmainName')->where('isAvail','=','0')->get();
      //  $categoryView = vcmoduleModel::select()->orderBy('isAvail', 'ASC')->where('isAvail','0')->get();
        $categoryView = vcmoduleModel::select()->orderBy('isAvail', 'ASC')->get();
       
        return view('authorizer/add_vcExamQ',compact('categoryView'));
    }

    

    function vcAuthorizerChaptersCheck()
    {

        $vcmid=request()->get('vcmid');
       // $pq_submodule_view = vcchapterModel::select()->where('vcmId',$vcmid)->where('isAvail','0')->get();
        $pq_submodule_view = vcchapterModel::select()->where('vcmId',$vcmid)->get();
        return $pq_submodule_view;
    }
    function videomoreAuthorizerCheck()
    {

        $vcChapterId=request()->get('vcChapterId');
      //  $vc_morevideo_view = vcmoreVideoModel::select()->where('vcChapterId',$vcChapterId)->where('isPublished','0')->get();
        $vc_morevideo_view = vcmoreVideoModel::select()->where('vcChapterId',$vcChapterId)->get();
        return $vc_morevideo_view;
    }

    public function postvdeoClsQuesauthor(Request $Request)
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
    public function showauthorizerVCQA()
    {
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
            a.isAvail = 0
        AND b.isAvail = 0
        AND c.isAvail IN (0,1)
        AND d.isAvail IN (0,1)
        AND e.isPublished IN (0,1)
    ORDER BY
        a.vcExamId DESC;");
        return view('authorizer/show_vcExamQ',compact('module_view','question'));
    }

    function vCauthorquestionTake()
    {
        $vcExamId=request()->get('vcExamId');
        $allQuestions=
          
              (DB::select("SELECT t1.*,t2.*, t3.*, t4.*, b.`optionA` as ansA, b.`optionB` as ansB, b.`optionC` as ansC, b.`optionD` as ansD
              FROM `vc_exams` t4
              
              INNER JOIN `vc_more_videos` t1 ON t4.vcVDId = t1.vcVDId
              INNER JOIN `vc_chapters` t3 ON t1.vcChapterId = t3.vcChapterId
              INNER JOIN `vc_module` t2 ON t3.vcmId = t2.vcmId
             
              INNER JOIN `vc_exam_ans` b ON t4.`vcExamId` = b.`vcExamId`
              WHERE t4.`vcExamId` =$vcExamId;"));
        return $allQuestions;
    }

   
    public function deleteauthorVCQuestion($questionId)
    {
        $question=vcexamModel::where('vcExamId',$questionId);
        $question->update(['isAvail' => 1]);
        $answer=vcansModel::where('vcExamId',$questionId);
        $answer->update(['isAvail' => 1]);
        return redirect("/vcauthorsshowexam")->with('success','Question Deleted');
    
    }

       

//     //---------------------------------Update Exam Start Here--------------------------------------
//      //------------------------------------------------------------------------------------------------------
//       //------------------------------------------------------------------------------------------------------

    function subjectauthorshow(){
  //  $category= DB::select("SELECT * from `vc_module` where `isAvail`=0");
    $category= DB::select("SELECT * from `vc_module` ");
    return $category;
    }

    function chapterauthorshow()
    {
        $vcmId=request()->get('vcmId');
      //  $subcategory = vcchapterModel::select()->where('vcmId',$vcmId)->where('isAvail','0')->get();
        $subcategory = vcchapterModel::select()->where('vcmId',$vcmId)->get();
        return $subcategory;
    }
    function morevideoauthorcheck()
    {
        $vcChapterId=request()->get('vcChapterId');
      //  $morevideo = vcmoreVideoModel::select()->where('vcChapterId',$vcChapterId)->where('isPublished','0')->get();
        $morevideo = vcmoreVideoModel::select()->where('vcChapterId',$vcChapterId)->get();
        return $morevideo;
    }


    function updateauthorVideoClassForm()
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
   
   
   return view('authorizer/edit_vcExam_question', compact('allVcQuestions'));
   
    }


    public function VcauthorquestionUpdate(Request $request)
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

        return redirect("/vcauthorsshowexam")->with('success','Question Updated');
    }
   
//     //------------------------------------------------------------------------------------------------------
//      //------------------------------------------------------------------------------------------------------
//       //------------------------------------------------------------------------------------------------------



//       APPROVE VIDEO CLASS ---THE AUTHOR------------


 /// APPROVING WORKERS ADDED VIDEO CLASS QUESTIONS ------------------------------- DRAFT QUESTIONS RUD


 public function authordraftVclassShowQ()
 {
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
     e.vcVDId AS vcVDId,
     a.isAvail as isAvail,b.isAvail as isAvail 
 FROM
     `vc_exams` AS a
     JOIN `vc_exam_ans` AS b ON b.vcExamId = a.vcExamId
     JOIN `vc_more_videos` AS e ON e.vcVDId = a.vcVDId
     JOIN `vc_chapters` AS c ON c.vcChapterId = e.vcChapterId
     JOIN `vc_module` AS d ON d.vcmId = c.vcmId
 WHERE
         a.isAvail =2
     AND b.isAvail =2
     AND c.isAvail IN (0,1)
     AND d.isAvail IN (0,1)
     AND e.isPublished IN (0,1)
 ORDER BY
     a.vcExamId DESC;");
     return view('authorizer/draft_show_QA',compact('module_view','question'));
 }

 function draftAuthorizerVcQuestionTake()
 {
     $vcExamId=request()->get('vcExamId');
     $allQuestions=
        
           (DB::select("SELECT t1.*,t2.*, t3.*, t4.*, b.`optionA` as ansA, b.`optionB` as ansB,
            b.`optionC` as ansC, b.`optionD` as ansD
           FROM `vc_exams` t4
           
           INNER JOIN `vc_more_videos` t1 ON t4.vcVDId = t1.vcVDId
           INNER JOIN `vc_chapters` t3 ON t1.vcChapterId = t3.vcChapterId
           INNER JOIN `vc_module` t2 ON t3.vcmId = t2.vcmId
          
           INNER JOIN `vc_exam_ans` b ON t4.`vcExamId` = b.`vcExamId`
           WHERE t4.`vcExamId` =$vcExamId;"));
     return $allQuestions;
 }


 public function draftauthordeleteVcQuestion($questionId)
 {
     $question=vcexamModel::where('vcExamId',$questionId);
     $question->update(['isAvail' => 1]);
     $answer=vcansModel::where('vcExamId',$questionId);
     $answer->update(['isAvail' => 1]);
     return redirect("/draftauthorVCQA")->with('success','Question Deleted');
 }


 public function draftauthorizerVClassquestionUpdate(Request $request)
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

     return redirect("/draftauthorVCQA")->with('success','Question Updated');
 }

 function draftauthorsubjectshow(){
    // $category= DB::select("SELECT * from `vc_module` where `isAvail`=0");
     $category= DB::select("SELECT * from `vc_module`");
     return $category;
 }

 function draftauthorchaptersshow()
 {
     $vcmId=request()->get('vcmId');
   //  $subcategory = vcchapterModel::select()->where('vcmId',$vcmId)->where('isAvail','0')->get();
     $subcategory = vcchapterModel::select()->where('vcmId',$vcmId)->get();
     return $subcategory;
 }
 function draftAuthorizermorevideocheck()
 {
     $vcChapterId=request()->get('vcChapterId');
    // $morevideo = vcmoreVideoModel::select()->where('vcChapterId',$vcChapterId)->where('isPublished','0')->get();
     $morevideo = vcmoreVideoModel::select()->where('vcChapterId',$vcChapterId)->get();
     return $morevideo;
 }
 function draftauthorizerupdateVideoclassQuestionForm()
 {
     $questionId=request('questionId');
    // print_r($questionId);die;
    
    $allVcQuestions = DB::select("SELECT t1.*,t2.*, t3.*, t4.*, b.`optionA` as ansA, b.`optionB` as ansB, b.`optionC` as ansC, b.`optionD` as ansD
    FROM `vc_exams` t4
    
    INNER JOIN `vc_more_videos` t1 ON t4.vcVDId = t1.vcVDId
    INNER JOIN `vc_chapters` t3 ON t1.vcChapterId = t3.vcChapterId
    INNER JOIN `vc_module` t2 ON t3.vcmId = t2.vcmId
   
    INNER JOIN `vc_exam_ans` b ON t4.`vcExamId` = b.`vcExamId`
    WHERE t4.`vcExamId` = $questionId");

return view('authorizer/Edit_vc_draft_Qustion', compact('allVcQuestions'));
 }


//  /// APPROVING
 public function VCQauthorapproving($questionId)
 {
   
     $question = vcexamModel::find($questionId);
     $answer = vcansModel::find($questionId);
     $getsessionuId = session()->get('user_id');
     
     $question->update([
         'isAvail' => 0,
         'updated_by' =>$getsessionuId
         ]);
     $answer->update([
         'isAvail' => 0,
         'updated_by' =>$getsessionuId
         ]);


     return redirect()->back()->with('success','Question Approved');
       

 }
 public function VCQauthorrefusing($questionId)
 {
   
     $question = vcexamModel::find($questionId);
     $answer = vcansModel::find($questionId);
     
     $question->update(['isAvail' => 2]);
     $answer->update(['isAvail' => 2]);


     return redirect()->back()->with('success','Question Refused');
       

 }

     ///////////// VIDEO CLASS Authorizer WORKS -------END---------CONTROLLER--------------------------------















      // PREVIOUS QUESTION SUBMODULE WISE RETRIVING


    public function PquestionauthorSubMUpdate(Request $request)
    {
        $pqId = request('pqId');
        $pqmId = request('pqmId');
        $pqmainId = request('pqmainId');

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

        $updated_by = request('user_id');                
        /////////////from SESSION VALUE
        $updated_at= $this->currentDateTime;   
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
            'updated_at'=>$updated_at,
            'updated_by'=>$updated_by]);
        //UPDATE ANSWER TO ANSWERS TABLE
        DB::update("UPDATE `p_answers` SET `optionA`=$value1,`optionB`=$value2,`optionC`=$value3,`optionD`=$value4,`updated_by`=$updated_by WHERE `pqId`=$pqId");

       // return redirect("/showPQAsubm")->with('success','Question Updated');
        return redirect("/showPQAsubmauthur")->with([
            'success' => 'Question Updated',
            'pqmainid' =>$pqmainId,
            'pqmid' => $pqmId,
            'pqsmid' =>$pqsmId
        ]); 
    }
   
    function pqsmauthorCategoryshow(){
        $pqmainId=request()->get('pqmainId');
      //  $category=  CategoryModel::select()->where('pqmainId',$pqmainId)->where('isAvail','0')->get();
        $category=  CategoryModel::select()->where('pqmainId',$pqmainId)->get();
        return $category;
    }

    function pqsmauthorSubCategoryshow()
    {
        $pqmId=request()->get('pqmId');
      //  $subcategory = SubCategoryModel::select()->where('pqmId',$pqmId)->where('isAvail','0')->get();
        $subcategory = SubCategoryModel::select()->where('pqmId',$pqmId)->get();
        return $subcategory;
    }
    function pqsmauthorExamTypeshow(){
        $category= DB::select("SELECT * from `pq_main` WHERE `isAvail`='0'");
        return $category;
    }
    function showPQAsmamicaauthor()
    {
       // dd("hai");
       
        $select3 =pqmainModel::select('pqmainId','pqmainName')->where('isAvail','=','0')->get();
        $categoryView = CategoryModel::select()->orderBy('isAvail', 'ASC')->where('isAvail','0')->get();
           
        return view('authorizer/view_pqsm_question',compact('select3','categoryView'));
        
    }

    function PQAauthorsubmodulecheck()
    {
        $pqsmId = request('pqsmId');
       
        $questions = DB::select("
            SELECT t1.*, t2.*, t3.*, t4.*, b.`optionA` as ansA, b.`optionB` as ansB, b.`optionC` as ansC, b.`optionD` as ansD
            FROM `p_questions` t4
            INNER JOIN `pq_submodule` t3 ON t4.pqsmId = t3.pqsmId
            INNER JOIN `pq_module` t2 ON t3.pqmId = t2.pqmId
            INNER JOIN `pq_main` t1 ON t2.pqmainId = t1.pqmainId
            INNER JOIN `p_answers` b ON t4.`pqId` = b.`pqId`
            WHERE t4.`pqsmId` = $pqsmId;
        ");
       
        return $questions;
    }
    

    public function deletePQauthorsubmoduleview($questionId)
    {
        PQuestionModel::where('pqId',$questionId)->delete();
        PQAnswerModel::where('pqId',$questionId)->delete();
       // return redirect("/showPQAsubmauthur")->with('success','Question Deleted');
        return redirect()->back()->with('success','Question Deleted');
    }

    function updatesubPreviousauthorQuestionForm($pqId)
    {
        //print_r('hai');die;
       // dd('hai');
        $pqId=request('pqId');
       
         $allQuestions=(DB::select("SELECT t1.*, t2.*, t3.*, t4.*, b.`optionA` as ansA, b.`optionB` as ansB, b.`optionC` as ansC, b.`optionD` as ansD
         FROM `p_questions` t4
         INNER JOIN `pq_submodule` t3 ON t4.pqsmId = t3.pqsmId
         INNER JOIN `pq_module` t2 ON t3.pqmId = t2.pqmId
         INNER JOIN `pq_main` t1 ON t2.pqmainId = t1.pqmainId
         INNER JOIN `p_answers` b ON t4.`pqId` = b.`pqId`
         WHERE t4.`pqId` =$pqId;"));
        return view('authorizer/edit_pqsm_question',compact('allQuestions'));
    }


    //approve subcategory wise
    public function PQapprovingsubcategorywiseauthor($parameter)
    {
        $pqId = Crypt::decrypt($parameter);
        $question = PQuestionModel::find($pqId);
        $answer = PQAnswerModel::find($pqId);
        $getsessionuId = session()->get('user_id');
        
        $question->update([
            'isAvail' => 0,
            'updated_by' =>$getsessionuId
            ]);
        $answer->update([
            'isAvail' => 0,
            'updated_by' =>$getsessionuId
            ]);
  
  
        return redirect()->back()->with('success','Question Approved');
       
          
  
    }
    public function PQsubcatewiserefusingauthor($parameter)
    {
       // dd();
       $pqId = Crypt::decrypt($parameter);
        $question = PQuestionModel::find($pqId);
        $answer = PQAnswerModel::find($pqId);
        
        $question->update(['isAvail' => 2]);
        $answer->update(['isAvail' => 2]);
  
  
        return redirect()->back()->with('success','Question Refused');
          
  
    }



// just checking -- sub--quest

function authorsubmodulecheckpq(Request $request)
{
    $smodule = request('smodule');
   
   // dd($smodule);
    $question = DB::select("
        SELECT t1.*, t2.*, t3.*, t4.*, b.`optionA` as ansA, b.`optionB` as ansB, b.`optionC` as ansC, b.`optionD` as ansD
        FROM `p_questions` t4
        INNER JOIN `pq_submodule` t3 ON t4.pqsmId = t3.pqsmId
        INNER JOIN `pq_module` t2 ON t3.pqmId = t2.pqmId
        INNER JOIN `pq_main` t1 ON t2.pqmainId = t1.pqmainId
        INNER JOIN `p_answers` b ON t4.`pqId` = b.`pqId`
        WHERE t4.`pqsmId` = $smodule
        AND t4.`isAvail`=2 AND b.`isAvail`=2;
    ");
   
  //  dd($question);
    return view('authorizer/view_pqsm_draftquest',compact('question'));
}




























/// AUTHORIZER --- ENTRY---------QUESTION BANK



// question bank add  view and approve-----------------------------------------------------------

function viewauthorModule()
{
   // $isAvail='0';
   // $module_view = ModuleModel::select()->where('isAvail',$isAvail)->get();
    $module_view = ModuleModel::select()->orderBy('mName', 'ASC')->get();
    return view('authorizer/question_add_form', compact('module_view'));
}

function authorizersubModulemainexmCheck()
{
   // $isAvail='0';
    $mid=request()->get('mid');
   // $submodule_view = SubModuleModel::select()->where('mId',$mid)->where('isAvail',$isAvail)->get();
    $submodule_view = SubModuleModel::select()->where('mId',$mid)->orderBy('smName', 'ASC')->get();
    //print_($submodule_view);
    return $submodule_view;
    //return view('question_add_form', compact('submodule_view'));
}




// //////////////////question based functionalities starts here////////////////////
public function postauthorizermainexmQues(Request $Request)
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

    $created_by = request('user_id');
    $updated_by = "0";
    $isAvail="2";

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


// //show quest
public function showauthorizermainexmQuestions()
{
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
                            WHERE a.`isAvail`=0 
                            AND d.`isAvail` IN (0,1)
                            AND c.`isAvail` IN (0,1)");
    return view('authorizer/questionShow',compact('module_view','question'));
}






public function questionauthorizermainexmUpdate(Request $Request )
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

    $updated_by = request('user_id');                  
    /////////////from SESSION VALUE
    $updated_at=$this->currentDateTime;   
    /////////////from date
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


    return redirect("/showauthormainQA")->with('success','Question Updated');

}
public function deleteauthorizermainexmQuestion($questionId)
{
    DB::update("UPDATE `cooperation_question` SET `isAvail`='1' WHERE `cqId`=$questionId");

    DB::update("UPDATE `cooperation_answer` SET `isAvail`='1' WHERE `cqId`= $questionId");

    return redirect("/showauthormainQA")->with('success','Question Deleted');
}




function questionauthorizermainexamTake()
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


function Moduleauthorizermainexmshow(){
   // $module= DB::select("SELECT * from `module` where `isAvail`=0");
    $module= DB::select("SELECT * from `module` ");
    return $module;
}


function updateauthorizermainexmQuestionForm(){
    //take value curresponding to questionid
    $cqId=request('cqId');
    
    $allQuestions=
        (
        DB::select("SELECT a.* ,
        (SELECT `mId` FROM `sub_module` WHERE `smId`=(a.smId)) as mId,
        (SELECT `mName` FROM `module` WHERE `mId`=(SELECT `mId` FROM `sub_module`WHERE `smId`=(a.smId)))as mName,
        (SELECT `smName` FROM `sub_module` WHERE `smId`=(a.smId))as smName,
        b.`optA` as ansA,b.`optB` as ansB,b.`optC` as ansC,b.`optD` as ansD,a.question_level as level FROM `cooperation_question` as a JOIN `cooperation_answer` as b on a.`cqId`=`b`.`cqId`  where a.`cqId`=$cqId"));
    
 
        return view('authorizer/editQuestion',compact('allQuestions'));
    }




  ////////////  draft -- main exam approving

  public function showdraftauthorizermainexmQuestions()
  {
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
                              a.isAvail as isAvail,
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
                              WHERE a.`isAvail` =2 
                              AND b.`isAvail` =2
                              AND d.`isAvail` IN (0,1)
                              AND c.`isAvail` IN (0,1)
                              ORDER BY b.cqId DESC;");
      return view('authorizer/draft_showQA',compact('module_view','question'));
  }






  public function mainExmauthorquestionDraftUpdate(Request $Request )
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

      $isAvail="2";
      $updated_by = request('user_id');                 
      /////////////from SESSION VALUE
      $updated_at=$this->currentDateTime;   
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


      return redirect("/draftauthorMainExam")->with('success','Question Updated');

  }


  public function deleteauthorizerDraftmainexmQuestion($questionId)
  {
      DB::update("UPDATE `cooperation_question` SET `isAvail`='1' WHERE `cqId`=$questionId");

      DB::update("UPDATE `cooperation_answer` SET `isAvail`='1' WHERE `cqId`= $questionId");

      return redirect("/draftauthorMainExam")->with('success','Question Deleted');
  }




  function questionauthorizermainexmDraftTake()
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


  function ModuleauthormainexmDraftshow(){
    //  $module= DB::select("SELECT * from `module` where `isAvail`=0");
      $module= DB::select("SELECT * from `module` ");
      return $module;
  }
  function subdraftauthormainexmModuleCheck()
  {
     // $isAvail='0';
      $mid=request()->get('mid');
    //  $submodule_view = SubModuleModel::select()->where('mId',$mid)->where('isAvail',$isAvail)->get();
      $submodule_view = SubModuleModel::select()->where('mId',$mid)->get();
      //print_($submodule_view);
      return $submodule_view;
      //return view('question_add_form', compact('submodule_view'));
  }


  function updateauthorizerdraftmainexmQuestionForm(){
      //take value curresponding to questionid
      $cqId=request('cqId');
      
      $allQuestions=
          (
          DB::select("SELECT a.* ,
          (SELECT `mId` FROM `sub_module` WHERE `smId`=(a.smId)) as mId,
          (SELECT `mName` FROM `module` WHERE `mId`=(SELECT `mId` FROM `sub_module`WHERE `smId`=(a.smId)))as mName,
          (SELECT `smName` FROM `sub_module` WHERE `smId`=(a.smId))as smName,
          b.`optA` as ansA,b.`optB` as ansB,b.`optC` as ansC,b.`optD` as ansD,a.question_level as level FROM `cooperation_question` as a JOIN `cooperation_answer` as b on a.`cqId`=`b`.`cqId`  where a.`cqId`=$cqId"));
      
   
          return view('authorizer/draft_edit_QA',compact('allQuestions'));
      }


//       /// APPROVING
      public function MEauthormainexmapproving($questionId)
      {
      
          $question = QuestionModel::find($questionId);
          $answer = AnswerModel::find($questionId);
          
          $question->update(['isAvail' => 0]);
          $answer->update(['isAvail' => 0]);
  
  
          return redirect()->back()->with('success','Question Approved');
          
  
      }
      public function MEauthormainexamrefusing($questionId)
      {
      
          $question = QuestionModel::find($questionId);
          $answer = AnswerModel::find($questionId);
          
          $question->update(['isAvail' => 2]);
          $answer->update(['isAvail' => 2]);
  
  
          return redirect()->back()->with('success','Question Refused');
          
  
      }
































      // sub module wise author approving question bank(entry)

      function submodulewisecheckingform()
      {
         // $isAvail='0';
         // $module_view = ModuleModel::select()->where('isAvail',$isAvail)->get();
          $module_view = ModuleModel::select()->get();
          return view('authorizer/submodulewise_checkform', compact('module_view'));
      }

     // ajax check submodule corresponded module
      function authorizersubModulewiseauthorizerCheck()
        {
           // $isAvail='0';
            $mid=request()->get('mid');
           // $submodule_view = SubModuleModel::select()->where('mId',$mid)->where('isAvail',$isAvail)->get();
            $submodule_view = SubModuleModel::select()->where('mId',$mid)->get();
           
            return $submodule_view;
           
        }

        //get sub module id and find that submodule corresponded data
        //and author approving
        
        function submodulewiseauthorapprovingdraftmainexam(Request $request)
        {
            $smodule = request('smodule');
        
        // dd($smodule);
            $question = DB::select("
            SELECT 
            a.cqId AS questionId,
            a.smId AS subModuleId,
            a.question,
            a.qcode as questionCode,
            a.optA as optionA,
            a.optB as optionB,
            a.optC as optionC,
            a.optD as optionD,
            a.isAvail as isAvail,
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
            WHERE c.smId=$smodule
            AND  a.`isAvail` =2
            AND b.`isAvail` =2
            AND d.`isAvail` IN (0,1)
            AND c.`isAvail` IN (0,1)
            ORDER BY b.cqId DESC;
            ");
        
        //  dd($question);
            return view('authorizer/view_submodulewisedraft',compact('question'));
        }




         ////////////  draft --submodule wise main exam approving



  public function mainExmsubmodulewiseauthorquestionDraftUpdate(Request $Request )
  {
      $cqId = request('cqId');
      $qCode = request('qCode');
      

      $mId=request('mId');
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

      $isAvail="2";
      $updated_by = request('user_id');                  
      /////////////from SESSION VALUE
      $updated_at=$this->currentDateTime;  
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


     // return redirect("/submodulewisemainexm")->with('success','Question Updated');
     
      return redirect("/submodulewisemainexm")->with([
        'success' => 'success','Question Updated',
        'mid' => $mId,
        'smid' =>$smId
    ]); 
     
     
      //return redirect()->back()->with('success','Question Updated');

  }


  public function deleteauthorizerDraftsubmodulewisemainexmQuestion($questionId)
  {
      DB::update("UPDATE `cooperation_question` SET `isAvail`='1' WHERE `cqId`=$questionId");

      DB::update("UPDATE `cooperation_answer` SET `isAvail`='1' WHERE `cqId`= $questionId");

     // return redirect("/submodulewisemainexm")->with('success','Question Deleted');
      return redirect()->back()->with('success','Question Deleted');
  }




  function questionauthorizersubmodulewisemainexmDraftTake()
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


  function ModuleauthorsubmmainexmDraftshow(){
     // $module= DB::select("SELECT * from `module` where `isAvail`=0");
      $module= DB::select("SELECT * from `module` ");
      return $module;
  }
  function subdraftauthorsubmodulewisemainexmModuleCheck()
  {
     // $isAvail='0';
      $mid=request()->get('mid');
    //  $submodule_view = SubModuleModel::select()->where('mId',$mid)->where('isAvail',$isAvail)->get();
      $submodule_view = SubModuleModel::select()->where('mId',$mid)->get();
      //print_($submodule_view);
      return $submodule_view;
      //return view('question_add_form', compact('submodule_view'));
  }


  function updateauthorizerdraftsubmodulewisemainexmQuestionForm(){
      //take value curresponding to questionid
      $cqId=request('cqId');
      
      $allQuestions=
          (
          DB::select("SELECT a.* ,
          (SELECT `mId` FROM `sub_module` WHERE `smId`=(a.smId)) as mId,
          (SELECT `mName` FROM `module` WHERE `mId`=(SELECT `mId` FROM `sub_module`WHERE `smId`=(a.smId)))as mName,
          (SELECT `smName` FROM `sub_module` WHERE `smId`=(a.smId))as smName,
          b.`optA` as ansA,b.`optB` as ansB,b.`optC` as ansC,b.`optD` as ansD,a.question_level as level FROM `cooperation_question` as a JOIN `cooperation_answer` as b on a.`cqId`=`b`.`cqId`  where a.`cqId`=$cqId"));
      
   
          return view('authorizer/edit_submodulewisedraft',compact('allQuestions'));
      }


// //       /// APPROVING
      public function MEsubmodulewiseauthormainexmapproving($questionId)
      {
      
          $question = QuestionModel::find($questionId);
          $answer = AnswerModel::find($questionId);
          $getsessionuId = session()->get('user_id');
          
          $question->update([
              'isAvail' => 0,
              'updated_by' =>$getsessionuId
              ]);
          $answer->update([
              'isAvail' => 0,
              'updated_by' =>$getsessionuId
              ]);
  
  
          return redirect()->back()->with('success','Question Approved');
          
  
      }
      public function MEsubmodulewiseauthormainexamrefusing($questionId)
      {
      
          $question = QuestionModel::find($questionId);
          $answer = AnswerModel::find($questionId);
          
          $question->update(['isAvail' => 2]);
          $answer->update(['isAvail' => 2]);
  
  
          return redirect()->back()->with('success','Question Refused');
          
  
      }






}
