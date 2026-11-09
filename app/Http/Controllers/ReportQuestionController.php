<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ModuleModel;
use App\Models\GenaralQuestionModels\SubModuleModel;
use App\Models\GenaralQuestionModels\QuestionModel;
use App\Models\GenaralQuestionModels\AnswerModel;

use App\Models\ImagePQAModel\imagePquestionModel;
use App\Models\ImagePQAModel\imagePanswerModel;

use App\Models\PreviousQuestionModels\PQAnswerModel;
use App\Models\PreviousQuestionModels\PQuestionModel;

use App\Models\user_detail_Model;

use App\Models\ReportQuestion\reportQuestion;

use Illuminate\Routing\Controller;

use DB;

use Illuminate\Support\Facades\Crypt;


use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Session;
 

class ReportQuestionController extends Controller
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


    //show report quest form
    public function show_report_form_sadmin(Request $request){
        $report=DB::select("SELECT 
        a.cqId AS questionId,
        a.question,
        rep.status,
        rep.examMode,
        COUNT(det.name) AS usercount
    FROM 
        cooperation_question AS a
    JOIN 
        cooperation_answer AS b ON a.cqId = b.cqId
    JOIN 
        report_question AS rep ON rep.questionId = a.cqId
    JOIN 
        user_details AS det ON det.uId = rep.uId
    WHERE 
        rep.examMode = 3
    GROUP BY 
        a.cqId, a.question, rep.status,rep.examMode
    
    UNION
    
    SELECT 
        c.ipqId AS questionId,
        c.question,
        rep.status,
        rep.examMode,
        COUNT(det.name) AS usercount
    FROM 
        image_p_questions AS c
    JOIN 
        image_p_answers AS d ON d.ipqId = c.ipqId
    JOIN 
        report_question AS rep ON rep.questionId = c.ipqId
    JOIN 
        user_details AS det ON det.uId = rep.uId
    WHERE 
        rep.examMode = 2
    GROUP BY 
        c.ipqId, c.question, rep.status,rep.examMode
        
        
        UNION
    
    SELECT 
        c.pqId AS questionId,
        c.question,
        rep.status,
        rep.examMode,
        COUNT(det.name) AS usercount
    FROM 
        p_questions AS c
    JOIN 
        p_answers AS d ON d.pqId = c.pqId
    JOIN 
        report_question AS rep ON rep.questionId = c.pqId
    JOIN 
        user_details AS det ON det.uId = rep.uId
    WHERE 
        rep.examMode = 1
    GROUP BY 
        c.pqId, c.question, rep.status,rep.examMode
        
        
        
        
    
    ORDER BY 
        status ASC;
    
    
    
    
    ");
        return view('report_question.reportform',compact('report'));
       
    }

    public function show_report_response(Request $request, $questionId){
       // dd($examMode);
   
        $report=DB::select("SELECT 
                a.cqId AS questionId,a.question,a.optA AS optA,a.optB AS optB,a.optC AS optC,a.optD AS optD,
                b.optA AS ansA,b.optB AS ansB,b.optC AS ansC,b.optD AS ansD,rep.examMode,
                GROUP_CONCAT(det.name) AS reportedUsers,
                GROUP_CONCAT(rep.reportReason SEPARATOR '/') AS reportedReasons,
                GROUP_CONCAT(rep.status) AS reportedStatuses,
                GROUP_CONCAT(rep.date) AS reportedDates
            FROM 
                `cooperation_question` AS a
            JOIN 
                `cooperation_answer` AS b ON a.`cqId` = b.`cqId`
            JOIN 
                `report_question` AS rep ON rep.questionId = a.cqId
            JOIN 
                `user_details` AS det ON det.uId = rep.uId
            WHERE 
                a.`cqId` = $questionId
            
            GROUP BY
                a.cqId, a.question, a.optA, a.optB, a.optC, a.optD,
                b.optA, b.optB, b.optC, b.optD,rep.examMode
            ");
   
        return view('report_question.reportQuestForm',compact('report'));
    }




    //update
    public function update_the_reported_question(Request $request){
//main exam
        $validatedData = $request->validate([
            'question' => 'required',
            'option1' => 'required',
            'option2' => 'required',
            'option3' => 'required',
            'option4' => 'required',

        ], [
            'question.required' => 'this field is required!',
            'option1.required' => 'this field is required!',
            'option2.required' => 'this field is required!',
            'option3.required' => 'this field is required!',
            'option4.required' => 'this field is required!',
        ]);




        $questionId = request('questionId');
        $examMode = request('examMode');

       
           // dd($examMode);

            $question = request('question');
            $option1 = request('option1');
            $option2 = request('option2');
            $option3 = request('option3');
            $option4 = request('option4');
            $answer = request('answer');
            
            $updated_by = request('user_id');   
            $updated_at=$this->currentDateTime;  
    
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
    
            $qmodule = QuestionModel::find($questionId);
    
            $qmodule->update([
                
                'question'=>$question,
                'optA'=> $option1,
                'optB'=> $option2,
                'optC'=> $option3,
                'optD'=> $option4,
               
                'updated_at'=>$updated_at,
                'updated_by'=>$updated_by
            ]);
    
            DB::update("UPDATE `cooperation_answer` SET `optA`=$value1,`optB`=$value2,`optC`=$value3,`optD`=$value4,`updated_by`=$updated_by WHERE `cqId`=$questionId");

            $updateReportstatus=reportQuestion::where('questionId',$questionId)->where('examMode',3)
            ->update([
                'status' => '1'
            ]);
    
            
            return redirect("/show_report_form_sadmin")->with('success','Reported Question Updated');


       


    }


    //image 
    public function show_image_report_response(Request $request, $questionId){
       

        $report=DB::select("SELECT 
        a.ipqId AS questionId,a.question,a.optionA AS optA,a.optionB AS optB,a.optionC AS optC,a.optionD AS optD,
        b.optionA AS ansA,b.optionB AS ansB,b.optionC AS ansC,b.optionD AS ansD,rep.examMode,
        GROUP_CONCAT(det.name) AS reportedUsers,
        GROUP_CONCAT(rep.reportReason SEPARATOR '/') AS reportedReasons,
        GROUP_CONCAT(rep.status) AS reportedStatuses,
        GROUP_CONCAT(rep.date) AS reportedDates
        FROM 
            `image_p_questions` AS a
        JOIN 
            `image_p_answers` AS b ON a.`ipqId` = b.`ipqId`
        JOIN 
            `report_question` AS rep ON rep.questionId = a.ipqId
        JOIN 
            `user_details` AS det ON det.uId = rep.uId
        WHERE 
            a.`ipqId` = '$questionId'
        
        GROUP BY
            a.ipqId, a.question, a.optionA, a.optionB, a.optionC, a.optionD,
            b.optionA, b.optionB, b.optionC, b.optionD,rep.examMode;
                ");
   
       
        return view('report_question.image_reportQuestForm',compact('report'));
    }


    ///image
    public function update_the_image_reported_question(Request $request){


        $validatedData = $request->validate([
            'questionIMAGE' => 'required',
            'option_1image' => 'required',
            'option_2image' => 'required',
            'option_3image' => 'required',
            'option_4image' => 'required',

        ], [
            'questionIMAGE.required' => 'this field is required!',
            'option_1image.required' => 'this field is required!',
            'option_2image.required' => 'this field is required!',
            'option_3image.required' => 'this field is required!',
            'option_4image.required' => 'this field is required!',
        ]);




        $questionId = request('questionId');
        $examMode = request('examMode');

       

        $question = request('questionIMAGE');
        $option1 = request('option_1image');
        $option2 = request('option_2image');
        $option3 = request('option_3image');
        $option4 = request('option_4image');
        $answer = request('answerImage');

        $updated_by = request('user_id');                  /////////////from SESSION VALUE
        $updated_at= $this->currentDateTime;   /////////////from date
       

        if($answer=="option1image")
        {$value1=1;$value2=0;$value3=0;$value4=0;}
        else if($answer=="option2image")
        {$value1=0;$value2=1;$value3=0;$value4=0;}
        else if($answer=="option3image")
        {$value1=0;$value2=0;$value3=1;$value4=0;}
        else if($answer=="option4image")
        {$value1=0;$value2=0;$value3=0;$value4=1;}

        //UPDATE QUESTIONS TO QUESTION TABLE

        $pqmodule = imagePquestionModel::find($questionId);
        //print_r($pqId);die;

        $pqmodule->update([
            
            'question'=>$question,
            'optionA'=> $option1,
            'optionB'=> $option2,
            'optionC'=> $option3,
            'optionD'=> $option4,
           
            'updated_at'=>$updated_at,
            'updated_by'=>$updated_by]);
        //UPDATE ANSWER TO ANSWERS TABLE
        DB::update("UPDATE `image_p_answers` SET `optionA`=$value1,`optionB`=$value2,`optionC`=$value3,`optionD`=$value4,`updated_by`=$updated_by WHERE `ipqId`=$questionId");

        $updateReportstatus=reportQuestion::where('questionId',$questionId)->where('examMode',2)
        ->update([
            'status' => '1'
        ]);

        return redirect("/show_report_form_sadmin")->with('success','Reported Question Updated');

    }



    //previous question
    public function show_previous_report_response(Request $request, $questionId){

        $report=DB::select("SELECT 
        a.pqId AS questionId,a.question,a.optionA AS optA,a.optionB AS optB,a.optionC AS optC,a.optionD AS optD,
        b.optionA AS ansA,b.optionB AS ansB,b.optionC AS ansC,b.optionD AS ansD,rep.examMode,
        GROUP_CONCAT(det.name) AS reportedUsers,
        GROUP_CONCAT(rep.reportReason SEPARATOR '/') AS reportedReasons,
        GROUP_CONCAT(rep.status) AS reportedStatuses,
        GROUP_CONCAT(rep.date) AS reportedDates
        FROM 
            `p_questions` AS a
        JOIN 
            `p_answers` AS b ON a.`pqId` = b.`pqId`
        JOIN 
            `report_question` AS rep ON rep.questionId = a.pqId
        JOIN 
            `user_details` AS det ON det.uId = rep.uId
        WHERE 
            a.`pqId` = '$questionId'
        
        GROUP BY
            a.pqId, a.question, a.optionA, a.optionB, a.optionC, a.optionD,
            b.optionA, b.optionB, b.optionC, b.optionD,rep.examMode;
                ");
   
       
        return view('report_question.previous_reportQuestForm',compact('report'));

    }



    public function update_the_previous_reported_question(Request $request){

        $validatedData = $request->validate([
            'question' => 'required',
            'option1' => 'required',
            'option2' => 'required',
            'option3' => 'required',
            'option4' => 'required',

        ], [
            'question.required' => 'this field is required!',
            'option1.required' => 'this field is required!',
            'option2.required' => 'this field is required!',
            'option3.required' => 'this field is required!',
            'option4.required' => 'this field is required!',
        ]);


        $questionId = request('questionId');
        $examMode = request('examMode');

       

        $question = request('question');
        $option1 = request('option1');
        $option2 = request('option2');
        $option3 = request('option3');
        $option4 = request('option4');
        $answer = request('answer');

        $updated_by = request('user_id');           
        $updated_at= $this->currentDateTime;   
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

        $pqmodule = PQuestionModel::find($questionId);
        //print_r($pqId);die;

        $pqmodule->update([
           
            'question'=>$question,
            'optionA'=> $option1,
            'optionB'=> $option2,
            'optionC'=> $option3,
            'optionD'=> $option4,
           
            'updated_at'=>$updated_at,
            'updated_by'=>$updated_by]);
        //UPDATE ANSWER TO ANSWERS TABLE
        DB::update("UPDATE `p_answers` SET `optionA`=$value1,`optionB`=$value2,`optionC`=$value3,`optionD`=$value4,`updated_by`=$updated_by WHERE `pqId`=$questionId");

        $updateReportstatus=reportQuestion::where('questionId',$questionId)->where('examMode',1)
        ->update([
            'status' => '1'
        ]);

        return redirect("/show_report_form_sadmin")->with('success','Reported Question Updated');

    }









    }





