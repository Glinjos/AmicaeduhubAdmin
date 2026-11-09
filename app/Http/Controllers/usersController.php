<?php

/**
 * Created by vsCode.
 * Use: Users Analytics
 * Collecting and analyzing user data.
 * Questions, Exams, Games, etc.: Managing and 
 * tracking user engagement in various activities,
 * including quizzes, examinations, games,
 * and more.
 */

namespace App\Http\Controllers;


use App\Models\user_detail_model;
use App\Models\useranalyticsModel;
use Illuminate\Routing\Controller;

use Illuminate\Http\Request;
use App\Models\ModuleModel;

use App\Models\RevisionsModels\usersRevisionModel;

use DB;
use Illuminate\Support\Facades\Crypt;


use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Session;

class usersController extends Controller
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


    public function showUsers()
    {
        $Users = DB::table('user_details') // Replace 'user_detail' with the actual table name
        ->select('uId', 'name', 'mobile', 'userEmail','userImage','district_Id','dob','otp')
        ->orderBy('created_at', 'desc')
        ->paginate(30);

       $selectdistrict=DB::select("SELECT district_Id,district_name FROM districts");
       
        // $count_users = user_detail_model::selectRaw('count(user_details.uId) as count_of_users')->first();
        $count_users = DB::table('user_details')->selectRaw('count(user_details.uId) as count_of_users')->first();
      
        return view('Users.showUsers',compact('Users','count_users','selectdistrict'));
       
    }


    //   public function searchUser(Request $request)
    //     {
    //         $searchValue = $request->input('selvalue');
    //         // $users = user_detail_Model::where('name', 'LIKE', '%' . $searchValue . '%')
    //         //     ->orWhere('mobile', 'LIKE', '%' . $searchValue . '%')
    //         //     ->paginate(8);
    //         $users = DB::table('user_details')
    //         ->where('name', 'LIKE', '%' . $searchValue . '%')
    //         ->orWhere('mobile', 'LIKE', '%' . $searchValue . '%')
    //         ->paginate(40);
        
        
    //         $output = "<div class='row'>";
        
    //         foreach ($users as $userDetails) {
    //             $output .= "
    //             <div class='col-md-4 col-lg-3'>
    //                 <div class='card shadow eq-card mb-3'>
    //                     <div class='card-body mb-n3'>
    //                         <div class='chart-box mx-4 text-center'>";
                
    //             if (!empty($userDetails->userImage)) {
    //                 $output .= "<img src='" . asset('public/assets/userImage/' . $userDetails->userImage) . "' alt='' width='50' height='50' class='circle'>";
    //             } else {
    //                 $output .= "<img src='" . asset('assets/userImage/defaultUserImage.png') . "' alt='' width='50' height='50' class='circle'>";
    //             }
                
    //             $output .= "</div>
    //                         <div class='row items-align-baseline h-100'>
    //                             <div class='col-md-12 my-3 text-center'>
    //                                 <h3>" . $userDetails->name . "</h3>
    //                                 <p class='text-muted'>" . $userDetails->userEmail . "</p>
    //                                 <p class='text-muted'>" . $userDetails->mobile . "</p>
        
    //                                 <div class='col-md-12 border-top py-3'>
    //                                 <a href='" . url('analyticsShow' . $userDetails->uId) . "'>
    //                                     <button type='button' class='analytics-button'>Analytics</button>
    //                                 </a>
    //                             </div>
                                
    //                             </div>
                               
    //                         </div>
    //                     </div>
    //                 </div>
    //             </div>";
    //         }
        
    //         $output .= "</div>";
        
    //         return response()->json($output);
    //     }
    
     public function searchUser(Request $request)
    {
        $searchValue = $request->input('selvalue');
        // $users = user_detail_Model::where('name', 'LIKE', '%' . $searchValue . '%')
        //     ->orWhere('mobile', 'LIKE', '%' . $searchValue . '%')
        //     ->paginate(8);
        $users = DB::table('user_details')
        ->where('name', 'LIKE', '%' . $searchValue . '%')
        ->orWhere('mobile', 'LIKE', '%' . $searchValue . '%')
         ->orWhere('otp', 'LIKE', '%' . $searchValue . '%')
        ->paginate(30);


        $output = "<div class='row'>";

        foreach ($users as $userDetails) {
            $output .= "
            <div class='col-md-3 col-lg-2'>
                <div class='card shadow eq-card mb-2'>
                    <div class='card-body'>
                        <div class='chart-box mx-3 text-center'>";
            
            if (!empty($userDetails->userImage)) {
                $output .= "<img src='" . asset('public/assets/userImage/' . $userDetails->userImage) . "' alt='' width='50' height='50' class='circle'>";
            } else {
                $output .= "<img src='" . asset('assets/userImage/defaultUserImage.png') . "' alt='' width='50' height='50' class='circle'>";
            }
            
            $output .= "</div>
                        <div class='row items-align-baseline'>
                            <div class='col-md-12 my-3 text-center'>
                                <h6>" . $userDetails->name . "</h6>
                                <p class='text-muted'>" . $userDetails->userEmail .'<br>'. $userDetails->mobile .'<br>OTP - ' . $userDetails->otp ."</p>
                            

                                <div class='border-top py-3 text-center'>
                                <a href='" . url('analyticsShow' . $userDetails->uId) . "'>
                                    <button type='button' class='analytics-button'>Analytics</button>
                                </a>
                            </div>
                            
                            </div>
                        
                        </div>
                    </div>
                </div>
            </div>";
        }

        $output .= "</div>";

        return response()->json($output);
    }



    public function singleAnalytics(Request $request,$uId)
    {

        //$uId = Crypt::decrypt($parameter);


        $userAnalytics= DB::table('user_details')->select('uId','name')->where('uId',$uId)->get();
        // print_r($uId);die;
    $alluserPQDetails = DB::select("
        SELECT  t5.*, t1.*, t2.*, t3.*, t4.*
        FROM `user_analytics` t4
        INNER JOIN `user_details` t3 ON t4.userId = t3.uId
        INNER JOIN `pq_main` t2 ON t4.examTypeId = t2.pqmainId
        INNER JOIN `pq_module` t1 ON t4.examModuleId = t1.pqmId
        INNER JOIN `pq_submodule` t5 ON t4.examSubModuleId = t5.pqsmId
        
        WHERE t4.`courseType`=2 and t4.`userId` = $uId ORDER BY t4.`aId` DESC
        LIMIT 1;
        ");
    // $alluserVCDetails = DB::select("
    // SELECT t5.*, t1.*, t2.*, t3.*, t4.*
    // FROM `user_analytics` t4
    // INNER JOIN `user_details` t3 ON t4.userId = t3.uId
    // INNER JOIN `vc_module` t2 ON t4.examTypeId = t2.vcmId
    // INNER JOIN `vc_chapters` t1 ON t4.examModuleId = t1.vcChapterId
    // INNER JOIN `vc_more_videos` t5 ON t4.examSubModuleId = t5.vcVDId
    // WHERE t4.`courseType`=3 and t4.`userId` = $uId ORDER BY t4.`aId` DESC
    // LIMIT 1;
    // ");

    $alluserVCDetails = DB::select("SELECT t5.*,t1.*,t2.*, t3.*, t4.*
    FROM `user_analytics` t4
    INNER JOIN `user_details` t3 ON t3.uId = t4.userId 
    INNER JOIN `vc_module` t1 ON t1.vcmId = t4.examModuleId
    INNER JOIN `vc_chapters` t2 ON t2.vcChapterId = t4.examSubModuleId
    INNER JOIN `vc_more_videos` t5 ON t5.vcVDId = t4.vcChapterVideoId
    WHERE t4.`courseType`=3 and t4.`userId` = $uId ORDER BY t4.`aId` DESC
    LIMIT 1;");




    $alluserMEDetails = DB::select("
    SELECT   t1.*, t2.*, t3.*, t4.*
        FROM `user_analytics` t4
        INNER JOIN `user_details` t3 ON t4.userId = t3.uId
        INNER JOIN `module` t2 ON t4.examModuleId = t2.mId
        INNER JOIN `sub_module` t1 ON t4.examSubModuleId = t1.smId
       
        
        WHERE t4.`courseType`=1 and t4.`userId` = $uId ORDER BY t4.`aId` DESC
    LIMIT 1;
  ");
  $alluserGZDetails = DB::select("
  SELECT t4.*, t3_player.name AS playerName, t3_opponent.name AS opponentName,t3_winner.name AS winnerName
    FROM `user_analytics` t4 
    INNER JOIN `user_details` t3_player ON t4.playerId = t3_player.uId
    INNER JOIN `user_details` t3_opponent ON t4.opponentId = t3_opponent.uId
    INNER JOIN `user_details` t3_winner ON t4.winnerId = t3_winner.uId
    WHERE t4.userId = $uId ORDER BY t4.`aId` DESC
    LIMIT 1;
  
  ");

//   $SinglHistPQUlss= DB::select("
//   SELECT  t5.*, t1.*, t2.*, t3.*, t4.*
//   FROM `user_analytics` t4
//   INNER JOIN `user_details` t3 ON t4.userId = t3.uId
//   INNER JOIN `pq_main` t2 ON t4.examTypeId = t2.pqmainId
//   INNER JOIN `pq_module` t1 ON t4.examModuleId = t1.pqmId
//   INNER JOIN `pq_submodule` t5 ON t4.examSubModuleId = t5.pqsmId
  
//   WHERE t4.`courseType`=2 and t4.`userId` = $uId ;");

      // print_r($SinglHistVClss);die;
        return view('Users/singleAnalyticsShow',compact('alluserPQDetails','alluserVCDetails','alluserMEDetails','alluserGZDetails','userAnalytics'));
    }

/////// MAIN ------------------------END ----------------
    //////////////////// Previous Question Single User Full History ////////////

///  VIEW MORE LINK CLICK SHOWING FULL DATAS-------------------------------------------------

 public function getSinglrPrevQuest(Request $request,$uId)
 {
    $userAnalytics= DB::table('user_details')->select('uId','name')->where('uId',$uId)->get();
        // print_r($userAnalytics);die;
    $alluserPQDetails = DB::select("
        SELECT  t5.*, t1.*, t2.*, t3.*, t4.*
        FROM `user_analytics` t4
        INNER JOIN `user_details` t3 ON t4.userId = t3.uId
        INNER JOIN `pq_main` t2 ON t4.examTypeId = t2.pqmainId
        INNER JOIN `pq_module` t1 ON t4.examModuleId = t1.pqmId
        INNER JOIN `pq_submodule` t5 ON t4.examSubModuleId = t5.pqsmId
        
        WHERE t4.`courseType`=2 and t4.`userId` = $uId ORDER BY t4.`aId` DESC
        LIMIT 1;
    ");
    $alluserVCDetails = DB::select("
    SELECT t5.*,t1.*,t2.*, t3.*, t4.*
    FROM `user_analytics` t4
    INNER JOIN `user_details` t3 ON t3.uId = t4.userId 
    INNER JOIN `vc_module` t1 ON t1.vcmId = t4.examModuleId
    INNER JOIN `vc_chapters` t2 ON t2.vcChapterId = t4.examSubModuleId
    INNER JOIN `vc_more_videos` t5 ON t5.vcVDId = t4.vcChapterVideoId
    WHERE t4.`courseType`=3 and t4.`userId` = $uId ORDER BY t4.`aId` DESC
    LIMIT 1;
    ");
    $alluserMEDetails = DB::select("
    SELECT   t1.*, t2.*, t3.*, t4.*
        FROM `user_analytics` t4
        INNER JOIN `user_details` t3 ON t4.userId = t3.uId
        INNER JOIN `module` t2 ON t4.examModuleId = t2.mId
        INNER JOIN `sub_module` t1 ON t4.examSubModuleId = t1.smId
       
        
        WHERE t4.`courseType`=1 and t4.`userId` = $uId ORDER BY t4.`aId` DESC
    LIMIT 1;
  ");
  $alluserGZDetails = DB::select("
  SELECT t4.*, t3_player.name AS playerName, t3_opponent.name AS opponentName,t3_winner.name AS winnerName
    FROM `user_analytics` t4 
    INNER JOIN `user_details` t3_player ON t4.playerId = t3_player.uId
    INNER JOIN `user_details` t3_opponent ON t4.opponentId = t3_opponent.uId
    INNER JOIN `user_details` t3_winner ON t4.winnerId = t3_winner.uId
    WHERE t4.userId = $uId ORDER BY t4.`aId` DESC
    LIMIT 1;
  
  ");

  $SinglHistPQUlss= DB::select("
  SELECT  t5.*, t1.*, t2.*, t3.*, t4.*
  FROM `user_analytics` t4
  INNER JOIN `user_details` t3 ON t4.userId = t3.uId
  INNER JOIN `pq_main` t2 ON t4.examTypeId = t2.pqmainId
  INNER JOIN `pq_module` t1 ON t4.examModuleId = t1.pqmId
  INNER JOIN `pq_submodule` t5 ON t4.examSubModuleId = t5.pqsmId
  
  WHERE t4.`courseType`=2 and t4.`userId` = $uId ;");

      // print_r($SinglHistVClss);die;
        return view('Users/singleAnalyticsShow',compact('alluserPQDetails','SinglHistPQUlss','alluserVCDetails','alluserMEDetails','alluserGZDetails','userAnalytics'));
    }




    //// END-------------------
    
  //////////////////// MAIN EXAM Single User Full History ////////////
  public function getSingleMainExam(Request $request,$uId)
  {
    $userAnalytics= DB::table('user_details')->select('uId','name')->where('uId',$uId)->get();

$alluserPQDetails = DB::select("
    SELECT  t5.*, t1.*, t2.*, t3.*, t4.*
    FROM `user_analytics` t4
    INNER JOIN `user_details` t3 ON t4.userId = t3.uId
    INNER JOIN `pq_main` t2 ON t4.examTypeId = t2.pqmainId
    INNER JOIN `pq_module` t1 ON t4.examModuleId = t1.pqmId
    INNER JOIN `pq_submodule` t5 ON t4.examSubModuleId = t5.pqsmId
    
    WHERE t4.`courseType`=2 and t4.`userId` = $uId ORDER BY t4.`aId` DESC
    LIMIT 1;
");
$alluserVCDetails = DB::select("
SELECT t5.*,t1.*,t2.*, t3.*, t4.*
    FROM `user_analytics` t4
    INNER JOIN `user_details` t3 ON t3.uId = t4.userId 
    INNER JOIN `vc_module` t1 ON t1.vcmId = t4.examModuleId
    INNER JOIN `vc_chapters` t2 ON t2.vcChapterId = t4.examSubModuleId
    INNER JOIN `vc_more_videos` t5 ON t5.vcVDId = t4.vcChapterVideoId
    WHERE t4.`courseType`=3 and t4.`userId` = $uId ORDER BY t4.`aId` DESC
    LIMIT 1;
");
$alluserMEDetails = DB::select("
SELECT   t1.*, t2.*, t3.*, t4.*
    FROM `user_analytics` t4
    INNER JOIN `user_details` t3 ON t4.userId = t3.uId
    INNER JOIN `module` t2 ON t4.examModuleId = t2.mId
    INNER JOIN `sub_module` t1 ON t4.examSubModuleId = t1.smId
   
    
    WHERE t4.`courseType`=1 and t4.`userId` = $uId ORDER BY t4.`aId` DESC
LIMIT 1;
");
$alluserGZDetails = DB::select("
SELECT t4.*, t3_player.name AS playerName, t3_opponent.name AS opponentName,t3_winner.name AS winnerName
FROM `user_analytics` t4 
INNER JOIN `user_details` t3_player ON t4.playerId = t3_player.uId
INNER JOIN `user_details` t3_opponent ON t4.opponentId = t3_opponent.uId
INNER JOIN `user_details` t3_winner ON t4.winnerId = t3_winner.uId
WHERE t4.userId = $uId ORDER BY t4.`aId` DESC
LIMIT 1;

");

$SinglHistMEXlss= DB::select("
SELECT   t1.*, t2.*, t3.*, t4.*
    FROM `user_analytics` t4
    INNER JOIN `user_details` t3 ON t4.userId = t3.uId
    INNER JOIN `module` t2 ON t4.examModuleId = t2.mId
    INNER JOIN `sub_module` t1 ON t4.examSubModuleId = t1.smId
   
    
    WHERE t4.`courseType`=1 and t4.`userId` = $uId ;
");

  // print_r($SinglHistVClss);die;
    return view('Users/singleAnalyticsShow',compact('alluserPQDetails','SinglHistMEXlss','alluserVCDetails','alluserMEDetails','alluserGZDetails','userAnalytics'));
}


//// END--------------------

   //////////////////// Game Zone Single User Full History ////////////
   public function getSingleGameZon(Request $request,$uId)
   {
   $userAnalytics= DB::table('user_details')->select('uId','name')->where('uId',$uId)->get();

    $alluserPQDetails = DB::select("
        SELECT  t5.*, t1.*, t2.*, t3.*, t4.*
        FROM `user_analytics` t4
        INNER JOIN `user_details` t3 ON t4.userId = t3.uId
        INNER JOIN `pq_main` t2 ON t4.examTypeId = t2.pqmainId
        INNER JOIN `pq_module` t1 ON t4.examModuleId = t1.pqmId
        INNER JOIN `pq_submodule` t5 ON t4.examSubModuleId = t5.pqsmId
        
        WHERE t4.`courseType`=2 and t4.`userId` = $uId ORDER BY t4.`aId` DESC
        LIMIT 1;
    ");
    $alluserVCDetails = DB::select("
    SELECT t5.*,t1.*,t2.*, t3.*, t4.*
    FROM `user_analytics` t4
    INNER JOIN `user_details` t3 ON t3.uId = t4.userId 
    INNER JOIN `vc_module` t1 ON t1.vcmId = t4.examModuleId
    INNER JOIN `vc_chapters` t2 ON t2.vcChapterId = t4.examSubModuleId
    INNER JOIN `vc_more_videos` t5 ON t5.vcVDId = t4.vcChapterVideoId
    WHERE t4.`courseType`=3 and t4.`userId` = $uId ORDER BY t4.`aId` DESC
    LIMIT 1;
    ");
    $alluserMEDetails = DB::select("
    SELECT   t1.*, t2.*, t3.*, t4.*
        FROM `user_analytics` t4
        INNER JOIN `user_details` t3 ON t4.userId = t3.uId
        INNER JOIN `module` t2 ON t4.examModuleId = t2.mId
        INNER JOIN `sub_module` t1 ON t4.examSubModuleId = t1.smId
    
        
        WHERE t4.`courseType`=1 and t4.`userId` = $uId ORDER BY t4.`aId` DESC
    LIMIT 1;
    ");
    $alluserGZDetails = DB::select("
    SELECT t4.*, t3_player.name AS playerName, t3_opponent.name AS opponentName,t3_winner.name AS winnerName
    FROM `user_analytics` t4 
    INNER JOIN `user_details` t3_player ON t4.playerId = t3_player.uId
    INNER JOIN `user_details` t3_opponent ON t4.opponentId = t3_opponent.uId
    INNER JOIN `user_details` t3_winner ON t4.winnerId = t3_winner.uId
    WHERE t4.userId = $uId ORDER BY t4.`aId` DESC
    LIMIT 1;

    ");

    $SinglHistGZOOlss= DB::select("
    SELECT gz_int.date_time,winner.name as winner_name,t4.totalQuestion,t4.attendedQuestions,t4.rightAns,t4.wrongAns,t4.score
    FROM `gz_history` t4 
    INNER JOIN `user_details` user_details ON t4.userId = user_details.uId
    INNER JOIN `user_details` winner ON t4.winnerId = winner.uId
    INNER JOIN `gz_initialization` gz_int ON gz_int.giId = t4.giId
    
    WHERE t4.userId = $uId;
    ");

    // print_r($SinglHistGZOOlss);die;
        return view('Users/singleAnalyticsShow',compact('alluserPQDetails','SinglHistGZOOlss','alluserVCDetails','alluserMEDetails','alluserGZDetails','userAnalytics'));
    }


    //// END-------------------

    
     //////////////////// Video class Single User Full History ////////////
   public function getSingleVideoCls(Request $request,$uId)
   {
   $userAnalytics= DB::table('user_details')->select('uId','name')->where('uId',$uId)->get();
   
    $alluserPQDetails = DB::select("
        SELECT  t5.*, t1.*, t2.*, t3.*, t4.*
        FROM `user_analytics` t4
        INNER JOIN `user_details` t3 ON t4.userId = t3.uId
        INNER JOIN `pq_main` t2 ON t4.examTypeId = t2.pqmainId
        INNER JOIN `pq_module` t1 ON t4.examModuleId = t1.pqmId
        INNER JOIN `pq_submodule` t5 ON t4.examSubModuleId = t5.pqsmId
        
        WHERE t4.`courseType`=2 and t4.`userId` = $uId ORDER BY t4.`aId` DESC
        LIMIT 1;
    ");
    $alluserVCDetails = DB::select("
    SELECT t5.*,t1.*,t2.*, t3.*, t4.*
    FROM `user_analytics` t4
    INNER JOIN `user_details` t3 ON t3.uId = t4.userId 
    INNER JOIN `vc_module` t1 ON t1.vcmId = t4.examModuleId
    INNER JOIN `vc_chapters` t2 ON t2.vcChapterId = t4.examSubModuleId
    INNER JOIN `vc_more_videos` t5 ON t5.vcVDId = t4.vcChapterVideoId
    WHERE t4.`courseType`=3 and t4.`userId` = $uId ORDER BY t4.`aId` DESC
    LIMIT 1;
    ");
    $alluserMEDetails = DB::select("
    SELECT   t1.*, t2.*, t3.*, t4.*
        FROM `user_analytics` t4
        INNER JOIN `user_details` t3 ON t4.userId = t3.uId
        INNER JOIN `module` t2 ON t4.examModuleId = t2.mId
        INNER JOIN `sub_module` t1 ON t4.examSubModuleId = t1.smId
    
        
        WHERE t4.`courseType`=1 and t4.`userId` = $uId ORDER BY t4.`aId` DESC
    LIMIT 1;
    ");
    $alluserGZDetails = DB::select("
    SELECT t4.*, t3_player.name AS playerName, t3_opponent.name AS opponentName,t3_winner.name AS winnerName
    FROM `user_analytics` t4 
    INNER JOIN `user_details` t3_player ON t4.playerId = t3_player.uId
    INNER JOIN `user_details` t3_opponent ON t4.opponentId = t3_opponent.uId
    INNER JOIN `user_details` t3_winner ON t4.winnerId = t3_winner.uId
    WHERE t4.userId = $uId ORDER BY t4.`aId` DESC
    LIMIT 1;

    ");

    $SinglHistVDClss= DB::select("
    SELECT t5.*,t1.*,t2.*, t3.*, t4.*
    FROM `user_analytics` t4
    INNER JOIN `user_details` t3 ON t3.uId = t4.userId 
    INNER JOIN `vc_module` t1 ON t1.vcmId = t4.examModuleId
    INNER JOIN `vc_chapters` t2 ON t2.vcChapterId = t4.examSubModuleId
    INNER JOIN `vc_more_videos` t5 ON t5.vcVDId = t4.vcChapterVideoId
    WHERE t4.`courseType`=3 and t4.`userId` =$uId;
    ");

    // print_r($SinglHistVClss);die;
        return view('Users/singleAnalyticsShow',compact('alluserPQDetails','SinglHistVDClss','alluserVCDetails','alluserMEDetails','alluserGZDetails','userAnalytics'));
    }



  
  
  


   
   // LIVE GAME HISTORIES SHOWING HERE FUNCTIONS
   public function getLiveGamesSingleHist(Request $request,$uId)
   {

   $userName= DB::table('user_details')->select('uId','name')->where('uId',$uId)->get();

    $SinglLiveGameHist= DB::select("
    SELECT mast.dateTime,hist.nickname,hist.totalQuestions,hist.attendedQuestions,hist.rightAns,hist.wrongAns,hist.score,user_winner.name as winnerName
    FROM  `livegame_master` as mast 
    JOIN `livegame_history` as hist ON hist.lgmId =mast.lgmId
    JOIN `user_details` as user_winner ON user_winner.uId= hist.winnerId
    
    WHERE hist.userId = $uId;

    ");

    // print_r($SinglHistGZOOlss);die;
        return view('Users/singleLiveGameHIstories',compact('SinglLiveGameHist','userName'));
    }




     // Revision function start here----------------------
    // Revision HISTORIES SHOWING HERE FUNCTIONS
   public function getSingleUserRevisionsdetails(Request $request,$uId)
   {

   $userName= DB::table('user_details')->select('uId','name')->where('uId',$uId)->get();

    $SinglRevisionHist= usersRevisionModel::select('u_RevId','dateAndTime','totalQuestions','QuestionsAttended','rightAns',
      'percentage')
      ->where('userId',$uId)
      ->get();
      
        return view('revision/SingleUserRevision_Hist',compact('SinglRevisionHist','userName'));
    }








}
