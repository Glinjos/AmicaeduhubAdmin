<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PreviousQuestionModels\CategoryModel;
use App\Models\PreviousQuestionModels\PQAnswerModel;
use App\Models\PreviousQuestionModels\PQuestionModel;
use App\Models\PreviousQuestionModels\SubCategoryModel;
use App\Models\pqmainModel;
use Illuminate\Routing\Controller;

use App\Models\ModuleModel;

use App\Models\ImagePQAModel\imagePquestionModel;
use App\Models\ImagePQAModel\imagePanswerModel;
use DB;

use Illuminate\Support\Facades\Crypt;


use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Session;
 

class ImagePQAController extends Controller
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


    public function showdraftsuperadminimagePqa(){

        $module_view=CategoryModel::select()->get();

        $question=DB::select("SELECT  a.ipqId AS questionId, a.pqsmId AS subModuleId,a.question,
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
        FROM `image_p_questions`as a 
         
        JOIN `pq_submodule` as c
        ON c.pqsmId=a.pqsmId
        
        JOIN `pq_module` as d
        ON c.pqmId=d.pqmId
        
        JOIN `pq_main` as f
        
         ON f.pqmainId=d.pqmainId 
        
        JOIN  `image_p_answers`as b  
        ON a.`ipqId`=b.`ipqId`
         WHERE a.`isAvail` =2
            AND b.`isAvail` =2
            AND d.`isAvail` IN (0,1)
            AND c.`isAvail` IN (0,1)
            AND f.`isAvail`=0
            ORDER BY a.ipqId DESC;");
        return view('imagePQA/draftPQshow',compact('module_view','question'));
       
    }

    function draftImageBasedAddedPquestionTake()
    {
        $ipqId=request()->get('ipqId');
        $allQuestions=
           
              (DB::select("SELECT t4.ipqId as questionId,t4.optionA,t4.optionB,t4.optionC,t4.optionD, b.`optionA` as ansA, b.`optionB` as ansB, b.`optionC` as ansC, b.`optionD` as ansD
              FROM `image_p_questions` t4
              INNER JOIN `pq_submodule` t3 ON t4.pqsmId = t3.pqsmId
              INNER JOIN `pq_module` t2 ON t3.pqmId = t2.pqmId
              INNER JOIN `pq_main` t1 ON t2.pqmainId = t1.pqmainId
              INNER JOIN `image_p_answers` b ON t4.`ipqId` = b.`ipqId`
              WHERE t4.`ipqId` =$ipqId;"));
        return $allQuestions;
    }
    //delete
    public function draftImagebasedPquestionDelete($questionId)
    {
        imagePquestionModel::where('ipqId',$questionId)->delete();
        imagePanswerModel::where('ipqId',$questionId)->delete();
        return redirect()->back()->with('success','Question Deleted');
    }
    /// APPROVING
    public function DraftimagebasedaddedApprovePQ($questionId)
    {
      
        $question = imagePquestionModel::find($questionId);
        $answer = imagePanswerModel::find($questionId);
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

    //showq
    function imagebaseaddedPquestionTake()
    {
        $ipqId=request()->get('ipqId');
        $allQuestions=
            (DB::select("SELECT t1.*, t2.*, t3.*, t4.*, b.`optionA` as ansA, b.`optionB` as ansB, b.`optionC` as ansC, b.`optionD` as ansD
            FROM `image_p_questions` t4
            INNER JOIN `pq_submodule` t3 ON t4.pqsmId = t3.pqsmId
            INNER JOIN `pq_module` t2 ON t3.pqmId = t2.pqmId
            INNER JOIN `pq_main` t1 ON t2.pqmainId = t1.pqmainId
            INNER JOIN `image_p_answers` b ON t4.`ipqId` = b.`ipqId`
            WHERE t4.`ipqId` =$ipqId;"));
        return $allQuestions;
    }


    //update form
    function draftImagebaseaddedupdatePQQuestion()
    {
        $ipqId=request('questionId');
       
         $allQuestions=(DB::select("SELECT t1.*, t2.*, t3.*, t4.*, b.`optionA` as ansA, b.`optionB` as ansB, b.`optionC` as ansC, b.`optionD` as ansD
         FROM `image_p_questions` t4
         INNER JOIN `pq_submodule` t3 ON t4.pqsmId = t3.pqsmId
         INNER JOIN `pq_module` t2 ON t3.pqmId = t2.pqmId
         INNER JOIN `pq_main` t1 ON t2.pqmainId = t1.pqmainId
         INNER JOIN `image_p_answers` b ON t4.`ipqId` = b.`ipqId`
         WHERE t4.`ipqId` =$ipqId;"));
        return view('imagePQA/draftPQedit',compact('allQuestions'));
    }


    // edit the modules
    function draftImageBasespExamTypeshow(){
        $category= DB::select("SELECT * from `pq_main` WHERE `isAvail`='0'");
        return $category;
    }
    function draftImagebasespCategoryshow(){
        $pqmainId=request()->get('pqmainId');
      //  $category=  CategoryModel::select()->where('pqmainId',$pqmainId)->where('isAvail','0')->get();
        $category=  CategoryModel::select()->where('pqmainId',$pqmainId)->get();
        return $category;
    }

    function draftImagebasespsubCategoryshow()
    {
        $pqmId=request()->get('pqmId');
       // $subcategory = SubCategoryModel::select()->where('pqmId',$pqmId)->where('isAvail','0')->get();
        $subcategory = SubCategoryModel::select()->where('pqmId',$pqmId)->get();
        return $subcategory;
    }

    //end the modules


    //update
    public function draftImagebasePreviousQuestionUpdate(Request $request)
    {
        $ipqId = request('ipqId');

        $smIdfrominput = request('pqsmId');
        $smIdfromdropdown = request('showsubmoduledropdown');
        if($smIdfromdropdown==""){
            $pqsmId=$smIdfrominput;//NO DROPDOWN SELECTED
        }else{
            $pqsmId=$smIdfromdropdown;//SUBCATEGORY CHANGED
        }

        $question = request('questionIMAGE');
        $option1 = request('option_1image');
        $option2 = request('option_2image');
        $option3 = request('option_3image');
        $option4 = request('option_4image');
        $answer = request('answerImage');

        $updated_by = request('user_id');                  /////////////from SESSION VALUE
        $updated_at= $this->currentDateTime;   /////////////from date
        $isAvail=2;

        //check the answers

        if($answer=="option1image")
        {$value1=1;$value2=0;$value3=0;$value4=0;}
        else if($answer=="option2image")
        {$value1=0;$value2=1;$value3=0;$value4=0;}
        else if($answer=="option3image")
        {$value1=0;$value2=0;$value3=1;$value4=0;}
        else if($answer=="option4image")
        {$value1=0;$value2=0;$value3=0;$value4=1;}

        //UPDATE QUESTIONS TO QUESTION TABLE

        $pqmodule = imagePquestionModel::find($ipqId);
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
        DB::update("UPDATE `image_p_answers` SET `optionA`=$value1,`optionB`=$value2,`optionC`=$value3,`optionD`=$value4,`isAvail`=$isAvail,`updated_by`=$updated_by WHERE `ipqId`=$ipqId");

        return redirect("/showdraftsuperadminimagePqa")->with('success','Question Updated');
    }
   














     // is avail 0->0 question showing
    public function showapprovedsuperadminimagePqa(){

        $module_view=CategoryModel::select()->get();

        $question=DB::select("SELECT  a.ipqId AS questionId, a.pqsmId AS subModuleId,a.question,
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
        FROM `image_p_questions`as a 
         
        JOIN `pq_submodule` as c
        ON c.pqsmId=a.pqsmId
        
        JOIN `pq_module` as d
        ON c.pqmId=d.pqmId
        
        JOIN `pq_main` as f
        
         ON f.pqmainId=d.pqmainId 
        
        JOIN  `image_p_answers`as b  
        ON a.`ipqId`=b.`ipqId`
         WHERE a.`isAvail` =0
            AND b.`isAvail` =0
            AND d.`isAvail` IN (0,1)
            AND c.`isAvail` IN (0,1)
            AND f.`isAvail`=0
            ORDER BY a.ipqId DESC;");
        return view('imagePQA/PQshow',compact('module_view','question'));

    }
     //delete
     public function approvedImagebasedPquestionDelete($questionId)
     {
         imagePquestionModel::where('ipqId',$questionId)->delete();
         imagePanswerModel::where('ipqId',$questionId)->delete();
         return redirect()->back()->with('success','Question Deleted');
     }
      //update form
    function approvedImagebaseaddedupdatePQQuestion()
    {
        $ipqId=request('questionId');
       
         $allQuestions=(DB::select("SELECT t1.*, t2.*, t3.*, t4.*, b.`optionA` as ansA, b.`optionB` as ansB, b.`optionC` as ansC, b.`optionD` as ansD
         FROM `image_p_questions` t4
         INNER JOIN `pq_submodule` t3 ON t4.pqsmId = t3.pqsmId
         INNER JOIN `pq_module` t2 ON t3.pqmId = t2.pqmId
         INNER JOIN `pq_main` t1 ON t2.pqmainId = t1.pqmainId
         INNER JOIN `image_p_answers` b ON t4.`ipqId` = b.`ipqId`
         WHERE t4.`ipqId` =$ipqId;"));
        return view('imagePQA/PQedit',compact('allQuestions'));
    }
     //update
     public function approvedImagebasePreviousQuestionUpdate(Request $request)
     {
         $ipqId = request('ipqId');
 
         $smIdfrominput = request('pqsmId');
         $smIdfromdropdown = request('showsubmoduledropdown');
         if($smIdfromdropdown==""){
             $pqsmId=$smIdfrominput;//NO DROPDOWN SELECTED
         }else{
             $pqsmId=$smIdfromdropdown;//SUBCATEGORY CHANGED
         }
 
         $question = request('questionIMAGE');
         $option1 = request('option_1image');
         $option2 = request('option_2image');
         $option3 = request('option_3image');
         $option4 = request('option_4image');
         $answer = request('answerImage');
 
         $updated_by = request('user_id');                  /////////////from SESSION VALUE
         $updated_at= $this->currentDateTime;   /////////////from date
         $isAvail=0;
 
         //check the answers
 
         if($answer=="option1image")
         {$value1=1;$value2=0;$value3=0;$value4=0;}
         else if($answer=="option2image")
         {$value1=0;$value2=1;$value3=0;$value4=0;}
         else if($answer=="option3image")
         {$value1=0;$value2=0;$value3=1;$value4=0;}
         else if($answer=="option4image")
         {$value1=0;$value2=0;$value3=0;$value4=1;}
 
         //UPDATE QUESTIONS TO QUESTION TABLE
 
         $pqmodule = imagePquestionModel::find($ipqId);
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
         DB::update("UPDATE `image_p_answers` SET `optionA`=$value1,`optionB`=$value2,`optionC`=$value3,`optionD`=$value4,`isAvail`=$isAvail,`updated_by`=$updated_by WHERE `ipqId`=$ipqId");
 
         return redirect("/showapprovedsuperadminimagePqa")->with('success','Question Updated');
     }
   
















}
