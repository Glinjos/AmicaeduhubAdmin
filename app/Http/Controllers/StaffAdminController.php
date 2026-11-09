<?php

//the admins are controlling users
//questions and doubts 
// and answering that questions.
// the super admin assign the users doubts 
//into admin---
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

use App\Models\ChatUsersModels\chatTypeModel;
use App\Models\ChatUsersModels\chatQuestionsMainModel;
use App\Models\ChatUsersModels\chatQuestionsAnsModel;

use App\Models\pqmainModel;
use Illuminate\Routing\Controller;

use Illuminate\Http\Request;

use DB;
use Illuminate\Support\Facades\Crypt;

use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Session;

class StaffAdminController extends Controller
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
       
        return view('staffAdmin.dashboard');
       
    }


    //super admin dashboard--user chats--showing--
    // and assigning----the doubts

    public function showUserChat()
    {
        $user_all_questions=DB::select("SELECT DISTINCT t5.*, t1.chatQuestionId,t2.mId,t2.mName,t3.uId,t3.name,t4.chatTypeId,t4.typeName
        FROM `chat_questions_sub` AS t1
        INNER JOIN `chat_questions_main`        AS t5   ON t5.chatQuestionId=t1.chatQuestionId
        INNER JOIN `module`        AS t2   ON t2.mId=t5.mId
        INNER JOIN `user_details`  AS t3   ON t3.uId=t5.uId
        INNER JOIN `chat_type`     AS t4   ON t4.chatTypeId=t5.chatTypeId
        WHERE t5.isClosed=0 AND t1.chatQuestionId=t5.chatQuestionId
        ORDER BY t5.assigned ASC;");
        return view('user_chat.show_user_doubts',compact('user_all_questions'));
    }


    // assigning admin the questions----

    public function assignquestiontoadmin(Request $request,$parameter)
    {
      
        $questionId = Crypt::decrypt($parameter);
       
        $question = chatQuestionsMainModel::find($questionId);
         
        $question->update(['assigned' => 1]);
      
        // chatQuestionsAnsModel::create([
        //     'chatQuestionId'=>$questionId,
        //     'AssignedTo'=>'3',
        //     'AssignedBy'=>'1',
        //    // 'Answer'=>$value3,
        //     'created_by'=>'1',
            
        // ]);
  
  
        return redirect()->back()->with('success','Question Assigned to Admin');
          
  
    }
// un assign---
    public function unassignquestiontoadmin(Request $request,$parameter)
    {
      
        $questionId = Crypt::decrypt($parameter);
       
        $question = chatQuestionsMainModel::find($questionId);
         
        $question->update(['assigned' => 0]);
      
        // chatQuestionsAnsModel::select('chatQuestionId')->where('chatQuestionId','=',$questionId)
        // ->delete();
  
  
        return redirect()->back()->with('error','Question Unassigned to Admin');
          
  
    }



    /// ADMIN FIELD START HERE------------------
    //ADMIN HANDLE THE QUESTIONS---
    
    //show questions
    public function showquestionsformAdmin()
    {
        $answer=chatQuestionsAnsModel::select()->get();
        $users_all_questions=DB::select("SELECT t2.mId,t2.mName,t3.uId,t3.name,t4.chatTypeId,t4.typeName,t5.*
        FROM `chat_questions_main` AS t5
       
        INNER JOIN `module`        AS t2   ON t2.mId=t5.mId
        INNER JOIN `user_details`  AS t3   ON t3.uId=t5.uId
        INNER JOIN `chat_type`     AS t4   ON t4.chatTypeId=t5.chatTypeId
        WHERE t5.assigned=1 AND t5.isClosed=0;");
        return view('staffAdmin.show_user_questions',compact('users_all_questions','answer'));
    }

    //add answer
    public function addanswerquestion(Request $request)
    {
        $validatedData = $request->validate([
            'answer' => 'required'
        ], [
            'answer.required' => 'This field is required.'
        ]);
      
       $answerid= request('useranswerid');
       $updatedBy=request('user_id');
       $answer=request('answer');
      // print_r($answerid);die;

        chatQuestionsAnsModel::create([
            'chatQuestionId'=>$answerid,
            'AssignedTo'=>'3',
            'Answer'=>$answer,
            'updated_by'=>$updatedBy,
            'AssignedBy'=>'1',
          
            'created_by'=>'1',
            
        ]);
   
      
  
        return redirect()->back()->with('success','Answer Added successfully');
          
  
    }

    // ajax show answer
    function questionTakeandAnsweradmin()
    {
        $chatQuestionSubId=request()->get('chatQuestionSubId');
        $allQuestions=DB::select("SELECT t1.*, t2.*, t3.*
        FROM chat_questions_main t1
        INNER JOIN chat_questions_ans t2 ON t2.chatQuestionId = t1.chatQuestionId
        INNER JOIN chat_questions_sub t3 ON t3.chatQuestionSubId = $chatQuestionSubId
        WHERE t3.chatQuestionSubId =$chatQuestionSubId;");
        return $allQuestions;
    }

    function questionTakeandAnswerviewmore()
    {
        $chatQuestionId=request()->get('chatQuestionId');
        $allQuestions=DB::select("SELECT t1.*, t4.*, t2.*, t3.mName
              FROM chat_questions_main t1
              INNER JOIN chat_questions_sub t4 ON t4.chatQuestionId = t1.chatQuestionId
              INNER JOIN module t3 ON t3.mId = t1.mId
              LEFT JOIN chat_questions_ans t2 ON t2.chatQuestionId = t1.chatQuestionId
              WHERE t4.chatQuestionId =  $chatQuestionId;");
        return $allQuestions;
    }



    //update
    public function updateansweradmin(Request $request)
    {
        // $validatedData = $request->validate([
        //     'answer_update' => 'required'
        // ], [
        //     'answer_update.required' => 'This field is required.'
        // ]);

      
       $answerid= request('answerid');
       $updatedBy=request('user_id');
       $answernew=request('answer_update');
      // $answerOld=request('answerOld');
       $chatQuestionId=request('answerid');
      // print_r($answerid);die;
      if($answernew=="")
      {
        $answer=request('answerOld');
      }
      else{
        $answer=request('answer_update');
      }

       chatQuestionsAnsModel::where('chatQuestionId','=',$chatQuestionId)
       ->update([
        'Answer'=>$answer,
        'updated_by'=>$updatedBy
       ]);
      
  
        return redirect()->back()->with('success','Answer Updated successfully');
          
  
    }



    //Question sub all question take

    public function showsuballquestionformainquest($chatQuestionId)
    {
        $answer=chatQuestionsAnsModel::select()->get();
        $users_all_questions=DB::select("SELECT t6.*,t2.mId,t2.mName,t3.uId,t3.name,t4.chatTypeId,t4.typeName,t5.*
        FROM `chat_questions_main` AS t5
       
        INNER JOIN `chat_questions_sub`  AS t6   ON t6.chatQuestionId=t5.chatQuestionId
        INNER JOIN `module`        AS t2   ON t2.mId=t5.mId
        INNER JOIN `user_details`  AS t3   ON t3.uId=t5.uId
        INNER JOIN `chat_type`     AS t4   ON t4.chatTypeId=t5.chatTypeId
        WHERE t6.chatQuestionId=$chatQuestionId;");
        return view('staffAdmin.show_user_Subquestions',compact('users_all_questions','answer'));
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
        return view('staffAdmin.singleuserchat',compact('users_all_questions','user_name'));

      
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
  

}
