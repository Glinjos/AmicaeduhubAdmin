<?php

/**
 * Created by vsCode.
 * Use: Video Class
 * Conducting classes or educational
 * sessions using video format. 
 * User Attendance for Exams: Tracking user
 * participation and attendance for exams.
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;

use App\Models\pqmainModel;
use App\Models\VideoClassesModels\vcmoduleModel;
use App\Models\VideoClassesModels\vcchapterModel;
use App\Models\VideoClassesModels\vcexamModel;
use App\Models\VideoClassesModels\vcansModel;
use App\Models\VideoClassesModels\vcmoreVideoModel;

use Illuminate\Support\Facades\Crypt;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Session;

class videoclassController extends Controller
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


    //ADD MODULE
    function vcmoduleformamica()
    {
        
       // $select1 =pqmainModel::select('pqmainId','pqmainName')->where('isAvail','=','0')->get();
    //    $select2=DB:: select("SELECT A.pqmainId, A.pqmainName, B.vcmId, B.vcmName, B.isAvail
    //     FROM pq_main AS A
    //     INNER JOIN vc_module AS B ON A.pqmainId = B.pqmainId
    //     ORDER BY B.isAvail ASC, B.vcmId DESC;");
            $select2 = vcmoduleModel::select('vcmId', 'vcmName', 'isAvail')
            ->orderBy('isAvail', 'ASC')
            ->orderBy('vcmId', 'DESC')
            ->get();

       
        
       
       
    return view('video_class.add_vc_module',compact('select2'));
    }

    function addvcmoduleamica(Request $request)
    {
       // print_r("hai");die;
        $validatedData = $request->validate([
            'subjectName' => 'required|min:2|max:50',
           // 'examType' => 'required',

        ], [
            'subjectName.required' => 'This field is required.',
            //'examType.required' => 'This field is required.',
        ]);

        $createdBy=$request['user_id'];
        $updatedBy='0';

        

        $createdAt= $this->currentDateTime;

        //$pqmainId=$request['examType'];

        

        $vcmName = $request['subjectName'];
        $vcmName=preg_replace('/\s+/', ' ', $vcmName);
        $vcmName=strtoupper($vcmName);

        
        $vcmodule2 = vcmoduleModel::where('vcmName', $request->subjectName)
                                   ->first();
                          // ->where('pqmainId',$request->examType)
                          


        if ($vcmodule2 != null) {
            return redirect()->back()->with('error','Subject Name Already Exists');
        } else {
           // print_r("hai");die;
           
            $vcmodule = new vcmoduleModel();
           // $vcmodule->pqmainId = $pqmainId;
            $vcmodule->vcmName = $vcmName;
            $vcmodule->created_by = $createdBy;
            $vcmodule->created_at = $createdAt;
            $vcmodule->updated_by = $updatedBy;

           
            $vcmodule->save();
            return redirect()->back()->with('success','Subject Added');
            
        }
    }

    //AJAX USED TO CHECKING SUBJECT NAME
    function ajaxvcNamecheck()
    {
        $vcmName=request()->get('vcmName');
       // $pqmainId=request()->get('pqmainId');
        $vcmodule=DB::select("SELECT vcmId, vcmName 
        FROM vc_module 
        WHERE vcmName = '$vcmName'
        
        ");
        return $vcmodule;
    }

    function ajaxvcUpdateNamecheck()
    {
        $vcmId=request()->get('vcmId');
        $vcmName=request()->get('vcmName');
       // $pqmainId=request()->get('pqmainId');
    
        $vcmodule = DB::table('vc_module')
        ->select('vcmId','vcmName')
       // ->where('pqmainId', $pqmainId)
        ->where('vcmName', $vcmName)
        ->where('vcmId', '!=', $vcmId)
        ->get();
        return $vcmodule;
    }

    ///EDIT THE TABLE
    function updatesubjectForm($vcmId)
    {
        $subject = vcmoduleModel::select('vcmId','vcmName')->where('vcmId',$vcmId)->get();
        return view('video_class/edit_vc_module', compact('subject'));
    }
    
    function subjectEditData(Request $request,$vcmId)
    {
        $validatedData = $request->validate([
            'subjectName' => 'required|min:2|max:50'],
            ['subjectName.required' => 'subject name field is required.']);

        $updatedBy=$request['user_id'];
        $updatedAt= $this->currentDateTime;

       // $pqmainId = $request['pqmainId'];

        $vcmName = $request['subjectName'];
        $vcmName=preg_replace('/\s+/', ' ', $vcmName);
        $vcmName=strtoupper($vcmName);

        //$module2=DB::select("SELECT * FROM `vc_module` WHERE `vcmId` NOT IN ($vcmId) AND (`vcmName`='$vcmName')");
        $module2 = vcmoduleModel::where('vcmName', $request->subjectName)
       // ->where('pqmainId',$request->pqmainId)
        ->where('vcmId','!=',$request->vcmId)
        ->first();

         if($module2 != null ) {
            return redirect()->back()->with('error','subject Name Already Exists');
        } else {
             $category = vcmoduleModel::find($vcmId);

             $category->update([
                'vcmId'=>$vcmId,
                'vcmName' =>  $vcmName,
                'updated_by'=> $updatedBy,
                'updated_at'=>$updatedAt
            ]);
            return redirect("/vcmoduleform")->with('success','subject Updated');
        }
    }

   


    public function disablesubject($vcmId)
    {
       $isAvail=1;
        vcmoduleModel::where('vcmId',$vcmId)->update(['isAvail'=>$isAvail]);
        vcchapterModel::where('vcmId',$vcmId)->update(['isAvail'=>$isAvail]);

        $selectVCCHAPmId=(DB::select("SELECT `vcChapterId` FROM `vc_chapters` WHERE `vcmId`='$vcmId'"));

       // print_r($selectVCCHAPmId);die;

        foreach($selectVCCHAPmId as $row)
        {
            $vcChapterId = $row->vcChapterId;

            vcmoreVideoModel::where('vcChapterId',$vcChapterId)->update(['isPublished'=>$isAvail]);
            $vcvdeoId=(DB::select("SELECT `vcVDId` FROM `vc_more_videos` WHERE `vcChapterId`='$vcChapterId'"));

            foreach($vcvdeoId as $row)
            {
                $vcVDIds = $row->vcVDId;
                vcexamModel::where('vcVDId',$vcVDIds)->update(['isAvail'=>$isAvail]);
            }

           
            $selectVCId=(DB::select("SELECT `vcExamId` FROM `vc_exams` WHERE `vcVDId`='$vcVDIds'"));
            foreach($selectVCId as $row)
            {
                $vcExamId = $row->vcExamId;
                vcansModel::where('vcExamId',$vcExamId)->update(['isAvail'=>$isAvail]);
            }
        }

        return redirect()->back()->with('success','Subject Deactivated');
    }

    public function EnableSubject($vcmId)
    {
        $isAvail=0;
        vcmoduleModel::where('vcmId',$vcmId)->update(['isAvail'=>$isAvail]);
        vcchapterModel::where('vcmId',$vcmId)->update(['isAvail'=>$isAvail]);

        $selectVCCHAPmId=(DB::select("SELECT `vcChapterId` FROM `vc_chapters` WHERE `vcmId`='$vcmId'"));

       // print_r($selectVCCHAPmId);die;

        foreach($selectVCCHAPmId as $row)
        {
            $vcChapterId = $row->vcChapterId;

            vcmoreVideoModel::where('vcChapterId',$vcChapterId)->update(['isPublished'=>$isAvail]);
            $vcvdeoId=(DB::select("SELECT `vcVDId` FROM `vc_more_videos` WHERE `vcChapterId`='$vcChapterId'"));

            foreach($vcvdeoId as $row)
            {
                $vcVDIds = $row->vcVDId;
                vcexamModel::where('vcVDId',$vcVDIds)->update(['isAvail'=>$isAvail]);
            }

           
            $selectVCId=(DB::select("SELECT `vcExamId` FROM `vc_exams` WHERE `vcVDId`='$vcVDIds'"));
            foreach($selectVCId as $row)
            {
                $vcExamId = $row->vcExamId;
                vcansModel::where('vcExamId',$vcExamId)->update(['isAvail'=>$isAvail]);
            }
        }

        return redirect()->back()->with('success','Subject Activated');
    }

    //delete subject
    function subjectDelete($vcmId)
    {
        $subject=vcmoduleModel::find($vcmId);
        $subject->delete($vcmId);

        $selectVCCHApmId=(DB::select("SELECT `vcChapterId` FROM `vc_chapters` WHERE `vcmId`='$vcmId'"));

        foreach($selectVCCHApmId as $row) {
            $vcChapterId = $row->vcChapterId;
            $Chapter = vcchapterModel::find($vcChapterId);
            $Chapter->delete($vcChapterId);



            $selectVCQId = (DB::select("SELECT `vcExamId` FROM `vc_exams` WHERE `vcChapterId`='$vcChapterId'"));
            foreach ($selectVCQId as $row) {
                $vcExamId = $row->vcExamId;
                $VCQuestions = vcexamModel::find($vcExamId);
                $VCQuestions->delete($vcExamId);

                $selectVCAId = (DB::select("SELECT `vcAnswerId` FROM `vc_exam_ans` WHERE `vcExamId`='$vcExamId'"));
                foreach ($selectVCAId as $row) {
                    $vcAnswerId = $row->vcAnswerId;
                    $VCAnswers = vcansModel::find($vcAnswerId);
                    $VCAnswers->delete($vcAnswerId);
                }
            }
        }
        return redirect()->back()->with('success','Subject Deleted');
    }



  /// VIDEO CLASS CHAPTER HEREEE


    function vcchapterformamica()
    {
       // $select3 =pqmainModel::select('pqmainId','pqmainName')->where('isAvail','=','0')->get();
       // $select1 =vcmoduleModel::select()->orderBy('isAvail', 'ASC')->where('isAvail','0')->get();
        $select1 =vcmoduleModel::select()->orderBy('isAvail', 'ASC')->orderBy('vcmName', 'ASC')->get();
        $select=DB:: select("SELECT A.vcmId, A.vcmName, B.vcChapterId, B.vcmId, B.vcChapterName,B.isAvail
        FROM vc_module AS A
        INNER JOIN vc_chapters AS B ON A.vcmId = B.vcmId    
        ORDER BY B.isAvail ASC");
        return view('video_class/add_vc_chapter',compact('select','select1'));
    }

    // AJAX CHECKING CHAPTERS
    function chapterAjaxNameCheck()
    {
        $vcChapterName=request('vcChapterName');
        $vcmId=request('vcmId');
        $isAvail=0;

        //$submodule=DB::select("SELECT * FROM `pq_submodule` WHERE `pqsmName`='$pqsmName'");
        $submodule=DB::select("SELECT vcChapterId, vcmId, vcChapterName 
        FROM vc_chapters 
        WHERE vcmId = '$vcmId' 
        AND vcChapterName = '$vcChapterName'
        ");

        return $submodule;

    }

    function vcModuleCheckformain()
    {

        $pqmainid=request()->get('pqmainId');
        $pq_submodule_view = vcmoduleModel::select()->where('pqmainId',$pqmainid)->where('isAvail','0')->get();
        return $pq_submodule_view;
    }

    public function addvcchapteramica(Request $request)
    {
        $validatedData = $request->validate([
            'chapter' => 'required|min:3|max:100',

        ], [
            'chapter.required' => 'This field is required.',
        ]);


        $createdBy=request('user_id');  
                                                           //FROM SESSION

        //FROM SESSION
        // $createdAt= $this->currentDateTime;
        //$pqmainId=request('examtype');
         
        //print_r($pqmainId);die;
        $vcmId =request('module');
        

        $chapter = request('chapter');
       // $chapterVideo=request('chapterVideo');
       // $chapterDescription=request('chapterDescription');
       
        $chapter=preg_replace('/\s+/', ' ', $chapter);
        $chapter=ucwords($chapter);

       
        $vcChapterName = vcchapterModel::where('vcChapterName', $request->chapter)
                           ->where('vcmId',$request->module)
                           ->first();



        if ($vcChapterName != null) {
            return redirect()->back()->with('error','Chapter is Already Exists');
        }
        else
        {
            $vcchapterName = new vcchapterModel();
            $vcchapterName->vcmId = $vcmId;
           
            $vcchapterName->vcChapterName = $chapter;
           // $vcchapterName->vcChapterVideo=$chapterVideo;
           // $vcchapterName->vcChapterDescription=$chapterDescription;
            $vcchapterName->created_by = $createdBy;
            $vcchapterName->save();
            
            return redirect()->back()->with([
                'success' => 'Chapter Added',
                'vcmId' => $vcmId,
                //'pqmainid' =>$pqmainId
            ]); 
        }
    }




    function updatevcchapterForm($vcChapterId)
    {
        $chapter = vcchapterModel::select('vcChapterId','vcmId','vcChapterName')->where('vcChapterId',$vcChapterId)->get();
        return view('video_class/updatechapter', compact('chapter'));
    }

    function chapterUdateAjNameCheck()
    {
        $vcChapterName = request('vcChapterName');
        $vcmId = request('vcmId');
        $vcChapterId = request('vcChapterId');

        $submodule = DB::table('vc_chapters')
            ->select('vcChapterId', 'vcmId', 'vcChapterName')
            ->where('vcmId', $vcmId)
            ->where('vcChapterName', $vcChapterName)
            ->where('vcChapterId', '!=', $vcChapterId)
            ->get();

        return $submodule;
    }


    public function chapterUpdateData(Request $request,$vcChapterId)
    {
        $validatedData = $request->validate([
            'chapter' => 'required|min:3|max:100',
           // 'chapterVideo' => 'required',
           // 'chapterDescription' => 'required',

        ], [
            'chapter.required' => 'This field is required.',
           // 'chapterVideo.required' => 'This field is required',
           /// 'chapterDescription.required' => 'This field is required',
        ]);


        $updatedBy=$request['user_id'];
        $updatedAt= $this->currentDateTime;


        $vcmId=$request['vcmId'];
        $vcChapterId=$request['vcChapterId'];
        $chapter = $request['chapter'];
       // $vcChapterVideo = $request['chapterVideo'];
       // $vcChapterDescription = $request['chapterDescription'];
        // dd($smName);
        $chapter=preg_replace('/\s+/', ' ', $chapter);
        $chapter=ucwords($chapter);

        //$subcategory=DB::select("SELECT * FROM `pq_submodule` WHERE `pqsmId` NOT IN ($pqsmId) AND (`pqsmName`='$pqsmName')");
        $subcategory = vcchapterModel::where('vcChapterName', $request->chapter)
        ->where('vcmId',$request->vcmId)
        ->where('vcChapterId','!=',$request->vcChapterId)
        ->first();

        if($subcategory != null ) {
            return redirect()->back()->with('error','Chapter is  Already Exists');
        } else {

            $subcategory = vcchapterModel::find($vcChapterId);

            $subcategory->update([
                'vcChapterId' => $vcChapterId,
                'vcChapterName' => $chapter,
                'updated_by' => $updatedBy,
                'updated_at' => $updatedAt
            ]);
            return redirect("/vcchapterform")->with('success', 'Chapter Updated');
        }

    }

    function deletechapter($vcChapterId)
    {
        $chapter=vcchapterModel::find($vcChapterId);
        $chapter->delete($vcChapterId);

        $chapterVideomore=vcmoreVideoModel::where('vcChapterId',$vcChapterId)->delete();

        $selectvcVDId=(DB::select("SELECT `vcVDId` FROM `vc_more_videos` WHERE `vcChapterId`='$vcChapterId'"));
        foreach($selectvcVDId as $row)
        {
            $vcVDId = $row->vcVDId;
            $VCQuestions = vcexamModel::find($vcVDId);
            $VCQuestions->delete($vcVDId);

            $selectVCQId=(DB::select("SELECT `vcExamId` FROM `vc_exams` WHERE `vcVDId`='$vcVDId'"));
            foreach($selectVCQId as $row)
            {
                $vcExamId = $row->vcExamId;
                $VCAnswers = vcansModel::find($vcExamId);
                $VCAnswers->delete($vcExamId);
            }
        }

        return redirect("/vcchapterform")->with('success','Chapter Deleted');
    }


    public function disablechapter($vcChapterId)
    {
        $isAvail=1;
        vcchapterModel::where('vcChapterId',$vcChapterId)->update(['isAvail'=>$isAvail]);
        vcmoreVideoModel::where('vcChapterId',$vcChapterId)->update(['isPublished'=>$isAvail]);

        $selectvcVDId=(DB::select("SELECT `vcVDId` FROM `vc_more_videos` WHERE `vcChapterId`='$vcChapterId'"));
        foreach($selectvcVDId as $row)
        {
            $vcVDId = $row->vcVDId;
            vcexamModel::where('vcVDId',$vcVDId)->update(['isAvail'=>$isAvail]);
            $selectVCQId=(DB::select("SELECT `vcExamId` FROM `vc_exams` WHERE `vcVDId`='$vcVDId'"));
            foreach($selectVCQId as $row)
            {
                $vcExamId = $row->vcExamId;
                vcansModel::where('vcExamId',$vcExamId)->update(['isAvail'=>$isAvail]);
            }
        }
           
           
        return redirect()->back()->with('success','Chapter Deactivated');
    }

    public function Enablechapter($vcChapterId)
    {
        $isAvail=0;
        $autherApprove=2;
        vcchapterModel::where('vcChapterId',$vcChapterId)->update(['isAvail'=>$isAvail]);
        vcmoreVideoModel::where('vcChapterId',$vcChapterId)->update(['isPublished'=>$isAvail]);

        $selectvcVDId=(DB::select("SELECT `vcVDId` FROM `vc_more_videos` WHERE `vcChapterId`='$vcChapterId'"));
        foreach($selectvcVDId as $row)
        {
            $vcVDId = $row->vcVDId;
            vcexamModel::where('vcVDId',$vcVDId)->update(['isAvail'=>$autherApprove]);
            $selectVCQId=(DB::select("SELECT `vcExamId` FROM `vc_exams` WHERE `vcVDId`='$vcVDId'"));
            foreach($selectVCQId as $row)
            {
                $vcExamId = $row->vcExamId;
                vcansModel::where('vcExamId',$vcExamId)->update(['isAvail'=>$autherApprove]);
            }
        }

        return redirect()->back()->with('success','Chapter Activated');
    }




    // ADDING EXAM QUESTIONS----------------------------------------------------------------------------------
   //--------------------------------------------------------------------------------------------------------
  //--------------------------------------------------------------------------------------------------------


    function vcAddExamForm()
    {

       // $select3 =pqmainModel::select('pqmainId','pqmainName')->where('isAvail','=','0')->get();
      //  $categoryView = vcmoduleModel::select()->orderBy('isAvail', 'ASC')->where('isAvail','0')->get();
        $categoryView = vcmoduleModel::select()->orderBy('isAvail', 'ASC')->orderBy('vcmName', 'ASC')->get();
       
        return view('video_class/add_examQ',compact('categoryView'));
    }

    function vcModuleCheckformaindtaa()
    {

        $pqmainid=request()->get('pqmainId');
        $pq_submodule_view = vcmoduleModel::select()->where('pqmainId',$pqmainid)->where('isAvail','0')->get();
        return $pq_submodule_view;
    }

    function vcChaptersCheck()
    {

        $vcmid=request()->get('vcmid');
       // $pq_submodule_view = vcchapterModel::select()->where('vcmId',$vcmid)->where('isAvail','0')->get();
        $pq_submodule_view = vcchapterModel::select()->where('vcmId',$vcmid)->orderBy('vcChapterName', 'ASC')->get();
        return $pq_submodule_view;
    }
    function videomoreCheck()
    {

        $vcChapterId=request()->get('vcChapterId');
      //  $vc_morevideo_view = vcmoreVideoModel::select()->where('vcChapterId',$vcChapterId)->where('isPublished','0')->get();
        $vc_morevideo_view = vcmoreVideoModel::select()->where('vcChapterId',$vcChapterId)->orderBy('videoHeading', 'ASC')->get();
        return $vc_morevideo_view;
    }

    public function postvdeoClsQues(Request $Request)
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
        $isAvail="2";
        //print_r($videoId);die;
        // print_r($pqsmid);die();

        $question = request('question');
        $option1 = request('option1');
        $option2 = request('option2');
        $option3 = request('option3');
        $option4 = request('option4');
        $answer = request('answer');

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
    public function showVCQA()
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
        return view('video_class/show_QA',compact('module_view','question'));
    }

    function vCquestionTake()
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

   
    public function deleteVCQuestion($questionId)
    {
        $question=vcexamModel::where('vcExamId',$questionId);
        $question->update(['isAvail' => 1]);
        $answer=vcansModel::where('vcExamId',$questionId);
        $answer->update(['isAvail' => 1]);
        return redirect("/vcshowexam")->with('success','Question Deleted');
       
        
        
        
    }

    //---------------------------------Update Exam Start Here--------------------------------------
     //------------------------------------------------------------------------------------------------------
      //------------------------------------------------------------------------------------------------------

    function updateVideoClassForm()
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
    //    SELECT t2.*, t3.*, t4.*, b.`optionA` as ansA, b.`optionB` as ansB, b.`optionC` as ansC, b.`optionD` as ansD
    //    FROM `vc_exams` t4
    //    INNER JOIN `vc_chapters` t3 ON t4.vcChapterId = t3.vcChapterId
    //    INNER JOIN `vc_module` t2 ON t3.vcmId = t2.vcmId
    //    INNER JOIN `vc_exam_ans` b ON t4.`vcExamId` = b.`vcExamId`
    //    WHERE t4.`vcExamId` = $questionId
   
   return view('video_class/edit_vc_question', compact('allVcQuestions'));
   
    }


    public function VcquestionUpdate(Request $request)
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

        $vcexam = vcexamModel::find($vcExamId);
        //print_r($pqId);die;

        $vcexam->update([
            'vcVDId' =>  $vcVDId,
            'question'=>$question,
            'optionA'=> $option1,
            'optionB'=> $option2,
            'optionC'=> $option3,
            'optionD'=> $option4,
            'isAvail'=> $isAvail,
            'updated_at'=>$updated_at,
            'updated_by'=>$updated_by]);
        //UPDATE ANSWER TO ANSWERS TABLE
        DB::update("UPDATE `vc_exam_ans` SET `optionA`=$value1,`optionB`=$value2,`optionC`=$value3,`optionD`=$value4,`isAvail`=$isAvail,`updated_by`=$updated_by WHERE `vcExamId`=$vcExamId");

        return redirect("/vcshowexam")->with('success','Question Updated');
    }
   
    //------------------------------------------------------------------------------------------------------
     //------------------------------------------------------------------------------------------------------
      //------------------------------------------------------------------------------------------------------
    function subjectshow(){
      //  $category= DB::select("SELECT * from `vc_module` where `isAvail`=0");
        $category= DB::select("SELECT * from `vc_module` ");
        return $category;
    }

    function chaptershow()
    {
        $vcmId=request()->get('vcmId');
       // $subcategory = vcchapterModel::select()->where('vcmId',$vcmId)->where('isAvail','0')->get();
        $subcategory = vcchapterModel::select()->where('vcmId',$vcmId)->get();
        return $subcategory;
    }
    function morevideocheck()
    {
        $vcChapterId=request()->get('vcChapterId');
       // $morevideo = vcmoreVideoModel::select()->where('vcChapterId',$vcChapterId)->where('isPublished','0')->get();
        $morevideo = vcmoreVideoModel::select()->where('vcChapterId',$vcChapterId)->get();
        return $morevideo;
    }
     //------------------------------------------------------------------------------------------------------
      //------------------------------------------------------------------------------------------------------
       //------------------------------------------------------------------------------------------------------



    ////// ADD MORE VIDEOS------------

    function addmorevideos()
    {
       // $select3 =vcmoduleModel::select('vcmId','vcmName')->where('isAvail','=','0')->get();
        $select3 =vcmoduleModel::select('vcmId','vcmName')->orderBy('vcmName', 'ASC')->get();
       // $select1 =vcchapterModel::select()->orderBy('isAvail', 'ASC')->where('isAvail','0')->get();
        $select1 =vcchapterModel::select()->orderBy('isAvail', 'ASC')->orderBy('vcChapterName', 'ASC')->get();
        $select=DB:: select("SELECT A.vcChapterId, A.vcmId, A.vcChapterName, B.vcVDId, B.vcChapterId, B.videoHeading,B.videoLink,B.description,B.isPublished, C.vcmId, C.vcmName
        FROM vc_chapters AS A
        INNER JOIN vc_more_videos AS B ON A.vcChapterId = B.vcChapterId
        INNER JOIN vc_module AS C ON C.vcmId = A.vcmId
        WHERE B.isPublished IN (0,1)
        ORDER BY B.isPublished ASC");
        return view('video_class/add_videosVC', compact('select','select1','select3'));
    }
    
    
    
     // ENABLE AND DISABLE VIDEEO
    public function vcvideoDisable($vcVDId)
    {
        $isAvail=1;
       
        vcmoreVideoModel::where('vcVDId',$vcVDId)->update(['isPublished'=>$isAvail]);

        $vcvdeoId=(DB::select("SELECT `vcExamId` FROM `vc_exams` WHERE `vcVDId`='$vcVDId'"));

       
            foreach($vcvdeoId as $row)
            {
                $vcExamId = $row->vcExamId;
                vcexamModel::where('vcExamId',$vcExamId)->update(['isAvail'=>$isAvail]);
            }

            $vcExamIds = [];

                foreach($vcvdeoId as $row)
                {
                    $vcExamIds[] = $row->vcExamId;
                }

                // Use the IN clause to retrieve vcAnswerId values for all vcExamIds
                $selectVCId = DB::table('vc_exam_ans')
                    ->whereIn('vcExamId', $vcExamIds)
                    ->select('vcAnswerId')
                    ->get();

                foreach($selectVCId as $row)
                {
                    $vcAnswerId = $row->vcAnswerId;
                    vcansModel::where('vcAnswerId', $vcAnswerId)->update(['isAvail' => $isAvail]);
                }
           
          
       

        return redirect()->back()->with('success','Video Disabled');
    }

    public function vcvideoEnable($vcVDId)
    {
        $isAvail=0;
        $ispub=2;
       
        vcmoreVideoModel::where('vcVDId',$vcVDId)->update(['isPublished'=>$isAvail]);

        $vcvdeoId=(DB::select("SELECT `vcExamId` FROM `vc_exams` WHERE `vcVDId`='$vcVDId'"));

       
            foreach($vcvdeoId as $row)
            {
                $vcExamId = $row->vcExamId;
                vcexamModel::where('vcExamId',$vcExamId)->update(['isAvail'=>$ispub]);
            }

           
            $vcExamIds = [];

            foreach($vcvdeoId as $row)
            {
                $vcExamIds[] = $row->vcExamId;
            }

            // Use the IN clause to retrieve vcAnswerId values for all vcExamIds
            $selectVCId = DB::table('vc_exam_ans')
                ->whereIn('vcExamId', $vcExamIds)
                ->select('vcAnswerId')
                ->get();

            foreach($selectVCId as $row)
            {
                $vcAnswerId = $row->vcAnswerId;
                vcansModel::where('vcAnswerId', $vcAnswerId)->update(['isAvail' => $ispub]);
            }
           
       

        return redirect()->back()->with('success','Video Activated');
    }


    //END
    
    
    
    
    
    
    
    
    
    
    
    


    function subjectCheckforvideo()
    {

        $vcmId=request()->get('vcmId');
        $vc_subject_view = vcchapterModel::select()->where('vcmId',$vcmId)->orderBy('vcChapterName', 'ASC')->get();
        return $vc_subject_view;
    }

    public function addvideodatas(Request $request)
    {
        $validatedData = $request->validate([
            'videohead' => 'required|min:3|max:100',
            'videoLink' => 'required',
            'description' => 'required',

        ], [
            'videohead.required' => 'This field is required.',
            'videoLink.required' => 'This field is required.',
            'description.required' => 'This field is required.',
        ]);


        $createdBy=request('user_id');                                                      //FROM SESSION

        //FROM SESSION
        // $createdAt= $this->currentDateTime;
        $vcmId=request('subject');
        
        $vcChapterId =request('chapter');

        $videohead = request('videohead');
        $videohead=preg_replace('/\s+/', ' ', $videohead);
        $videohead=ucwords($videohead);

        $videoLink = request('videoLink');
        $description = request('description');

      
            $vcmorevideo = new vcmoreVideoModel();
            $vcmorevideo->vcChapterId = $vcChapterId;
            $vcmorevideo->videoHeading = $videohead;
            $vcmorevideo->videoLink = $videoLink;
            $vcmorevideo->description = $description;
            $vcmorevideo->created_by = $createdBy;
            $vcmorevideo->save();
            
            return redirect()->back()->with([
                'success' => 'Video Added',
                'vcChapterId' => $vcChapterId,
                'vcmId' =>$vcmId
            ]); 
       // }
    }

    public function deletevideoclss($vcVDId)
    {
      
        $question = vcmoreVideoModel::find($vcVDId);
        $question->delete();
        
         $vcvdeoId=(DB::select("SELECT `vcExamId` FROM `vc_exams` WHERE `vcVDId`='$vcVDId'"));

       
            foreach($vcvdeoId as $row)
            {
                $vcExamId = $row->vcExamId;
                vcexamModel::where('vcExamId',$vcExamId)->delete();
            }

           
            $vcExamIds = [];

            foreach($vcvdeoId as $row)
            {
                $vcExamIds[] = $row->vcExamId;
            }

            // Use the IN clause to retrieve vcAnswerId values for all vcExamIds
            $selectVCId = DB::table('vc_exam_ans')
                ->whereIn('vcExamId', $vcExamIds)
                ->select('vcAnswerId')
                ->get();

            foreach($selectVCId as $row)
            {
                $vcAnswerId = $row->vcAnswerId;
                vcansModel::where('vcAnswerId', $vcAnswerId)->delete();
            }
        
        
        
        
        return redirect()->back()->with('success','Video Deleted');
          
  
    }

    //update video form start------------
    function updatevideoform($vcVDId)
    {
        //print_r('hai');die;
        $video = vcmoreVideoModel::select( 'vcVDId', 'vcChapterId', 'videoHeading', 'videoLink', 'description', 'isPublished')->where('vcVDId',$vcVDId)->get();
        return view('video_class/Editvideoform', compact('video'));
    }

    public function videoclsUpdatevcMVtbl(Request $request,$vcVDId)
    {
        $validatedData = $request->validate([
            'videohead' => 'required',
            'videoLink' => 'required',
            'description' => 'required',

        ], [
            'videohead.required' => 'This field is required.',
            'videoLink.required' => 'This field is required.',
            'description.required' => 'This field is required.',
        ]);


        $updatedBy=$request['user_id'];
        $updatedAt= $this->currentDateTime;


        $videohead = $request['videohead'];
        // dd($smName);
        $videohead=preg_replace('/\s+/', ' ', $videohead);
        $videohead=ucwords($videohead);

        $videoLink = $request['videoLink'];
        $description = $request['description'];
        $vcChapterId = $request['vcChapterId'];
        


            $subcategory = vcmoreVideoModel::find($vcVDId);

            $subcategory->update([
                'vcVDId' => $vcVDId,
                'vcChapterId'=>$vcChapterId,
                'videoHeading' => $videohead,
                'videoLink' => $videoLink,
                'description' => $description,
                'updated_by' => $updatedBy,
                'updated_at' => $updatedAt
            ]);
            return redirect("/addvideos")->with('success', 'Video Updated');
        }




         /// APPROVING WORKERS ADDED VIDEO CLASS QUESTIONS ------------------------------- DRAFT QUESTIONS RUD


    public function workersVclassShowQ()
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
        return view('video_class/draft_show_QA',compact('module_view','question'));
    }

    function draftVcQuestionTake()
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

   
    public function draftdeleteVcQuestion($questionId)
    {
        $question=vcexamModel::where('vcExamId',$questionId);
        $question->update(['isAvail' => 1]);
        $answer=vcansModel::where('vcExamId',$questionId);
        $answer->update(['isAvail' => 1]);
        return redirect("/draftVCQA")->with('success','Question Deleted');
    }


    public function draftVClassquestionUpdate(Request $request)
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

        return redirect("/draftVCQA")->with('success','Question Updated');
    }
   
    function draftsubjectshow(){
       // $category= DB::select("SELECT * from `vc_module` where `isAvail`=0");
        $category= DB::select("SELECT * from `vc_module` ");
        return $category;
    }

    function draftchaptersshow()
    {
        $vcmId=request()->get('vcmId');
       // $subcategory = vcchapterModel::select()->where('vcmId',$vcmId)->where('isAvail','0')->get();
        $subcategory = vcchapterModel::select()->where('vcmId',$vcmId)->get();
        return $subcategory;
    }
    function draftmorevideocheck()
    {
        $vcChapterId=request()->get('vcChapterId');
      //  $morevideo = vcmoreVideoModel::select()->where('vcChapterId',$vcChapterId)->where('isPublished','0')->get();
        $morevideo = vcmoreVideoModel::select()->where('vcChapterId',$vcChapterId)->get();
        return $morevideo;
    }
    function draftupdateVideoclassQuestionForm()
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
   
   return view('video_class/Edit_vc_draft_Qustion', compact('allVcQuestions'));
    }


    /// APPROVING
    public function VCQapproving($questionId)
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
    public function VCQrefusing($questionId)
    {
      
        $question = vcexamModel::find($questionId);
        $answer = vcansModel::find($questionId);
        
        $question->update(['isAvail' => 2]);
        $answer->update(['isAvail' => 2]);
  
  
        return redirect()->back()->with('success','Question Refused');
          
  
    }





    //search subject wise chapter shows in ajax
    public function searchsubjectwisechapter(Request $request)
    {
        $searchsubjectValue = $request->input('selvalue');
    
        $users = DB::select("SELECT A.vcmId, A.vcmName, B.vcChapterId, B.vcmId, B.vcChapterName,B.isAvail
        FROM vc_module AS A
        INNER JOIN vc_chapters AS B ON A.vcmId = B.vcmId  
        WHERE B.vcmId = '$searchsubjectValue'  
        ORDER BY B.isAvail ASC ");
    
        $output = [];
        $i = 1;
    
        foreach ($users as $item) {
            $output[] = [
                'slNo' => $i++,
                'isAvail' => ($item->isAvail == 0) ? 'green' : 'red',
                'vcmName' => wordwrap($item->vcmName, 20, "\n", true),     
                'vcChapterName' => wordwrap($item->vcChapterName, 20, "\n", true),
                'editUrl' => url('updatechapter'.$item->vcChapterId),
                'deactivateUrl' => ($item->isAvail == 0) ? url('chapterDisable/'.$item->vcChapterId) : '',
                'activateUrl' => ($item->isAvail == 1) ? url('chapterEnable/'.$item->vcChapterId) : '',
                'deleteUrl' => url('chapterDelete/'.$item->vcChapterId),
            ];
        }
    
        return response()->json($output);
    }



     //search subject wise videos shows in ajax
     public function searchsubjectwisevideos(Request $request)
     {
         $searchsubjectValue = $request->input('selvalue');
     
         $users = DB::select("SELECT A.vcChapterId, A.vcmId, A.vcChapterName, B.vcVDId, B.vcChapterId, B.videoHeading,B.videoLink,B.description,B.isPublished, C.vcmId, C.vcmName
         FROM vc_chapters AS A
         INNER JOIN vc_more_videos AS B ON A.vcChapterId = B.vcChapterId
         INNER JOIN vc_module AS C ON C.vcmId = A.vcmId
         WHERE B.isPublished IN(0,1) AND A.vcmId = '$searchsubjectValue'
         ORDER BY B.isPublished ASC ");
     
         $output = [];
         $i = 1;
     
         foreach ($users as $item) {
             $output[] = [
                 'slNo' => $i++,
                 'isPublished' => ($item->isPublished == 0) ? 'green' : 'red',
                 'vcmName' => wordwrap($item->vcmName, 20, "\n", true),     
                 'vcChapterName' => wordwrap($item->vcChapterName, 20, "\n", true),
                 'videoHeading' => wordwrap($item->videoHeading, 20, "\n", true),     
                 'videoLink' => wordwrap($item->videoLink, 20, "\n", true),
                 'description' => wordwrap($item->description, 20, "\n", true),
                 'editUrl' => url('updatevideo'.$item->vcVDId),
                 'deactivateUrl' => ($item->isPublished == 0) ? url('vcvideoDisable/'.$item->vcVDId) : '',
                 'activateUrl' => ($item->isPublished == 1) ? url('vcvideoEnable/'.$item->vcVDId) : '',
                 'deleteUrl' => url('videoDelete/'.$item->vcVDId),
             ];
         }
     
         return response()->json($output);
     }




      //search chapter wise videos shows in ajax
      public function searchchapterbasevideo(Request $request)
      {
          $searchsubjectValue = $request->input('selvaluesubject');
          $searchchapterValue = $request->input('selvaluechapter');
          //print_r($searchchapterValue);die;
          $users = DB::select("SELECT A.vcChapterId, A.vcmId, A.vcChapterName, B.vcVDId, B.vcChapterId, B.videoHeading,B.videoLink,B.description,B.isPublished, C.vcmId, C.vcmName
          FROM vc_chapters AS A
          INNER JOIN vc_more_videos AS B ON A.vcChapterId = B.vcChapterId
          INNER JOIN vc_module AS C ON C.vcmId = A.vcmId
          WHERE B.isPublished IN(0,1) AND A.vcChapterId = '$searchchapterValue'
          ORDER BY B.isPublished ASC ");
         // print_r($searchchapterValue);die;
          $output = [];
          $i = 1;
      
          foreach ($users as $item) {
              $output[] = [
                  'slNo' => $i++,
                  'isPublished' => ($item->isPublished == 0) ? 'green' : 'red',
                  'vcmName' => wordwrap($item->vcmName, 20, "\n", true),     
                  'vcChapterName' => wordwrap($item->vcChapterName, 20, "\n", true),
                  'videoHeading' => wordwrap($item->videoHeading, 20, "\n", true),     
                  'videoLink' => wordwrap($item->videoLink, 20, "\n", true),
                  'description' => wordwrap($item->description, 20, "\n", true),
                  'editUrl' => url('updatevideo'.$item->vcVDId),
                   'deactivateUrl' => ($item->isPublished == 0) ? url('vcvideoDisable/'.$item->vcVDId) : '',
                   'activateUrl' => ($item->isPublished == 1) ? url('vcvideoEnable/'.$item->vcVDId) : '',
                  'deleteUrl' => url('videoDelete/'.$item->vcVDId),
              ];
          }
      
          return response()->json($output);
      }







       

      // SHOW FILTERED QUESTIONS---------VIDEO CLASSSES-------------------------------------------
      
    function showfilterformvc()
    {

       // $select3 =pqmainModel::select('pqmainId','pqmainName')->where('isAvail','=','0')->get();
     //   $categoryView = vcmoduleModel::select()->orderBy('isAvail', 'ASC')->where('isAvail','0')->get();
        $categoryView = vcmoduleModel::select()->orderBy('isAvail', 'ASC')->get();
       
        return view('admin/vc_filter_form_questions',compact('categoryView'));
    }


//     /// SHOW THE FILTERED QUESTIONS AND ANSWERSS
    public function searchfilterdquestvideoclass(Request $request)
    {
        $video = request('video');
        $video1 =$request->input('video');

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
        e.vcVDId = $video
        AND a.isAvail = 0
        AND b.isAvail = 0
        AND c.isAvail IN (0,1)
        AND d.isAvail IN (0,1)
        AND e.isPublished IN (0,1)
    ORDER BY
        a.vcExamId DESC;");
        return view('admin/vc_filter_showq',compact('module_view','question', 'video1'));
    }

    function VCsupadminquestionTake()
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

   
    public function VCsupadminQuestionDelete($questionId)
    {
        $question=vcexamModel::where('vcExamId',$questionId);
        $question->update(['isAvail' => 1]);
        $answer=vcansModel::where('vcExamId',$questionId);
        $answer->update(['isAvail' => 1]);
       
        return redirect()->back()->with('success','Question Deleted');
   
    }

//     //---------------------------------Update Exam Start Here--------------------------------------

    function updatesupadminVCQuestion()
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
  
   
   return view('admin/vc_filter_edit_qForm', compact('allVcQuestions'));
   
    }


    public function VcquestionsupadminUpdate(Request $request)
    {
        $vcExamId = request('vcExamId');

        $vcmId = request('vcmId');
        $chapter = request('vcChapterId');

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

        $vcexam = vcexamModel::find($vcExamId);
        //print_r($pqId);die;

        $vcexam->update([
            'vcVDId' =>  $vcVDId,
            'question'=>$question,
            'optionA'=> $option1,
            'optionB'=> $option2,
            'optionC'=> $option3,
            'optionD'=> $option4,
            'isAvail'=> $isAvail,
            'updated_at'=>$updated_at,
            'updated_by'=>$updated_by]);
        //UPDATE ANSWER TO ANSWERS TABLE
        DB::update("UPDATE `vc_exam_ans` SET `optionA`=$value1,`optionB`=$value2,`optionC`=$value3,`optionD`=$value4,`isAvail`=$isAvail,`updated_by`=$updated_by WHERE `vcExamId`='$vcExamId';");

        return redirect("/showfilterformvc")
        ->with([
            'success' => 'Question Updated',
            'vcmid' =>$vcmId,
            'vcVDId'  =>$vcVDId,
            'vcChapterId' =>$chapter
           
        ]); 
     
    }
   
   
    function subjectsupadminshow(){
       // $category= DB::select("SELECT * from `vc_module` where `isAvail`=0");
        $category= DB::select("SELECT * from `vc_module` ");
        return $category;
    }

    function chaptersupadminshow()
    {
        $vcmId=request()->get('vcmId');
       // $subcategory = vcchapterModel::select()->where('vcmId',$vcmId)->where('isAvail','0')->get();
        $subcategory = vcchapterModel::select()->where('vcmId',$vcmId)->get();
        return $subcategory;
    }

    function morevideosupadmincheck()
    {
        $vcChapterId=request()->get('vcChapterId');
      //  $morevideo = vcmoreVideoModel::select()->where('vcChapterId',$vcChapterId)->where('isPublished','0')->get();
        $morevideo = vcmoreVideoModel::select()->where('vcChapterId',$vcChapterId)->get();
        return $morevideo;
    }






   // END VIDEO CLASS FILTRATION---------------------







     

      // SHOW DRAFT SUPER ADMIN FILTERED QUESTIONS---------VIDEO CLASSSES-------------------------------------------
      
      function showfiltersuperadminformvc()
      {
  
         // $select3 =pqmainModel::select('pqmainId','pqmainName')->where('isAvail','=','0')->get();
        //  $categoryView = vcmoduleModel::select()->orderBy('isAvail', 'ASC')->where('isAvail','0')->get();
          $categoryView = vcmoduleModel::select()->orderBy('isAvail', 'ASC')->get();
         
          return view('video_class/vc_filter_form_questions',compact('categoryView'));
      }
  
  
  //     /// SHOW THE FILTERED QUESTIONS AND ANSWERSS
      public function searchfilterdquestdraftsadminvideoclass(Request $request)
      {
          $video = request('video');
  
          $module_view=vcmoduleModel::select()->get();
  
          $question=DB::select("SELECT DISTINCT
          a.vcExamId AS questionId,
          a.vcVDId AS moreVideochapterId,
          a.isAvail,
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
          e.vcVDId = $video
          AND a.isAvail = 2
          AND b.isAvail = 2
          AND c.isAvail IN (0,1)
          AND d.isAvail IN (0,1)
          AND e.isPublished IN (0,1)
      ORDER BY
          a.vcExamId DESC;");
          return view('video_class/vc_filter_showq',compact('module_view','question'));
      }
  
      function VCsupadmindraftquestionTake()
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
  
     
      public function VCsupadmindraftvcQuestionDelete($questionId)
      {
          $question=vcexamModel::where('vcExamId',$questionId);
          $question->update(['isAvail' => 1]);
          $answer=vcansModel::where('vcExamId',$questionId);
          $answer->update(['isAvail' => 1]);
         
          return redirect()->back()->with('success','Question Deleted');
     
      }
  
//   //     //---------------------------------Update Exam Start Here--------------------------------------
  
      function updatesupadmindraftVCQuestion()
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
    
     
     return view('video_class/vc_filter_edit_qForm', compact('allVcQuestions'));
     
      }
  
  
      public function VcquestionsupadmindraftUpdate(Request $request)
      {
          $vcExamId = request('vcExamId');
  
          $vcmId = request('vcmId');
          $chapter = request('vcChapterId');
  
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
              'isAvail'=> $isAvail,
              'updated_at'=>$updated_at,
              'updated_by'=>$updated_by]);
          //UPDATE ANSWER TO ANSWERS TABLE
          DB::update("UPDATE `vc_exam_ans` SET `optionA`=$value1,`optionB`=$value2,`optionC`=$value3,`optionD`=$value4,`isAvail`=$isAvail,`updated_by`=$updated_by WHERE `vcExamId`='$vcExamId';");
  
          return redirect("/showfiltersuperadminsearchformvc")
          ->with([
              'success' => 'Question Updated',
              'vcmid' =>$vcmId,
              'vcVDId'  =>$vcVDId,
              'vcChapterId' =>$chapter
             
          ]); 
       
      }
     
     
      function subjectsupadmindraftshow(){
       //   $category= DB::select("SELECT * from `vc_module` where `isAvail`=0");
          $category= DB::select("SELECT * from `vc_module`");
          return $category;
      }
  
      function chaptersupadmindraftshow()
      {
          $vcmId=request()->get('vcmId');
        //  $subcategory = vcchapterModel::select()->where('vcmId',$vcmId)->where('isAvail','0')->get();
          $subcategory = vcchapterModel::select()->where('vcmId',$vcmId)->get();
          return $subcategory;
      }
  
      function morevideosupadmindraftcheck()
      {
          $vcChapterId=request()->get('vcChapterId');
        //  $morevideo = vcmoreVideoModel::select()->where('vcChapterId',$vcChapterId)->where('isPublished','0')->get();
          $morevideo = vcmoreVideoModel::select()->where('vcChapterId',$vcChapterId)->get();
          return $morevideo;
      }
  
  
  
  
      
    //       //approve subcategory wise
    public function VCapprovingsubcategorywisesadmin($parameter)
    {
        $questionId = Crypt::decrypt($parameter);
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
  



  // END FILTERED DRAFT APPROVED QUESTIONS-------------


  // EXCEL DOWNLOAD HERE-
  // excel download
     public function excelgetvidepclassexamdwnld(){

        $data=DB::select("SELECT
        d.vcmName AS vcModuleName,
        c.vcChapterName AS chapterName,
        e.videoHeading AS videoHeading,
        a.question,
          a.optionA AS optionA,
          a.optionB AS optionB,
          a.optionC AS optionC,
          a.optionD AS optionD,
               CASE
                WHEN b.optionA = 1 THEN a.optionA 
                WHEN b.optionB = 1 THEN a.optionB
                WHEN b.optionC = 1 THEN a.optionC 
                WHEN b.optionD = 1 THEN a.optionD
               END AS answer
               
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
        return $data;
     }

   // EXCEL FILTER DOWNLOAD
    //EXCEL FILTER
    public function excelgetFilteredvideoclassexamdwnld(Request $request){

        $videoId= request('videoId');
        $data=DB::select("SELECT 
        c.vcChapterName AS chapterName,
        d.vcmName AS vcModuleName,
        e.videoHeading AS videoHeading,
        a.question,
        a.optionA AS optionA,
        a.optionB AS optionB,
        a.optionC AS optionC,
        a.optionD AS optionD,
       CASE
         WHEN b.optionA = 1 THEN a.optionA 
         WHEN b.optionB = 1 THEN a.optionB
         WHEN b.optionC = 1 THEN a.optionC 
         WHEN b.optionD = 1 THEN a.optionD
        END AS answer
       
    FROM
        `vc_exams` AS a
        JOIN `vc_exam_ans` AS b ON b.vcExamId = a.vcExamId
        JOIN `vc_more_videos` AS e ON e.vcVDId = a.vcVDId
        JOIN `vc_chapters` AS c ON c.vcChapterId = e.vcChapterId
        JOIN `vc_module` AS d ON d.vcmId = c.vcmId
    WHERE
        e.vcVDId = '$videoId'
        AND a.isAvail = 0
        AND b.isAvail = 0
        AND c.isAvail IN (0,1)
        AND d.isAvail IN (0,1)
        AND e.isPublished IN (0,1)
    ORDER BY
        a.vcExamId DESC;");

        return $data;
    }
    
    // END----



    

    
  
}
