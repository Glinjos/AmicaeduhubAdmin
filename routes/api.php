<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiPreviousExamController;
use App\Http\Controllers\ApiVideoClassesController;
use App\Http\Controllers\ApiGameZoneController;
use App\Http\Controllers\ApiUserAnalyticsController;
use App\Http\Controllers\ApiExamBankController;
use App\Http\Controllers\ApiUserProfileController;
use App\Http\Controllers\ApiSubscriptionController;
use App\Http\Controllers\ApiUserChatController;
use App\Http\Controllers\ApiCrashCourseController;
use App\Http\Controllers\ApiLiveGameController;
use App\Http\Controllers\ApichatSuggestionController;
use App\Http\Controllers\ApiStatisticController;
use App\Http\Controllers\ApiReferralController;
use App\Http\Controllers\ApiPushNotificationController;
use Illuminate\Routing\Middleware\ThrottleRequests;
use App\Http\Controllers\ApiRevisionController;
use App\Http\Controllers\ApiImageBasedPreviousQuesController;
use App\Http\Controllers\ApiModelExamMEController;
use App\Http\Controllers\ApiReportQuestionController;
use App\Http\Controllers\ApiUpiddetailsController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});




// created by Sarath on 25-09-23
// for sending notifications using firebase fcm
Route::post('/send-notification', [ApiPushNotificationController::class, 'sendNotifications']);










//THIS MIDDLEWARE COMING FROM OUR APP SIDE ------------
Route::middleware(['CheckAmicaEduHub'])->group(function () {
    
//SIGNIN FORM
Route::post('/signup',[ApiPreviousExamController::class,'signup']);

//LOGIN FORM
Route::post('/login',[ApiPreviousExamController::class,'login']);

//OTP VERIFICATION
Route::post('/otp_validation',[ApiPreviousExamController::class,'otp_validation']);


});






// THIS FIELD TO START THE ONLINE TOKEN AND USER ID MATCH ONLY WORK THE API IS------------
Route::middleware(['checkUserToken'])->group(function () {











//SHOW CATOGORIES PMODULE
Route::post('/show_exam_catogories',[ApiPreviousExamController::class,'show_exam_catogories']);

//SHOW YEAR OF EXAM  SUB MODULE
Route::post('/exam_date',[ApiPreviousExamController::class,'exam_date']);

//SHOW PREVIOUS MODEL QUESTION 
Route::post('/show_previous_question_with_answer',[ApiPreviousExamController::class,'show_previous_question_with_answer']);


//SHOW ALL ADVERTISEMENT
Route::post('/advertisements',[ApiPreviousExamController::class,'advertisements']);

//SHOW ALL ADVERTISEMENT VIDEOS
Route::post('/advertisementsVideos',[ApiPreviousExamController::class,'advertisementsVideos']);

//SHOW ALL PREVIOUS QUESTION MAIN
Route::post('/getpqmain',[ApiPreviousExamController::class,'pqMain']);





//CREATED BY AKASH 19/05/2032 VIDEO CLASSES UPDATED 26/05/2023
//SHOW ALL MODULE
Route::post('/show_vc_module',[ApiVideoClassesController::class,'show_vc_module']);
//SHOW ALL CHAPTER
Route::post('/show_vc_chapter',[ApiVideoClassesController::class,'show_vc_chapter']);
//SHOW ALL CHAPTER
Route::post('/show_vc_moreVideo',[ApiVideoClassesController::class,'show_vc_moreVideo']);
//SHOW ALL QUESTION AND ANSWER
Route::post('/show_vc_examAns',[ApiVideoClassesController::class,'show_vc_examAns']);


// created by Sarath on 26-05-23
// storing game initialisation details
Route::post('/store_gz_init',[ApiGameZoneController::class,'storeGZInit']);
// storing game history details
Route::post('/store_gz_init_history',[ApiGameZoneController::class,'storeGZInitHistoryData']);

//CREATED BY AKASH 23/05/2032  GAME ZONE
//SHOW ALL MODULE
Route::post('/show_gz_module',[ApiGameZoneController::class,'show_gz_module']);
//SHOW ALL SUBMODULE
Route::post('/show_gz_submodule',[ApiGameZoneController::class,'show_gz_submodule']);
//SHOW ALL QUESTION AND ANSWER
Route::post('/show_gz_examAns',[ApiGameZoneController::class,'show_gz_examAns']);
//SHOW ALL USERS
Route::post('/show_gz_user',[ApiGameZoneController::class,'show_gz_user']);


// created by Sarath 02-06-23
// storing user analytics data
Route::post('/store_user_analytics',[ApiUserAnalyticsController::class,'storeUserAnalyticsData']);

// to check if the data is stored
Route::post('/show_user_analytics',[ApiUserAnalyticsController::class,'showUserAnalyticsData']);



//CREATED BY AKASH 07/06/2023  EXAM BANK
//MODULE WISE EXAM START
//SHOW ALL MODULE
Route::post('/show_module',[ApiExamBankController::class,'show_module']);
//SHOW ALL SUBMODULE
Route::post('/show_submodule',[ApiExamBankController::class,'show_submodule']);
//SHOW ALL QUESTION AND ANSWER
Route::post('/show_examAns',[ApiExamBankController::class,'show_examAns']);
//MODULE WISE EXAM END


//DAILY EXAM START
//SHOW ALL DAILY EXAM TIME,DATE,MODULE NAMES ETC
Route::post('/show_scheduleDailyExam',[ApiExamBankController::class,'show_scheduleDailyExam']);
//SHOW ALL DAILY EXAM QUESTIONS AND ANSWERS FROM TEM
Route::post('/show_questionsAns',[ApiExamBankController::class,'show_questionsAns']);
//DAILY EXAM END



//insert daily exam history
Route::post('/storeDailyExamHistory',[ApiExamBankController::class,'storeDailyExamHistory']);
//show daily exam history
Route::post('/showDailyExamHistory',[ApiExamBankController::class,'showDailyExamHistory']);
//show daily exam winners
Route::post('/showDailyExamWinners',[ApiExamBankController::class,'showDailyExamWinners']);
//show schedule exam for exam bank module show winners list
Route::post('/showDailyExamForViewWinners',[ApiExamBankController::class,'showDailyExamForViewWinners']);

// to save user details to the data base
Route::post('/save_user_profile',[ApiUserProfileController::class,'saveUserProfile']);

// to save profile photo
Route::post('/save_profile_photo',[ApiUserProfileController::class,'saveProfilePhoto']);


// created by Sarath on 19-06-23
// getting game invite by me
Route::post('/show_gz_invite_by_me',[ApiGameZoneController::class,'getGzInviteByMe']);
// getting game invite by others
Route::post('/show_gz_invite_by_others',[ApiGameZoneController::class,'getGzInviteByOthers']);
// to accept the game invite
Route::post('/accept_gz_invite',[ApiGameZoneController::class,'acceptGzInvite']);
// to decline the game invite
Route::post('/decline_gz_invite',[ApiGameZoneController::class,'declineGzInvite']);


//CREATED BY AKASH 21/06/2032  Subscription
//Subscription START
//SHOW ALL Subscription
Route::post('/show_subscription',[ApiSubscriptionController::class,'show_subscription']);
//Subscription END


// created by Sarath on 21-06-23
// getting game history data for game test summary
Route::post('/show_gz_history',[ApiGameZoneController::class,'getGzHistory']);
// storing game history details
Route::post('/store_gz_init_history',[ApiGameZoneController::class,'storeGZInitHistoryData']);

// to get profile details
Route::post('/fetch_profile_details',[ApiUserProfileController::class,'getProfileDetails']);



// created by Sarath on 23-06-23
// get count of game win of users for gamezone home
Route::post('/show_win_count',[ApiGameZoneController::class,'getWinCount']);
//get sum of game score of users for gamezone home
Route::post('/show_score_sum',[ApiGameZoneController::class,'getScoreSum']);


// get details of opponents in the game
Route::post('/show_gz_friends_list',[ApiGameZoneController::class,'getGZFriendsList']);
// get details of chapters in the game
Route::post('/show_gz_chapter_list',[ApiGameZoneController::class,'getGZChapterList']);

//get details of gameinit for the subjectwise game
Route::post('/show_gzinit_subjectwise',[ApiGameZoneController::class,'getGZInitSubjectwise']);


// created by AKASH on 20-07-2023
//Start Crash Course
//Show crash course subscriptions
Route::post('/show_ccSubscription',[ApiCrashCourseController::class,'show_ccSubscription']);
//show crash course batch using user id
Route::post('/show_ccBatch',[ApiCrashCourseController::class,'show_ccBatch']);
//show crash course batch days using batch id
Route::post('/show_ccBatchDays',[ApiCrashCourseController::class,'show_ccBatchDays']);
//show crash course examAns using smId
Route::post('/show_ccQuestionAns',[ApiCrashCourseController::class,'show_ccQuestionAns']);
//End Crash Course

//store crash course exam history
Route::post('/storeCcExamHistory',[ApiCrashCourseController::class,'storeCcExamHistory']);

//view crash course exam history
Route::post('/show_CcExamHistory',[ApiCrashCourseController::class,'show_CcExamHistory']);




// created by Sarath on 25-07-23
// storing live game master details
Route::post('/store_lg_master',[ApiLiveGameController::class,'storeLGMaster']);
// getting live game master data
Route::post('/show_lg_master',[ApiLiveGameController::class,'showLGMaster']);
// show livegame questions
Route::post('/show_lg_ques_ans',[ApiLiveGameController::class,'showLGQues']);
// storing live game history
Route::post('/store_lg_history',[ApiLiveGameController::class,'storeLGHistory']);
// showing live game history
Route::post('/show_lg_history',[ApiLiveGameController::class,'showLGHistory']);
// update live game master details when the user exited the game
Route::post('/lg_exited',[ApiLiveGameController::class,'lgExited']);




//store crash course user subscription
Route::post('/storeCcUserSubscription',[ApiCrashCourseController::class,'storeCcUserSubscription']);




//  USERS PLAN INSERTING INTO APP SUBSCRIBERS TABLE
Route::post('/save_users_subscribed_plan',[ApiSubscriptionController::class,'save_users_subscribed_plan']);


// 07-08-2023
// get subscribers details-------------
Route::post('/getusersubscriptions_app',[ApiSubscriptionController::class,'getusersubscriptions_app']);





//SHOW ALL check_userInScheduleDailyExam
Route::post('/check_userInScheduleDailyExam',[ApiExamBankController::class,'check_userInScheduleDailyExam']);










// suggestion and IDEAS API START HERE---------------

Route::post('/savesuggestionsMain',[ApichatSuggestionController::class,'savesuggestionsMain']);

Route::post('/savesuggestionsSUB',[ApichatSuggestionController::class,'savesuggestionsSUB']);






// suggestion and IDEAS API END HERE---------------

//18.09.2023
//update name
Route::post('/updateName',[ApiUserProfileController::class, 'updateName']);






//Start Statistic
//this function call for viewing statics
Route::post('/show_Statistics',[ApiStatisticController::class,'show_Statistics']);
//End Statistic






//Start Referral
//store user bank details
Route::post('/storeUserBankDetails',[ApiReferralController::class,'storeUserBankDetails']);
//store users coin request
Route::post('/storeUserCoinRequests',[ApiReferralController::class,'storeUserCoinRequests']);
//fetch my referral code
Route::post('/showMyReferralCode',[ApiReferralController::class,'showMyReferralCode']);
//fetch my referred users details
Route::post('/showMyReferredUserDetails',[ApiReferralController::class,'showMyReferredUserDetails']);
//fetch coin prize
Route::post('/showCoinPrize',[ApiReferralController::class,'showCoinPrize']);
//show user bank details
Route::post('/showUserBankDetails',[ApiReferralController::class,'showUserBankDetails']);
//show my coins sum
Route::post('/showSumCoins',[ApiReferralController::class,'showSumCoins']);
//show my ledger
Route::post('/showMyLedger',[ApiReferralController::class,'showMyLedger']);
//store users referral details in two tabled leder,user details
Route::post('/storeReferAmount',[ApiReferralController::class,'storeReferAmount']);
// UPDATE BANK DETAILS
Route::post('/updateUserBankDetails',[ApiReferralController::class,'updateUserBankDetails']);

//End Referral




// created by Sarath on 04-09-23
// checking gamezone result exist or not
Route::post('/is_gz_result_exist',[ApiGameZoneController::class, 'isGzResultExist']);
//End 




//View image based questions
Route::post('/show_image_previous_que_ans',[ApiImageBasedPreviousQuesController::class,'show_image_previous_que_ans']);



//model exam me start
    //view model exam me names
    Route::post('/show_modelExam_name',[ApiModelExamMEController::class,'show_modelExam_name']);
    //view model exam me question and answers
    Route::post('/show_modelExam_qus_ans',[ApiModelExamMEController::class,'show_modelExam_qus_ans']);
//model exam me end







// created by Sarath on 07-09-23
// for showing districts
Route::post('/show_districts',[ApiUserProfileController::class, 'showDistricts']);
//store district data to user profile
Route::post('/store_district_to_profile',[ApiUserProfileController::class, 'storeDistrictsToProfile']);
//store dob to user profile
Route::post('/store_dob',[ApiUserProfileController::class, 'storeDOB']);



//store users coin in credit app plan subscription time
Route::post('/storeCreditAppSub',[ApiReferralController::class,'storeCreditAppSub']);


//Report question
Route::post('/report_question',[ApiReportQuestionController::class,'report_question']);


//check user Id in crash course subscription table
Route::post('/checkUidCcSub',[ApiCrashCourseController::class,'checkUidCcSub']);

//revison
Route::post('/storeUserRevisionsData',[ApiRevisionController::class,'storeUserRevisionsData']);


Route::post('/get_upi_details',[ApiUpiddetailsController::class,'get_upi_details']);



//CREATED BY vishnuu 21/06/2023  user doubts --api--insert
//get chat type
Route::post('/getchattype',[ApiUserChatController::class,'getchattypeamica']);
//insert main quest
Route::post('/saveUserchatquestions',[ApiUserChatController::class,'storeUserchatquestions']);
// add question in sub
Route::post('/saveUserchatquestionssub',[ApiUserChatController::class,'storeUserchatquestionssub']);
// show all users question answers----
Route::post('/showUserDoubtAnswer',[ApiUserChatController::class,'showUserDoubtAnswerData']);
// close chat----
Route::post('/closechat',[ApiUserChatController::class,'closeuserchat']);
// user id use to question close chat or not----
Route::post('/userQuestionshow',[ApiUserChatController::class,'showuserquestions']);
//show question and answer in chat model show date and time base
//Route::post('/showUserChatQuestandAns',[ApiUserChatController::class,'showuserchatsquestandansapi']);
Route::middleware(ThrottleRequests::class . ':100,1')->group(function () {
    Route::post('/showUserChatQuestandAns', [ApiUserChatController::class, 'showuserchatsquestandansapi']);
});









}); //checkonlinetoken










