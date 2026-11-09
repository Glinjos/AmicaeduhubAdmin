<?php

//users chats or users doubts controlling 
//in super admin

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

use App\Models\chatSuggestionsModels\chatSuggestionSub;

use App\Models\pqmainModel;
use Illuminate\Routing\Controller;

use Illuminate\Http\Request;

use DB;
use Illuminate\Support\Facades\Crypt;

use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Session;

class UserQuestionsController extends Controller
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
   // users doubts
      public function viewusersanswers()
    {
        $answer=chatQuestionsAnsModel::select()->get();
        $users_all_questions=DB::select("SELECT t1.*,t2.mId,t2.mName,t3.uId,t3.name,t4.chatTypeId,t4.typeName,t5.*
        FROM `chat_questions_ans` AS t1
        INNER JOIN `chat_questions_main`        AS t5   ON t5.chatQuestionId=t1.chatQuestionId
        INNER JOIN `module`        AS t2   ON t2.mId=t5.mId
        INNER JOIN `user_details`  AS t3   ON t3.uId=t5.uId
        INNER JOIN `chat_type`     AS t4   ON t4.chatTypeId=t5.chatTypeId
        WHERE t1.Answer IS NOT NULL;");
        return view('user_chat.show_user_questionsAns',compact('users_all_questions','answer'));
    }

    
    // ajax show answer
    function questionadminansTakeandAnsweradmin()
    {
        $chatQuestionAnsId=request()->get('chatQuestionAnsId');
        $allQuestions=DB::select("SELECT t1.*, t2.*
              FROM chat_questions_main as t1
              INNER JOIN chat_questions_ans as t2 ON t2.chatQuestionId = t1.chatQuestionId
              WHERE t2.chatQuestionAnsId = $chatQuestionAnsId;");
        return $allQuestions;
    }
    //view more
    function adminquestionTakeandAnswersviewmore()
    {
        $chatQuestionAnsId=request()->get('chatQuestionAnsId');
        $allQuestions=DB::select("SELECT t1.*, t2.*,t3.mName,t4.name
              FROM chat_questions_main t1
              INNER JOIN chat_questions_ans t2 ON t2.chatQuestionId = t1.chatQuestionId
              INNER JOIN module t3 ON t3.mId = t1.mId
              INNER JOIN user_details t4 ON t4.uId = t1.uId
              WHERE t2.chatQuestionAnsId = $chatQuestionAnsId;");
        return $allQuestions;
    }


      
      


    //  SUGGESTIONS OR IDEAS START HERE-------------------------------------


    public function show_user_suggestions_i()
    {

       
        $users_main_sugg=chatSuggestionSub::select('t2.name','chat_suggestion_sub.*')
        ->join('chat_questions_main as t3','t3.chatQuestionId','=','chat_suggestion_sub.chatQuestionId')
        ->join('user_details as t2','t2.uId','=','t3.uId')
        ->orderBy('chat_suggestion_sub.cssubId','DESC')
        ->get();

        return view('users_suggestions.show_total_suggested_users',compact('users_main_sugg'));
    }



    // show notify users
    public function show_list_view_latest_questions(Request $request){

        $getUsersNameAndQu=DB::select("SELECT  userss.name, count(sub.question) as unanswered
        FROM `chat_questions_sub` as sub
        JOIN `chat_questions_main` as main ON main.chatQuestionId = sub.chatQuestionId
        LEFT JOIN `chat_questions_ans` as ans ON ans.chatQuestionId = main.chatQuestionId
        LEFT JOIN `user_details` as userss on userss.uId = main.uId
        WHERE ans.chatQuestionId IS NULL
        AND main.isClosed=0
        group by userss.name");

        return $getUsersNameAndQu;
    }










}
