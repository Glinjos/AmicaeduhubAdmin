<?php
/**
 * Created by vsCode.
 * Use: Question Bank(Main Exam)
 * Question Adding.

 */
namespace App\Http\Controllers;

use Illuminate\Routing\Controller;

use Illuminate\Http\Request;


use DB;
use App\Models\GenaralQuestionModels\ModuleModel;
use App\Models\GenaralQuestionModels\SubModuleModel;
use App\Models\GenaralQuestionModels\QuestionModel;
use App\Models\GenaralQuestionModels\AnswerModel;
use App\Models\User;
use App\Models\user_detail_Model;
use App\Models\LiveGameModels\lgmasterModel;
use App\Models\LiveGameModels\lghistoryModel;

use App\Models\PreviousQuestionModels\CategoryModel;

use App\Models\ChatUsersModels\chatTypeModel;
use App\Models\ChatUsersModels\chatQuestionsMainModel;
use App\Models\ChatUsersModels\chatQuestionsAnsModel;



use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Session;




class AdminController extends Controller
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



    public function dashboard()
    {
       
        $module = ModuleModel::select('mId','mName')->orderBy('mName','ASC')->get();
        $pqcseb =CategoryModel::select()->where('pqmainId',2)->orderBy('pqmName','ASC')->get();//2->is cseb
        $pqpsc =CategoryModel::select()->where('pqmainId',3)->orderBy('pqmName','ASC')->get();//3->is PSC
        
        $checkNotification=DB::select("SELECT COUNT(sub.question) as unanswered_questions
        FROM `chat_questions_sub` as sub
        JOIN `chat_questions_main` as main ON main.chatQuestionId = sub.chatQuestionId
        LEFT JOIN `chat_questions_ans` as ans ON ans.chatQuestionId = main.chatQuestionId
        WHERE ans.chatQuestionId IS NULL
        AND main.isClosed=0;");
        
        
        
        return view('admin.dashboard',compact('module','pqcseb','pqpsc','checkNotification'));
       
    }
    public function main_exam_totalcount_geting(Request $request)
    {
        $mId = request('m_Id');
        
        $counts = DB::select("SELECT sub_m.smName, COUNT(CASE WHEN quest.isAvail = 0 THEN quest.question ELSE NULL END) as question_approved,
        COUNT(CASE WHEN quest.isAvail = 2 THEN quest.question ELSE NULL END) as question_pending
        FROM `sub_module` as sub_m
        LEFT JOIN `cooperation_question` as quest on quest.smId = sub_m.smId
        WHERE sub_m.mId = $mId
        GROUP BY sub_m.smName
        ORDER BY sub_m.smName ASC;");
        
        $total_count=DB::select("SELECT 
        (SELECT COUNT(quest.question) FROM `cooperation_question` as quest WHERE quest.isAvail = 0 AND quest.smId IN
         (SELECT smId FROM `sub_module` WHERE mId = $mId)) as total_approved,
        (SELECT COUNT(quest.question) FROM `cooperation_question` as quest WHERE quest.isAvail = 2 AND quest.smId IN 
        (SELECT smId FROM `sub_module` WHERE mId = $mId)) as total_pending;");

       // return $counts,$total_count;

        $result['counts']              = $counts;
        $result['total_count']         = $total_count;

        return $result;
        
    }
     public function pqcseb_totalcount_geting(Request $request)
    {
        $pqmId_cseb_Id = request('pqmId_cseb_Id');
        
        $counts_cseb = DB::select("SELECT pq_submodule_cseb.pqsmName, COUNT(CASE WHEN quest_cseb.isAvail = 0 THEN quest_cseb.question ELSE NULL END) as question_approved_cseb,
        COUNT(CASE WHEN quest_cseb.isAvail = 2 THEN quest_cseb.question ELSE NULL END) as question_pending_cseb
        FROM `pq_submodule` as pq_submodule_cseb
        LEFT JOIN `p_questions` as quest_cseb on quest_cseb.pqsmId = pq_submodule_cseb.pqsmId
        WHERE pq_submodule_cseb.pqmId = $pqmId_cseb_Id
        GROUP BY pq_submodule_cseb.pqsmName
        ORDER BY pq_submodule_cseb.pqsmName ASC;");

        $total_count_cseb=DB::select("SELECT 
        (SELECT COUNT(quest_cseb.question) FROM `p_questions` as quest_cseb WHERE quest_cseb.isAvail = 0 AND   quest_cseb.pqsmId IN
        (SELECT pqsmId FROM `pq_submodule` WHERE pqmId = $pqmId_cseb_Id)) as total_approved,
        (SELECT COUNT(quest_cseb.question) FROM `p_questions` as quest_cseb WHERE quest_cseb.isAvail = 2 AND quest_cseb.pqsmId IN 
        (SELECT pqsmId FROM `pq_submodule` WHERE pqmId = $pqmId_cseb_Id)) as total_pending;");

        $result['counts_cseb']              = $counts_cseb;
        $result['total_count_cseb']         = $total_count_cseb;

        return $result;
        
    }
     public function pqpsc_totalcount_geting(Request $request)
    {
        $pqmId_psc_Id = request('pqmId_psc_Id');
        
        $counts_psc = DB::select("SELECT pq_submodule_psc.pqsmName, COUNT(CASE WHEN quest_psc.isAvail = 0 THEN quest_psc.question ELSE NULL END) as question_approved_psc,
        COUNT(CASE WHEN quest_psc.isAvail = 2 THEN quest_psc.question ELSE NULL END) as question_pending_psc
        FROM `pq_submodule` as pq_submodule_psc
        LEFT JOIN `p_questions` as quest_psc on quest_psc.pqsmId = pq_submodule_psc.pqsmId
        WHERE pq_submodule_psc.pqmId = $pqmId_psc_Id
        GROUP BY pq_submodule_psc.pqsmName
        ORDER BY pq_submodule_psc.pqsmName ASC;");

        $total_count_psc=DB::select("SELECT 
        (SELECT COUNT(quest_psc.question) FROM `p_questions` as quest_psc WHERE quest_psc.isAvail = 0 AND   quest_psc.pqsmId IN
        (SELECT pqsmId FROM `pq_submodule` WHERE pqmId = $pqmId_psc_Id)) as total_approved,
        (SELECT COUNT(quest_psc.question) FROM `p_questions` as quest_psc WHERE quest_psc.isAvail = 2 AND quest_psc.pqsmId IN 
        (SELECT pqsmId FROM `pq_submodule` WHERE pqmId = $pqmId_psc_Id)) as total_pending;");

        $result['counts_psc']              = $counts_psc;
        $result['total_count_psc']         = $total_count_psc;

        return $result;
        
    }
    
    
    
    
    
    
    
    
    
    
    
    




    /////////////*creating,updating and deleting modules by krishnendh and sana*//////////////////////
    public function createModule()
    {
        $module = ModuleModel::orderBy('isAvail', 'ASC')->get();
        return view('admin/addModule', compact('module'));

    }

    public function storeModule(Request $request)
    {
        $validatedData = $request->validate([
            'ModuleCode' => 'required|regex:/^[A-Za-z]+$/|min:2|max:5',
            'ModuleName' => 'required|regex:/^[\pL\s]+$/u|min:3|max:50',

        ], [
            'ModuleCode.required' => 'Module code field is required.',
            'ModuleName.required' => 'Module name field is required.',
        ]);

        $createdBy= request('user_id');
        $updatedBy='0';

        $createdAt= $this->currentDateTime;

        $mCode = $request['ModuleCode'];
        $mCode=preg_replace('/\s+/', ' ', $mCode);
        $mCode=strtoupper($mCode);

        $mName = $request['ModuleName'];
        $mName=preg_replace('/\s+/', ' ', $mName);
        $mName=strtoupper($mName);

        $module1 = ModuleModel::where('mCode',$request->ModuleCode)->first();
        $module2 = ModuleModel::where('mName',$request->ModuleName)->first();

        if ($module1 != null) {

            return redirect()->back()->with('error','Module Code Already Exists');
        }elseif ($module2 != null) {

            return redirect()->back()->with('error','Module Name Already Exists');
        } else {
            $module = new ModuleModel();
            $module->mCode = $mCode;
            $module->mName = $mName;
            $module->created_by = $createdBy;
            $module->created_at = $createdAt;
            $module->updated_by = $updatedBy;

            $module->save();
            return redirect()->back()->with('success','Module Added');
        }

    }

    public function updateModuleForm($mId)
    {
        $module = ModuleModel::select('mId','mCode','mName')->where('mId',$mId)->get();

        return view('admin/updateModule', compact('module'));

    }

    function moduleCodeCheck()
    {
        $mCode=request()->get('mCode');
        $isAvail=0;
        $module=DB::select("SELECT * FROM `module` WHERE `mCode`='$mCode'");

        return $module;

    }
    function moduleNameCheck()
    {
        $mName=request()->get('mName');
        $isAvail=0;
        $module=DB::select("SELECT * FROM `module` WHERE `mName`='$mName'");

        return $module;

    }


    public function updateModule(Request $request,$mId)
    {
        $validatedData = $request->validate([
            'ModuleCode' => 'required|regex:/^[A-Za-z]+$/|min:3|max:5',
            'ModuleName' => 'required|regex:/^[\pL\s]+$/u|min:3|max:50',

        ], [
            'ModuleCode.required' => 'Module Code field is required.',
            'ModuleName.required' => 'Module Came field is required.',
        ]);


        $updatedBy='1';
        $updatedAt= $this->currentDateTime;

        $mCode = $request['ModuleCode'];
        $mCode=preg_replace('/\s+/', ' ', $mCode);
        $mCode=strtoupper($mCode);

        $mName = $request['ModuleName'];
        $mName=preg_replace('/\s+/', ' ', $mName);
        $mName=strtoupper($mName);

        $module1=DB::select("SELECT * FROM `module` WHERE `mId` NOT IN ($mId) AND (`mCode`='$mCode')");
        $module2=DB::select("SELECT * FROM `module` WHERE `mId` NOT IN ($mId) AND (`mName`='$mName')");

        if ($module1 != null) {

            return redirect()->back()->with('error','Module Code Already Exists');

        }else if($module2 != null ) {

            return redirect()->back()->with('error','Module Name Already Exists');

        } else {

            $module = ModuleModel::find($mId);

            $module->update([
                'mId'=>$mId,
                'mName' =>  $mName,
                'mCode'=>$mCode,
                'updated_by'=> $updatedBy,
                'updated_at'=>$updatedAt
            ]);

            return redirect("/createModule")->with('success','Module Updated');
        }

    }

    public function disableModule($mId)
    {
        $isAvail=1;
        $module = ModuleModel::where('mId',$mId)->update(['isAvail'=>$isAvail]);
        SubModuleModel::where('mId',$mId)->update(['isAvail'=>$isAvail]);

        return redirect()->back()->with('success','Module Deactivated');
    }

    public function EnableModule($mId)
    {
        $isAvail=0;
        $module = ModuleModel::where('mId',$mId)->update(['isAvail'=>$isAvail]);
        SubModuleModel::where('mId',$mId)->update(['isAvail'=>$isAvail]);

        return redirect()->back()->with('success','Module Activated');
    }

///////////////////////*ends here*//////////////////////////

    public function index()
    {
       // $select1 =ModuleModel::select()->orderBy('isAvail', 'ASC')->where('isAvail','0')->get();
        $select1 =ModuleModel::select()->orderBy('isAvail', 'ASC')->orderBy('mName', 'ASC')->get();
        $select=DB:: select("SELECT A.mName,A.mCode,B.smId,B.mId,B.smName,B.smCode,B.isAvail FROM module AS A INNER JOIN sub_module as B ON A.mId=B.mId ORDER BY B.isAvail ASC");
        return view('admin/submodule', compact('select','select1'));

    }


    // CONTROLLER FOR add data to submodule db
    public function addsub(Request $request)
    {
        $validatedData = $request->validate([
            'submcode' => 'required|regex:/^[A-Za-z0-9]+$/|min:4|max:9',
            'submodule' => 'required',

        ], [
            'submcode.required' => 'Module code field is required.',
            'submodule.required' => 'Sub Module name field is required.',
        ]);


        $createdBy=request('user_id');                                                     //FROM SESSION
        $updatedBy='0';                                                      //FROM SESSION

        $isAvail='0';
         $createdAt= $this->currentDateTime;

        $mid =request('mid');
        $smCode = request('submcode');
        $smCode=preg_replace('/\s+/', ' ', $smCode);
        $smCode=strtoupper($smCode);

        $currentCode = preg_replace('/[^0-9]/', '', $smCode);
         $currentCode=$currentCode-1;

        $smName = request('submodule');
        $smName=preg_replace('/\s+/', ' ', $smName);
        $smName=ucwords($smName);

        $module = SubModuleModel::Where('smName',$request->submodule)->where('isAvail',$isAvail)->first();
        if ($module != null) {
            return redirect()->back()->with('error','Sub Module Name Already Exists');
        }
        else
        {
            $module = new SubModuleModel();
            $module->mId = $mid;
            $module->smCode = $smCode;
            $module->smName = $smName;
            $module->currentCode = $currentCode;
            $module->created_by = $createdBy;
            $module->created_at = $createdAt;
            $module->save();
           
            return redirect()->back()->with([
                'success' => 'Sub Module Added',
                'mid' => $mid
            ]); 
        }
    }
    function submoduleNameCheck()
    {
        $smName=request('submodule');

        $isAvail=0;
        $submodule=DB::select("SELECT * FROM `sub_module` WHERE `smName`='$smName'");

        return $submodule;

    }


    function smCodeFunction()
    {
        $mcCode=request()->get('mcCode');
        $lastsubid=(DB::select("SELECT max(`smCode`) as `smCode` FROM `sub_module` WHERE `mId`=(select `mid` from `module` where `module`.`mCode`='$mcCode') "));
       // print_r($lastsubid);die();
        return $lastsubid;
    }

    function viewModule()
    {
       // $isAvail='0';
       // $module_view = ModuleModel::select()->where('isAvail',$isAvail)->get();
        $module_view = ModuleModel::select()->orderBy('mName', 'ASC')->get();
        return view('admin/question_add_form', compact('module_view'));
    }

    function subModuleCheck()
    {
       // $isAvail='0';
        $mid=request()->get('mid');
       // $submodule_view = SubModuleModel::select()->where('mId',$mid)->where('isAvail',$isAvail)->get();
        $submodule_view = SubModuleModel::select()->where('mId',$mid)->orderBy('smName', 'ASC')->get();
        //print_($submodule_view);
        return $submodule_view;
        //return view('question_add_form', compact('submodule_view'));
    }


  //update the subM
    public function updateSubModuleForm($smId)
    {
        $subModule = SubModuleModel::select('smId','mId','smCode','smName')->where('smId',$smId)->get();

        return view('admin/updateSubModule', compact('subModule'));

    }

    public function updateSubModule(Request $request,$smId)
    {

        $validatedData = $request->validate([
            'smName' => 'required',

        ], [
            'smName.required' => 'Sub Module Name field is required.',
        ]);


        $updatedBy='1';
        $updatedAt= $this->currentDateTime;


        $smName = $request['smName'];
        // dd($smName);
        $smName=preg_replace('/\s+/', ' ', $smName);
        $smName=ucwords($smName);

        $subModule=DB::select("SELECT * FROM `sub_module` WHERE `smId` NOT IN ($smId) AND (`smName`='$smName')");

        if ($subModule != null) {

            return redirect()->back()->with('error','Sub Module Name Already Exists');

        }else {

            $subModule = SubModuleModel::find($smId);

            $subModule->update([
                'smId' => $smId,
                'smName' => $smName,
                'updated_by' => $updatedBy,
                'updated_at' => $updatedAt
            ]);


            return redirect("/toSubmodule")->with('success', 'Sub Module Updated');
        }
    }

    public function subModuleInactive($smId)
    {
        $isAvail='1';
        $subModule = SubModuleModel::find($smId);

        $subModule->update([
            'smId'=>$smId,
            'isAvail' => $isAvail,
        ]);
        return redirect()->back()->with('success','Sub Module Deactivated');
    }
    public function subModuleActive($smId)
    {
        $isAvail='0';
        $subModule = SubModuleModel::find($smId);

        $subModule->update([
            'smId'=>$smId,
            'isAvail' => $isAvail,
        ]);
        return redirect()->back()->with('success','Sub Module Activated');
    }
    ///////////////////////////////ends here/////////////////////////////////////


    //////////////////question based functionalities starts here////////////////////
    public function postQues(Request $Request)
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


    //show quest
    public function showQuestions()
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
                                AND c.`isAvail` IN (0,1);");
        return view('admin/questionShow',compact('module_view','question'));
    }






    public function questionUpdate(Request $Request )
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


        return redirect("/showQA")->with('success','Question Updated');

    }
    public function deleteQuestion($questionId)
    {
        DB::update("UPDATE `cooperation_question` SET `isAvail`='1' WHERE `cqId`=$questionId");

        DB::update("UPDATE `cooperation_answer` SET `isAvail`='1' WHERE `cqId`= $questionId");

        return redirect("/showQA")->with('success','Question Deleted');
    }




    function questionTake()
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


    function moduleShow(){
       // $module= DB::select("SELECT * from `module` where `isAvail`=0");
        $module= DB::select("SELECT * from `module` ");
        return $module;
    }


    function updateQuestionForm(){
        //take value curresponding to questionid
        $cqId=request('cqId');
        
        $allQuestions=
            (
            DB::select("SELECT a.* ,
            (SELECT `mId` FROM `sub_module` WHERE `smId`=(a.smId)) as mId,
            (SELECT `mName` FROM `module` WHERE `mId`=(SELECT `mId` FROM `sub_module`WHERE `smId`=(a.smId)))as mName,
            (SELECT `smName` FROM `sub_module` WHERE `smId`=(a.smId))as smName,
            b.`optA` as ansA,b.`optB` as ansB,b.`optC` as ansC,b.`optD` as ansD,a.question_level as level FROM `cooperation_question` as a JOIN `cooperation_answer` as b on a.`cqId`=`b`.`cqId`  where a.`cqId`=$cqId"));
        
     
            return view('admin/editQuestion',compact('allQuestions'));
        }



















        ////////////  draft -- main exam approving

        public function showdraftQuestions()
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
            return view('admin/draft_showQA',compact('module_view','question'));
        }
    
    
    
    
    
    
        public function mainExmquestionDraftUpdate(Request $Request )
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
    
    
            return redirect("/draftMainExam")->with('success','Question Updated');
    
        }


        public function deleteDraftQuestion($questionId)
        {
            DB::update("UPDATE `cooperation_question` SET `isAvail`='1' WHERE `cqId`=$questionId");
    
            DB::update("UPDATE `cooperation_answer` SET `isAvail`='1' WHERE `cqId`= $questionId");
    
            return redirect("/draftMainExam")->with('success','Question Deleted');
        }
    
    
    
    
        function questionDraftTake()
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
    
    
        function ModuleDraftshow(){
            //$module= DB::select("SELECT * from `module` where `isAvail`=0");
            $module= DB::select("SELECT * from `module` ");
            return $module;
        }
        function subdraftModuleCheck()
        {
           // $isAvail='0';
            $mid=request()->get('mid');
          //  $submodule_view = SubModuleModel::select()->where('mId',$mid)->where('isAvail',$isAvail)->get();
            $submodule_view = SubModuleModel::select()->where('mId',$mid)->get();
            //print_($submodule_view);
            return $submodule_view;
            //return view('question_add_form', compact('submodule_view'));
        }
    
    
        function updatedraftQuestionForm(){
            //take value curresponding to questionid
            $cqId=request('cqId');
            
            $allQuestions=
                (
                DB::select("SELECT a.* ,
                (SELECT `mId` FROM `sub_module` WHERE `smId`=(a.smId)) as mId,
                (SELECT `mName` FROM `module` WHERE `mId`=(SELECT `mId` FROM `sub_module`WHERE `smId`=(a.smId)))as mName,
                (SELECT `smName` FROM `sub_module` WHERE `smId`=(a.smId))as smName,
                b.`optA` as ansA,b.`optB` as ansB,b.`optC` as ansC,b.`optD` as ansD,a.question_level as level FROM `cooperation_question` as a JOIN `cooperation_answer` as b on a.`cqId`=`b`.`cqId`  where a.`cqId`=$cqId"));
            
         
                return view('admin/draft_edit_QA',compact('allQuestions'));
            }


            /// APPROVING
            public function MEapproving($questionId)
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
            public function MErefusing($questionId)
            {
            
                $question = QuestionModel::find($questionId);
                $answer = AnswerModel::find($questionId);
                
                $question->update(['isAvail' => 2]);
                $answer->update(['isAvail' => 2]);
        
        
                return redirect()->back()->with('success','Question Refused');
                
        
            }





















            //search module wise submodule show
            public function searchmodulewisesubmoduleshow(Request $request)
            {
                $searchValue = $request->input('selvalue');
            
                $users = DB::select("SELECT A.mName, A.mCode, B.smId, B.mId, B.smName, B.smCode, B.isAvail FROM module AS A
                    INNER JOIN sub_module AS B ON A.mId = B.mId 
                    WHERE B.mId = '$searchValue'
                    ORDER BY B.isAvail ASC");
            
                $output = [];
            
                $i = 1;
                foreach ($users as $item) {
                    $output[] = [
                        'slNo' => $i++,
                        'isAvail' => ($item->isAvail == 0) ? 'green' : 'red',
                        'moduleName' => wordwrap($item->mName, 20, "\n", true),
                        'subModuleCode' => $item->smCode,
                        'subModuleName' => wordwrap($item->smName, 20, "\n", true),
                        'editUrl' => url('updateSubModule'.$item->smId),
                        'deactivateUrl' => ($item->isAvail == 0) ? url('subModuleInactive/'.$item->smId) : '',
                        'activateUrl' => ($item->isAvail == 1) ? url('subModuleActive/'.$item->smId) : '',
                    ];
                }
            
                return response()->json($output);
            }
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            // LIVE GAMES
            public function showuserlivegamehist()
            {

             $live_game_mast = lgmasterModel::select('livegame_master.playerId', 'user_s.name')
                ->join('user_details as user_s', 'user_s.uId', '=', 'livegame_master.playerId')
                ->distinct()
                ->where('livegame_master.isAvail', 2)
                
                ->get();


                return view('live_games.single_live_hist',compact('live_game_mast'));
            }

             // HISTORY
            public function singleuserLG_History_view($playerId)
            {

                $user_name=user_detail_Model::select('name')
                ->where('uId','=',$playerId)
                ->get();

                $user_single_history = lghistoryModel::select('*', 'user_opponent.name as OpponentName','user_opponent.uId as OpponentId', 'user_winner.name as winnerName','lg_master.dateTime')
                ->join('livegame_master as lg_master', 'lg_master.lgmId', '=', 'livegame_history.lgmId')
                ->join('user_details as user_opponent', 'user_opponent.uId', '=', 'lg_master.opponentId')
                ->join('user_details as user_winner', 'user_winner.uId', '=', 'livegame_history.winnerId')
                ->where('livegame_history.userId', $playerId)
                ->get();



                return view('live_games.single_users_details_LG',compact('user_name','user_single_history'));
            }


            // AJAX TAKE OPPO-
            public function Opponent_details(Request $request)
            {
                $opponent_id= request('OpponentId');
                $opponent_lg_master= request('lgmId');

                $opponent_detais_base_mast=lghistoryModel::select('*', 'user_opponent.name as OpponentName','user_opponent.uId as OpponentId', 'user_winner.name as winnerName','lg_master.dateTime')
                ->join('livegame_master as lg_master', 'lg_master.lgmId', '=', 'livegame_history.lgmId')
                ->join('user_details as user_opponent', 'user_opponent.uId', '=', 'lg_master.opponentId')
                ->join('user_details as user_winner', 'user_winner.uId', '=', 'livegame_history.winnerId')
                ->where('livegame_history.userId', $opponent_id)
                ->where('livegame_history.lgmId', $opponent_lg_master)
                ->get();

               // print_r($opponent_detais_base_mast);die;
                return $opponent_detais_base_mast;

            }

            
            
            
            
            
            
            
            
            
            
            
            
            

      // sub module wise super admin question bank(entry)

      function submodulewisesupadmincheckingform()
      {
         // $isAvail='0';
         // $module_view = ModuleModel::select()->where('isAvail',$isAvail)->get();
          $module_view = ModuleModel::select()->get();
          return view('admin/view_filter_mainexamform', compact('module_view'));
      }

//      // ajax check submodule corresponded module
      function supadminsubModulewiseauthorizerCheck()
        {
           // $isAvail='0';
            $mid=request()->get('mid');
          //  $submodule_view = SubModuleModel::select()->where('mId',$mid)->where('isAvail',$isAvail)->get();
            $submodule_view = SubModuleModel::select()->where('mId',$mid)->get();
           
            return $submodule_view;
           
        }

//         //get sub module id and find that submodule corresponded data
//         //and author approving
        
        function submodulewisesupadminmainexam(Request $request)
        {
            $smodule = request('smodule');
            $smodule1 = $request->input('smodule');
        
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
            AND  a.`isAvail`=0
            AND b.`isAvail` =0
            AND d.`isAvail` IN (0,1)
            AND c.`isAvail` IN (0,1)
            ORDER BY b.cqId DESC;
            ");
        
        //  dd($question);
            return view('admin/view_filter_questions_sm',compact('question', 'smodule1'));
        }




//          ////////////  draft --submodule wise main exam approving



  public function mainExmsubmodulewisequestionsupadminupdateUpdate(Request $Request )
  {
      $cqId = request('cqId');
      $qCode = request('qCode');
      
      $mId = request('mId');
     // print_r($mId);die;
      
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

      $isAvail="0";
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


      return redirect("/submodulewiseqbmainexamad")
      ->with([
        'success' => 'Question Updated',
        'smid' =>$smId,
        'mid'  =>$mId
       
    ]); 
     // ->with('success','Question Updated');
      //return redirect()->back()->with('success','Question Updated');
     

  }


  public function deletesupadminmesubmodulewisemainexmQuestion($questionId)
  {
      DB::update("UPDATE `cooperation_question` SET `isAvail`='1' WHERE `cqId`=$questionId");

      DB::update("UPDATE `cooperation_answer` SET `isAvail`='1' WHERE `cqId`= $questionId");

     // return redirect("/submodulewisemainexm")->with('success','Question Deleted');
      return redirect()->back()->with('success','Question Deleted');
  }




  function questionsupadminsubmmainTake()
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


  function Modulesupadminsubmmainexmshow(){
     // $module= DB::select("SELECT * from `module` where `isAvail`=0");
      $module= DB::select("SELECT * from `module` ");
      return $module;
  }
  function subsubmodulewisemainexmModulesupadminCheck()
  {
     // $isAvail='0';
      $mid=request()->get('mid');
     // $submodule_view = SubModuleModel::select()->where('mId',$mid)->where('isAvail',$isAvail)->get();
      $submodule_view = SubModuleModel::select()->where('mId',$mid)->get();
      //print_($submodule_view);
      return $submodule_view;
      //return view('question_add_form', compact('submodule_view'));
  }


  function updatesupadminmesubmodulewisemainexmQuestionForm(){
      //take value curresponding to questionid
      $cqId=request('cqId');
      
      $allQuestions=
          (
          DB::select("SELECT a.* ,
          (SELECT `mId` FROM `sub_module` WHERE `smId`=(a.smId)) as mId,
          (SELECT `mName` FROM `module` WHERE `mId`=(SELECT `mId` FROM `sub_module`WHERE `smId`=(a.smId)))as mName,
          (SELECT `smName` FROM `sub_module` WHERE `smId`=(a.smId))as smName,
          b.`optA` as ansA,b.`optB` as ansB,b.`optC` as ansC,b.`optD` as ansD,a.question_level as level FROM `cooperation_question` as a JOIN `cooperation_answer` as b on a.`cqId`=`b`.`cqId`  where a.`cqId`=$cqId"));
      
   
          return view('admin/view_filter_edit_question',compact('allQuestions'));
      }

            
            
            
            
            
            
          
          
          
          
          
          
          
      

      // sub module wise super admin approving question bank(entry)

      function submodulewiseapproveqbmain()
      {
         // $isAvail='0';
         // $module_view = ModuleModel::select()->where('isAvail',$isAvail)->get();
          $module_view = ModuleModel::select()->get();
          return view('admin/submodulewise_checkform', compact('module_view'));
      }

     // ajax check submodule corresponded module
      function superadminsubModulewiseauthorizerCheck()
        {
           // $isAvail='0';
            $mid=request()->get('mid');
          //  $submodule_view = SubModuleModel::select()->where('mId',$mid)->where('isAvail',$isAvail)->get();
            $submodule_view = SubModuleModel::select()->where('mId',$mid)->get();
           
            return $submodule_view;
           
        }

//         //get sub module id and find that submodule corresponded data
//         //and author approving
        
        function submodulewisesuperadminapprovingdraftmainexam(Request $request)
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
            AND  a.`isAvail`=2
            AND b.`isAvail` =2
            AND d.`isAvail` IN (0,1)
            AND c.`isAvail` IN (0,1)
            ORDER BY b.cqId DESC;
            ");
        
        //  dd($question);
            return view('admin/view_submodulewisedraft',compact('question'));
        }




//          ////////////  draft --submodule wise main exam approving



  public function mainExmsubmodulewisesadminquestionDraftUpdate(Request $Request )
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


      return redirect("/submodulewiseapproveqbmain")->with('success','Question Updated');
      //return redirect()->back()->with('success','Question Updated');

  }


  public function deletesadminDraftsubmodulewisemainexmQuestion($questionId)
  {
      DB::update("UPDATE `cooperation_question` SET `isAvail`='1' WHERE `cqId`=$questionId");

      DB::update("UPDATE `cooperation_answer` SET `isAvail`='1' WHERE `cqId`= $questionId");

     // return redirect("/submodulewisemainexm")->with('success','Question Deleted');
      return redirect()->back()->with('success','Question Deleted');
  }




  function questionsadminsubmodulewisemainexmDraftTake()
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


  function ModulesadminsubmmainexmDraftshow(){
     // $module= DB::select("SELECT * from `module` where `isAvail`=0");
      $module= DB::select("SELECT * from `module`");
      return $module;
  }

  function subdraftsadminsubmodulewisemainexmModuleCheck()
  {
     // $isAvail='0';
      $mid=request()->get('mid');
     // $submodule_view = SubModuleModel::select()->where('mId',$mid)->where('isAvail',$isAvail)->get();
      $submodule_view = SubModuleModel::select()->where('mId',$mid)->get();
      //print_($submodule_view);
      return $submodule_view;
      //return view('question_add_form', compact('submodule_view'));
  }


  function updatesadmindraftsubmodulewisemainexmQuestionForm(){
      //take value curresponding to questionid
      $cqId=request('cqId');
      
      $allQuestions=
          (
          DB::select("SELECT a.* ,
          (SELECT `mId` FROM `sub_module` WHERE `smId`=(a.smId)) as mId,
          (SELECT `mName` FROM `module` WHERE `mId`=(SELECT `mId` FROM `sub_module`WHERE `smId`=(a.smId)))as mName,
          (SELECT `smName` FROM `sub_module` WHERE `smId`=(a.smId))as smName,
          b.`optA` as ansA,b.`optB` as ansB,b.`optC` as ansC,b.`optD` as ansD,a.question_level as level FROM `cooperation_question` as a JOIN `cooperation_answer` as b on a.`cqId`=`b`.`cqId`  where a.`cqId`=$cqId"));
      
   
          return view('admin/edit_submodulewisedraft',compact('allQuestions'));
      }


// // //       /// APPROVING
      public function MEsubmodulewisesadminmainexmapproving($questionId)
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

//       public function MEsubmodulewiseauthormainexamrefusing($questionId)
//       {
      
//           $question = QuestionModel::find($questionId);
//           $answer = AnswerModel::find($questionId);
          
//           $question->update(['isAvail' => 2]);
//           $answer->update(['isAvail' => 2]);
  
  
//           return redirect()->back()->with('success','Question Refused');
          
  
//       }


  

       
      // SUPER ADMIN CHAT

      public function showquestionsformAdmin()
      {
          $answer=chatQuestionsAnsModel::select()->get();
          $users_all_questions=DB::select("SELECT t2.mId,t2.mName,t3.uId,t3.name,t4.chatTypeId,t4.typeName,t5.*
          FROM `chat_questions_main` AS t5
         
          INNER JOIN `module`        AS t2   ON t2.mId=t5.mId
          INNER JOIN `user_details`  AS t3   ON t3.uId=t5.uId
          INNER JOIN `chat_type`     AS t4   ON t4.chatTypeId=t5.chatTypeId
          WHERE t5.assigned=1 AND t5.isClosed=0;");
          return view('admin.users_chat_show',compact('users_all_questions','answer'));
      }

      public function showsubchatquestionformainquest($chatQuestionId)
      {
          $user_name=DB::select("SELECT t5.chatQuestionId,t6.uId,t6.name,t6.userImage
          FROM `chat_questions_main` AS t5       
          INNER JOIN `user_details`  AS t6   ON t6.uId=t5.uId
                
          WHERE t5.chatQuestionId=$chatQuestionId");
         // print_r($answers_chat);die;
          $users_all_questions=DB::select("SELECT t6.chatQuestionId as quid,t6.chatDateTime as qtime ,t5.isClosed as isclosed,t5.uId as uid,t6.question as question,null AS answer,t6.created_at as chatorder
          FROM `chat_questions_main` AS t5       
          INNER JOIN `chat_questions_sub`  AS t6   ON t6.chatQuestionId=t5.chatQuestionId
                
          WHERE t5.chatQuestionId=$chatQuestionId
          
          UNION ALL
          
          SELECT  null as quid,null as qtime,null as isClosed,null as uId,null as question,t4.Answer as answer,t4.created_at as chatorder
          FROM `chat_questions_ans` AS t4      
          INNER JOIN `chat_questions_main`  AS t5   ON t5.chatQuestionId=t4.chatQuestionId
               
          WHERE t5.chatQuestionId=$chatQuestionId order by chatorder asc;");
          return view('admin.users_chat_single_show',compact('users_all_questions','user_name'));
  
        
      }

       //add answer
       public function addchatanswerquestion(Request $request)
       {
           $validatedData = $request->validate([
               'answer' => 'required'
           ], [
               'answer.required' => 'This field is required.'
           ]);
         
          $chatQuestionId= request('chatQuestionId');
          $createdBy=request('user_id');
          $answer=request('answer');
         // print_r($answerid);die;
   
           chatQuestionsAnsModel::create([
               'chatQuestionId'=>$chatQuestionId,
               'AssignedTo'=>'3',
               'Answer'=>$answer,
               'AssignedBy'=>'1',
               'created_by'=>$createdBy,
               
           ]);
      
         
     
           return redirect()->back()->with('success','Answer Added successfully');
             
     
       }

      
     // EXCEL AREA 
       //MAIN EXAM
       public function excelgetmainexamdwnld(){
    
        $data=DB::select("SELECT 
                        a.qcode as questionCode,
                        d.mName as moduleName,
                        c.smName as subModuleName,
                        a.question,
                        a.optA as optionA,
                        a.optB as optionB,
                        a.optC as optionC,
                        a.optD as optionD,
                    CASE
                        WHEN b.optA = 1 THEN a.optA
                        WHEN b.optB = 1 THEN a.optB
                        WHEN b.optC = 1 THEN a.optC
                        WHEN b.optD = 1 THEN a.optD
                    END AS answer
                    FROM `cooperation_question` as a 
                    JOIN `sub_module` as c ON c.smId = a.smId
                    JOIN `module` as d ON c.mId = d.mId
                    JOIN `cooperation_answer` as b ON a.cqId = b.cqId
                    WHERE a.isAvail = 0 
                    AND d.isAvail IN (0, 1)
                    AND c.isAvail IN (0, 1);");
    
                    return $data;
    
       }

            
    // EXCEL FILTERED MAIN EXAM
    public function excelgetFilteredmainexamdwnld(Request $request){
           $smId = request('smId');
           $data=DB::select("SELECT 
           a.qcode as questionCode,
           d.mName as moduleName,
           c.smName as subModuleName,
           a.question,
           a.optA as optionA,
           a.optB as optionB,
           a.optC as optionC,
           a.optD as optionD,
       CASE
           WHEN b.optA = 1 THEN a.optA
           WHEN b.optB = 1 THEN a.optB
           WHEN b.optC = 1 THEN a.optC
           WHEN b.optD = 1 THEN a.optD
       END AS answer
       FROM `cooperation_question` as a 
       JOIN `sub_module` as c ON c.smId = a.smId
       JOIN `module` as d ON c.mId = d.mId
       JOIN `cooperation_answer` as b ON a.cqId = b.cqId
       WHERE c.smId='$smId'
       AND a.isAvail = 0 
       AND d.isAvail IN (0, 1)
       AND c.isAvail IN (0, 1);");

       return $data;

      }
            
            
            
            
            
            
            
            


}