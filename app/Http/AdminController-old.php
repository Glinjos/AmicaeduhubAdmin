<?php
/**
 * Created by PhpStorm.
 * User: SHAZIN
 * Date: 07-02-2023
 * Time: 21:47
 */
namespace App\Http\Controllers;

use Illuminate\Routing\Controller;

use Illuminate\Http\Request;
use App\Models\ModuleModel;

use DB;
use App\Models\SubModel;
use App\Models\InsertSubModel;
use App\Models\UpdateSubModuleModel;
use App\Models\GetModel;
use App\Models\SubModuleModel;
use App\Models\QuestionModel;
use App\Models\AnswerModel;
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

        // $this->api = "http://localhost/api/";
        /*$this->api = "http://192.168.1.43/glchits/api/";*/
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
            'ModuleCode' => 'required|regex:/^[A-Za-z]+$/|min:3|max:5',
            'ModuleName' => 'required|regex:/^[\pL\s]+$/u|min:3|max:50',

        ], [
            'ModuleCode.required' => 'Module code field is required.',
            'ModuleName.required' => 'Module name field is required.',
        ]);

        $createdBy='1';
        $updatedBy='1';

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

            return redirect()->back()->with('error','Module Code Already Exist');
        }elseif ($module2 != null) {

            return redirect()->back()->with('error','Module Name Already Exist');
        } else {
            $module = new ModuleModel();
            $module->mCode = $mCode;
            $module->mName = $mName;
            $module->created_by = $createdBy;
            $module->created_at = $createdAt;
            $module->updated_by = $updatedBy;

            $module->save();
            return redirect()->back()->with('status','Module Added');
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

            return redirect("/")->with('status','Module Updated');
        }

    }

    public function disableModule($mId)
    {
        $isAvail=1;
        $module = ModuleModel::where('mId',$mId)->update(['isAvail'=>$isAvail]);
        SubModuleModel::where('mId',$mId)->update(['isAvail'=>$isAvail]);

        return redirect()->back()->with('error','Deactivated');
    }

    public function EnableModule($mId)
    {
        $isAvail=0;
        $module = ModuleModel::where('mId',$mId)->update(['isAvail'=>$isAvail]);
        SubModuleModel::where('mId',$mId)->update(['isAvail'=>$isAvail]);

        return redirect()->back()->with('status','Activated');
    }

///////////////////////*ends here*///////////////////////////

    public function index()
    {
        // $select1=InsertSubModel::select()->get();
        //  print_r($select);die();
        // return view('submodule', compact('select1'));
        $select1 =SubModel::select()->get();
        $select=DB:: select("SELECT A.mName,A.mCode,B.smId,B.mId,B.smName,B.smCode,B.isAvail FROM module AS A INNER JOIN sub_module as B ON A.mId=B.mId ORDER BY B.isAvail=1");
        return view('admin/submodule', compact('select','select1'));

    }


    // CONTROLLER FOR add data to submodule db
    public function addsub(Request $request)
    {
        $validatedData = $request->validate([
            'submcode' => 'required|regex:/^[A-Za-z0-9]+$/|min:4|max:9',
            'submodule' => 'required|regex:/^[\pL\s]+$/u|min:3|max:50',

        ], [
            'submcode.required' => 'Module code field is required.',
            'submodule.required' => 'Sub Module name field is required.',
        ]);


        $createdBy='1';                                                      //FROM SESSION
        $updatedBy='1';                                                      //FROM SESSION
        $currentCode='1000';
        $isAvail='0';
        // $createdAt= $this->currentDateTime;

        $mid =request('mid');
        $smCode = request('submcode');
        $smCode=preg_replace('/\s+/', ' ', $smCode);
        $smCode=strtoupper($smCode);

        $smName = request('submodule');
        $smName=preg_replace('/\s+/', ' ', $smName);
        $smName=ucwords($smName);

        $module = SubModuleModel::Where('smName',$request->subm)->where('isAvail',$isAvail)->first();
        if ($module != null) {
            return redirect()->back()->with('error','Module Already Exists');
        }
        else
        {
            $module = new InsertSubModel();
            $module->mId = $mid;
            $module->smCode = $smCode;
            $module->smName = $smName;
            $module->currentCode = $currentCode;
            $module->created_by = $createdBy;
            $module->save();
            return redirect()->back()->with('status','Sub Module Added Successfully');
        }
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
        $isAvail='0';
        $module_view = GetModel::select()->where('isAvail',$isAvail)->get();
        return view('admin/question_add_form', compact('module_view'));
    }

    function subModuleCheck()
    {
        $isAvail='0';
        $mid=request()->get('mid');
        $submodule_view = SubModuleModel::select()->where('mId',$mid)->where('isAvail',$isAvail)->get();
        //print_($submodule_view);
        return $submodule_view;
        //return view('question_add_form', compact('submodule_view'));
    }


    /////created by akshay
    public function updateSubModuleForm($smId)
    {
        $subModule = UpdateSubModuleModel::select('smId','mId','smCode','smName')->where('smId',$smId)->get();

        return view('admin/updateSubModule', compact('subModule'));

    }

    public function updateSubModule(Request $request,$smId)
    {

        $validatedData = $request->validate([
            'smName' => 'required|regex:/^[\pL\s\?]+$/u|min:3|max:40',

        ], [
            'smName.required' => 'Sub Module name field is required.',
        ]);


        $updatedBy='1';
        $updatedAt= $this->currentDateTime;


        $smName = $request['smName'];
        // dd($smName);
        $smName=preg_replace('/\s+/', ' ', $smName);
        $smName=ucwords($smName);

        $subModule = UpdateSubModuleModel::find($smId);

        $subModule->update([
            'smId'=>$smId,
            'smName' =>  $smName,
            'updated_by'=> $updatedBy,
            'updated_at'=>$updatedAt
        ]);

        return redirect("/toSubmodule")->with('status','Sub Module Updated Successfully');

    }

    public function subModuleInactive($smId)
    {
        $isAvail='1';
        $subModule = UpdateSubModuleModel::find($smId);

        $subModule->update([
            'smId'=>$smId,
            'isAvail' => $isAvail,
        ]);
        return redirect()->back()->with('status','Sub Module inactive Successfully');
    }
    public function subModuleActive($smId)
    {
        $isAvail='0';
        $subModule = UpdateSubModuleModel::find($smId);

        $subModule->update([
            'smId'=>$smId,
            'isAvail' => $isAvail,
        ]);
        return redirect()->back()->with('status','Sub Module Activeted Successfully');
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

        $smid = request('smodule');
        $question = request('question');
        $option1 = request('option1');
        $option2 = request('option2');
        $option3 = request('option3');
        $option4 = request('option4');
        $answer = request('answer');

        $created_by = "1";
        $updated_by = "1";

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
            'created_by'=>$created_by,
            'updated_by'=>$updated_by
        ]);

//update CURRENT CODE AND UPDATED BY INTO SUBMODULE

        DB::update("UPDATE `sub_module` SET `currentCode` = $qCode ,`updated_by`= $updated_by where `smId`=$smid");

        return redirect()->back()->with('message','Question Added Successfully');
    }
    /* public function viewQA()
     {

         $qaquery=(DB::select("
        SELECT
         `cqId` as `questionId`,
         `smId` as `submoduleId`,
         (SELECT `mId` FROM `module` WHERE `mId`=(SELECT DISTINCT `mId` FROM `sub_module` WHERE `smId`=`submoduleId`)) AS `moduleId`,
         (SELECT `smName` FROM `sub_module` WHERE `smId`=`submoduleId`) as `submoduleName`,
         (SELECT `mName` FROM `module` WHERE `mId`=(SELECT DISTINCT `mId` FROM `sub_module` WHERE `smId`=`submoduleId`) )as `moduleName`,
         `qCode`, `question`, `optA`, `optB`, `optC`, `optD`
         FROM `cooperation_question` ORDER BY `moduleId`
         "));
 /*        print_r($qaquery); die();*/

    //return view('admin/questionView',compact('qaquery'));
    //   }*/

    //CREATED BY ANEES NK
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
                                AND d.`isAvail`=0
                                AND c.`isAvail`=0");
        return view('admin/questionShow',compact('module_view','question'));
    }






    public function questionUpdate(Request $Request )
    {
        $cqId = request('cqId');
        $qCode = request('qCode');

        $smIdfrominput = request('smId');
        $smIdfromdropdown = request('showsubmoduledropdown');
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
        // print_r($smId);die();

        $updated_by = "1";                  /////////////from SESSION VALUE
        $updated_at="2023-02-12 20:15:27";   /////////////from date

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
            'updated_at'=>$updated_at,
            'updated_by'=>$updated_by
        ]);
        //UPDATE ANSWER TO ANSWERS TABLE
        DB::update("UPDATE `cooperation_answer` SET `optA`=$value1,`optB`=$value2,`optC`=$value3,`optD`=$value4,`updated_by`=$updated_by WHERE `cqId`=$cqId");
//        $ansmodule = AnswerModel::find($cqId);
//        $ansmodule->update([
//            'optA'=> $value1,
//            'optB'=> $value2,
//            'optC'=> $value3,
//            'optD'=> $value4,
//            'updated_by'=>$updated_by,
//        ]);
        return redirect("/showQA")->with('success','Updated Succesfully');

    }
    public function deleteQuestion($questionId)
    {
        DB::update("UPDATE `cooperation_question` SET `isAvail`='1' WHERE `cqId`=$questionId");

        DB::update("UPDATE `cooperation_answer` SET `isAvail`='1' WHERE `cqId`= $questionId");

        return redirect("/showQA")->with('success','Question Deleted Successfully');
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
        $module= DB::select("SELECT * from `module` where `isAvail`=0");
        return $module;
    }


}