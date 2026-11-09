<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PQuestionController;
use App\Http\Controllers\AdvertisementController;
use App\Http\Controllers\videoclassController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\usersController;
use App\Http\Controllers\ModelExmController;
use App\Http\Controllers\AuthorizerController;
use App\Http\Controllers\StaffAdminController;
use App\Http\Controllers\UserQuestionsController;
use App\Http\Controllers\CrashCourseController;
use App\Http\Controllers\refferedUsersController;
use App\Http\Controllers\ApiPushNotificationController;
use App\Http\Controllers\ImagePQAController;
use App\Http\Controllers\QwiseModelExamController;
use App\Http\Controllers\PlanvalidityController;
use App\Http\Controllers\ReportQuestionController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', [AdminController::class, 'categoryInput']);

Route::get('/insert', [AdminController::class, 'categoryInsert']);*/


//////////insert,edit , update , delete module///////

//the route back

 Route::group(['middleware' => 'prevent-back-history'],function(){



Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);





Route::middleware(['auth'])->group(function () {




Route::middleware(['SuperAdminRoutes'])->group(function () {

// ADMIN AREA
Route::get('/createModule', [AdminController::class, 'createModule']);
Route::post('addModule', [AdminController::class, 'storeModule']);
//AJAX module code check
Route::get('/mCodeCheck',[AdminController::class,'moduleCodeCheck']);
Route::get('/mNameCheck',[AdminController::class,'moduleNameCheck']);
Route::get('/updateModule{mId}', [AdminController::class, 'updateModuleForm']);
Route::post('ModuleUpdate/{mId}', [AdminController::class, 'updateModule']);
Route::get('/ModuleDisable/{mId}', [AdminController::class, 'disableModule']);
Route::get('/ModuleEnable/{mId}', [AdminController::class, 'EnableModule']);
//
Route::get('/toSubmodule',[AdminController::class,'index']);
Route::post('addsub',[AdminController::class,'addsub']);
Route::get('/submNameCheck',[AdminController::class,'submoduleNameCheck']);
Route::get('/smcodecheck',[AdminController::class,'smCodeFunction']);
Route::get('/updateSubModule{smId}', [AdminController::class, 'updateSubModuleForm']);
Route::post('subModuleUpdate/{smId}', [AdminController::class, 'updateSubModule']);
Route::get('/subModuleInactive/{smId}', [AdminController::class, 'subModuleInactive']);
Route::get('/subModuleActive/{smId}', [AdminController::class, 'subModuleActive']);
// AJAX ROUTE submodule
Route::get('/subModuleCheck',[AdminController::class,'subModuleCheck']);
Route::post('/questionSave',[AdminController::class, 'postQues']);
Route::get('/viewQA',[AdminController::class,'viewQA']);
///viewing questions and editing questions
Route::get('/toQA', [AdminController::class, 'viewModule']);
Route::get('/showQA',[AdminController::class, 'showQuestions']);
Route::get('/questionTake',[AdminController::class,'questionTake']);
//Route::post('/questionUpdate',[AdminController::class,'questionUpdate']);
Route::get('/updateQuestion{cqId}', [AdminController::class, 'updateQuestionForm']);
Route::post('/questionUpdate', [AdminController::class, 'questionUpdate']);
//
Route::get('/questionDelete/{questionId}',[AdminController::class, 'deleteQuestion']);
Route::get('/Moduleshow',[AdminController::class, 'Moduleshow']);
///show draft questions and editing questions
Route::get('/draftMainExam',[AdminController::class, 'showdraftQuestions']);
Route::get('/questiondraftTake',[AdminController::class,'questionDraftTake']);
//
Route::get('/updatedraftQuestion{cqId}', [AdminController::class, 'updatedraftQuestionForm']);
Route::post('/questiondraftUpdate', [AdminController::class, 'mainExmquestionDraftUpdate']);
//
Route::get('/questiondraftDelete/{questionId}',[AdminController::class, 'deleteDraftQuestion']);
Route::get('/Moduledraftshow',[AdminController::class, 'ModuleDraftshow']);
Route::get('/subModuledraftCheck',[AdminController::class,'subdraftModuleCheck']);
//APPROVING
Route::get('/ApproveMainexam/{questionId}', [AdminController::class, 'MEapproving']);
Route::get('/RefuseMainExam/{questionId}', [AdminController::class, 'MErefusing']);
//////////////  END MAIN EXAM --- DRAFT ---------- APPROVING----------------------------
//AJAX USED DATATABLE SORT AND VIEW MODULE ID MATCHED DATAS ONLY
//search wise show module
Route::get('/searchmodulewisesubmshow',[AdminController::class,'searchmodulewisesubmoduleshow']);
//SUPER ADMIN LIVE GAME HISTORY
Route::middleware(['SuperAdminRoutes'])->group(function () {
Route::get('/showuserlivegamehist',[AdminController::class,'showuserlivegamehist']);
Route::get('/singleuserLG_History_view{playerId}',[AdminController::class,'singleuserLG_History_view']);
});
// AJAX USED TO TAKE OPPONENT DETAILS AND ACTIVITY
Route::get('/Opponent_details',[AdminController::class,'Opponent_details']);
// super admin submodule wise question bank questions----------------------------------
Route::get('/submodulewiseqbmainexamad',[AdminController::class,'submodulewisesupadmincheckingform']);
// // AJAX ROUTE submodule
Route::get('/subModulewisesupadchekauthorCheck',[AdminController::class,'supadminsubModulewiseauthorizerCheck']);
// // form get  submodule wise main exam questions--
Route::get('/searchsupadminmainexam',[AdminController::class,'submodulewisesupadminmainexam']);
// ///show  questions and editing questions
Route::get('/questionsupadminsubmmainTake',[AdminController::class,'questionsupadminsubmmainTake']);
Route::get('/updatesupadminmeexmQuestion{cqId}', [AdminController::class, 'updatesupadminmesubmodulewisemainexmQuestionForm']);
Route::post('/questionsupadminupdatesubmmainexamUpdate', [AdminController::class, 'mainExmsubmodulewisequestionsupadminupdateUpdate']);
Route::get('/questionsupadminsubmmainDelete/{questionId}',[AdminController::class, 'deletesupadminmesubmodulewisemainexmQuestion']);
Route::get('/Moduleeditsupadminsubmmainexmshow',[AdminController::class, 'Modulesupadminsubmmainexmshow']);
Route::get('/subModulesupadmineditsubmmainexmCheck',[AdminController::class,'subsubmodulewisemainexmModulesupadminCheck']);
// end--------------------------show sub module wise--
// SUPER ADMIN approving submodule wise question bank questions----------------------------------
Route::get('/submodulewiseapproveqbmain',[AdminController::class,'submodulewiseapproveqbmain']);
// AJAX ROUTE submodule
Route::get('/subModulewisesadminchekauthorCheck',[AdminController::class,'superadminsubModulewiseauthorizerCheck']);
// // form get drafted submodule wise main exam questions--
Route::get('/getdraftapprovingmainexamsadmin',[AdminController::class,'submodulewisesuperadminapprovingdraftmainexam']);
// ///show draft questions and editing questions
Route::get('/questionsadminsubmmaindraftTake',[AdminController::class,'questionsadminsubmodulewisemainexmDraftTake']);
Route::get('/updatesadminsubmmaindraftexmQuestion{cqId}', [AdminController::class, 'updatesadmindraftsubmodulewisemainexmQuestionForm']);
Route::post('/questionsadmindraftsubmmainexamUpdate', [AdminController::class, 'mainExmsubmodulewisesadminquestionDraftUpdate']);
Route::get('/questionsadmindraftsubmmainDelete/{questionId}',[AdminController::class, 'deletesadminDraftsubmodulewisemainexmQuestion']);
Route::get('/Modulesadmindraftsubmmainexmshow',[AdminController::class, 'ModulesadminsubmmainexmDraftshow']);
Route::get('/subModulesadminsubmmainexmdraftCheck',[AdminController::class,'subdraftsadminsubmodulewisemainexmModuleCheck']);
// // // //APPROVING
Route::get('/ApprovesadminsubmmainexmMainexam/{questionId}', [AdminController::class, 'MEsubmodulewisesadminmainexmapproving']);
// end--------------------------approve--
// SUPER ADMIN--CHATS HANDLING --ROUTES---
Route::middleware(['SuperAdminRoutes'])->group(function () {
Route::get('/showquestionsformsupadmin',[AdminController::class,'showquestionsformAdmin']);
Route::get('/showchatsupadminsubquestions{chatQuestionId}',[AdminController::class,'showsubchatquestionformainquest']);
//adda nswer
Route::post('/addchatsupadminans',[AdminController::class,'addchatanswerquestion']);
//END
});
/// cFOR DASHBOARD SUP ADMIN
Route::get('/main_exam_totalcount_geting',[AdminController::class,'main_exam_totalcount_geting']);
Route::get('/pqcseb_totalcount_geting',[AdminController::class,'pqcseb_totalcount_geting']);
Route::get('/pqpsc_totalcount_geting',[AdminController::class,'pqpsc_totalcount_geting']);
//END
// EXCEL DOWNLOAD
//MAIN EXAM
Route::post('/excelgetmainexamdwnld',[AdminController::class,'excelgetmainexamdwnld']);
Route::post('/excelgetFilteredmainexamdwnld',[AdminController::class,'excelgetFilteredmainexamdwnld']);
// ADMIN AREA END

});
// END MAIN EXAM CHAT EXCEL SUPERADMN MIDDLE



   
});



//Previous year question

Route::middleware(['auth'])->group(function () {






// STAFFADMIN AREAD
Route::middleware(['StaffAdminRoute'])->group(function () {
// ADmin dashboard
Route::get('/staffadminDashboard',[StaffAdminController::class,'index']);
// CHATS--------------
});
// user chat super admin side route----------------------
Route::middleware(['SuperAdminRoutes'])->group(function () {
Route::get('/showuserdoubts',[StaffAdminController::class,'showUserChat']);
});
//assign
Route::get('/userquestionassign/{parameter}',[StaffAdminController::class,'assignquestiontoadmin']);
//unassign
Route::get('/userquestionunassign/{parameter}',[StaffAdminController::class,'unassignquestiontoadmin']);
// ADMIN--CHATS HANDLING --ROUTES---
Route::middleware(['StaffAdminRoute'])->group(function () {
Route::get('/showquestionsform',[StaffAdminController::class,'showquestionsformAdmin']);
});
//add answer
Route::post('/addanswer',[StaffAdminController::class,'addanswerquestion']);
//take answer
Route::get('/questionTakeandAnswer',[StaffAdminController::class,'questionTakeandAnsweradmin']);
//view more
Route::get('/questionTakeandAnswerview',[StaffAdminController::class,'questionTakeandAnswerviewmore']);
//edit answer
Route::post('/updateanswerform',[StaffAdminController::class,'updateansweradmin']);
// chats foe admin---
//showing sub questions
// Route::get('/showsubquestions{chatQuestionId}',[StaffAdminController::class,'showsuballquestionformainquest']);
Route::middleware(['StaffAdminRoute'])->group(function () {
Route::get('/showchatsubquestions{chatQuestionId}',[StaffAdminController::class,'showsubchatquestionformainquest']);
});
//adda nswer
Route::post('/addchatans',[StaffAdminController::class,'addchatanswerquestion']);
//END STAFF AREA













// STAFF AREA
// staffmainexam
Route::middleware(['EmployeeStaffRoute'])->group(function () {
///viewing questions and editing questions
Route::get('/tostaffmainexamQA', [StaffController::class, 'viewQuestionAddingForm']);
// AJAX ROUTE submodule
Route::get('/subModulestaffCheck',[StaffController::class,'subModuleStaffsCheck']);
Route::post('/questionstaffSave',[StaffController::class, 'poststaffQues']);
//show mainexam quest
Route::get('/showstaffmainexamQA',[StaffController::class, 'showstaffQuestions']);
Route::get('/questionstaffsTake',[StaffController::class,'questionstaffmaineexmTake']);
//update
Route::get('/updatestaffQuestion{cqId}', [StaffController::class, 'updatestaffmainexmQuestionForm']);
Route::post('/questionstaffMEUpdate', [StaffController::class, 'questionstaffmainexmUpdate']);
Route::get('/questionstaffDelete/{questionId}',[StaffController::class, 'deletestaffmainexamQuestion']);
Route::get('/ModulestaffMEshow',[StaffController::class, 'Modulestaffmainexmshow']);
Route::get('/subModuleupdatemestaffCheck',[StaffController::class, 'subModulestaffupdateCheck']);
//end staffmainexam
});
Route::middleware(['EmployeeStaffRoute'])->group(function () {
////// STAFFS ROUTE START HERE-----------------------------------------------------------
Route::get('/staffDashboard', [StaffController::class, 'index']);
});
//pq add
Route::middleware(['EmployeeStaffRoute'])->group(function () {
Route::get('/stafftoPQA', [StaffController::class, 'addPQA']);
Route::get('/staffpqSubModuleCheck',[StaffController::class,'pqSubModuleCheck']);
Route::get('/staffpqModuleCheckformain',[StaffController::class,'pqModuleCheckformain']);
Route::post('/previousQuestionSaveStaff',[StaffController::class, 'postPreQues']);
//show PQA
Route::get('/staffshowPQA',[StaffController::class, 'showPQA']);
Route::get('/workerPquestionTake',[StaffController::class,'PquestionTake']);
Route::get('/PmoduleShow',[StaffController::class, 'PmoduleShow']);
Route::get('/workerPquestionDelete/{questionId}',[StaffController::class, 'deletePQuestion']);
// Route::post('/PquestionUpdate',[StaffController::class,'PquestionUpdate']);
});
//Additional
Route::get('/workersExamTypeshow',[StaffController::class, 'ExamTypeshow']);
Route::get('/workersCategoryshow',[StaffController::class, 'Categoryshow']);
Route::get('/workerssubCategoryshow',[StaffController::class,'subCategoryshow']);
//update previous questions
Route::middleware(['EmployeeStaffRoute'])->group(function () {
Route::get('/workersupdatePQQuestion{pqId}', [StaffController::class, 'updatePreviousQuestionForm']);
Route::post('/workersPreviousQuestionUpdate', [StaffController::class, 'PquestionUpdate']);
});
/// STAFFS VIDEO CLASS EXAM QUESTION ADDS--------------------------------------------------------
Route::middleware(['EmployeeStaffRoute'])->group(function () {
//vc staff exam  add
Route::get('/vcexamformstaff', [StaffController::class, 'vcStaffAddExamForm']);
Route::get('/vcstaffChapterCheck',[StaffController::class,'vcStaffChaptersCheck']);
Route::get('/videomorestaffCheck',[StaffController::class,'videomoreStaffCheck']);
//Route::get('/vcModuleCheckformaindta',[StaffController::class,'vcModuleCheckformaindtaa']);
Route::post('/vcExamSavestaff',[StaffController::class, 'postvdeoClsQuesStaff']);
//Staff show VCQA
Route::get('/vcstaffshowexam',[StaffController::class, 'showstaffVCQA']);
Route::get('/VCquestionTakestaff',[StaffController::class,'vCstaffquestionTake']);
Route::get('/VCQuestionDeletestaff/{questionId}',[StaffController::class, 'deletestaffVCQuestion']);
Route::get('/subjectshowstaff',[StaffController::class, 'subjectstaffshow']);
Route::get('/chaptershowstaff',[StaffController::class,'chapterstaffshow']);
Route::get('/morevideocheckstaff',[StaffController::class,'morevideostaffcheck']);
// //update staff video class exam
Route::get('/EditVCQuestion{questionId}',[StaffController::class, 'updatestaffVideoClassForm']);
Route::post('/VideoClassStaffUpdate', [StaffController::class, 'VcstaffquestionUpdate']);
//END STAFF AREA
});
Route::middleware(['SuperAdminRoutes'])->group(function () {
Route::get('/show_user-entered-quest', [StaffController::class, 'show_user_entered_quest']);
Route::post('/report_useraddedquest_monthwise', [StaffController::class, 'report_useraddedquest_monthwise']);
});








// PREVIOUS QUESTION AREA
//  SUPER ADMIN show and approve sub module wise previous questions----
Route::middleware(['SuperAdminRoutes'])->group(function () {
//show PQA sub module wise
Route::get('/draftfilterqapqsadmin',[PQuestionController::class, 'showPQAsmamicasadmin']);
// Route::get('/PQAauthorsubcategory',[PQuestionController::class,'PQAauthorsubmodulecheck']);
Route::get('/PquestionsadmindraftDeletesub/{questionId}',[PQuestionController::class, 'deletePQsadminsubmoduleview']);
Route::get('/updatePQsadminsub{pqId}', [PQuestionController::class, 'updatesubPrevioussadminQuestionForm']);
Route::post('/PrevioussadminQuestionSMUpdate', [PQuestionController::class, 'PquestionsadminSubMUpdate']);
Route::get('/QuestsadminExamTypeshow',[PQuestionController::class, 'pqsmsadminExamTypeshow']);
Route::get('/QuestsadminCategoryshow',[PQuestionController::class, 'pqsmsadminCategoryshow']);
Route::get('/QuestsadminssubCategoryshow',[PQuestionController::class,'pqsmsadminsSubCategoryshow']);
// //approve subcategory wise
Route::get('/approvePQSubmsadmin/{parameter}', [PQuestionController::class, 'PQapprovingsubcategorywisesadmin']);
// Route::get('/RefusesubmPQauthor/{parameter}', [PQuestionController::class, 'PQsubcatewiserefusingauthor']);
// // new show subm wise quest checking
Route::get('/sadminsubcategorypq',[PQuestionController::class,'sadminsubmodulecheckpq']);
// END----------
//  super admin show  sub module wise previous questions----
//show PQA sub module wise
Route::get('/showpqfilter',[PQuestionController::class, 'showpqfilteradminSuper']);
// // new show subm wise quest checking
Route::get('/subcategorypqshowadmin',[PQuestionController::class,'subcategorypqshowadminsuper']);
Route::get('/PquestionsupadminDeletesub/{questionId}',[PQuestionController::class, 'deletePQsupadminsubmoduleview']);
Route::get('/updatePQadminsuper{pqId}', [PQuestionController::class, 'updatesubPreviousadminQuestionForm']);
Route::post('/PrevioussupadminQuestionSMUpdate', [PQuestionController::class, 'PquestionsupadminSubMUpdate']);
Route::get('/QuestsuperadminExamTypeshow',[PQuestionController::class, 'pqsmsupadminExamTypeshow']);
Route::get('/QuestsupadminCategoryshow',[PQuestionController::class, 'pqsmsupadminCategoryshow']);
Route::get('/QuestsupadminsubCategoryshow',[PQuestionController::class,'pqsmsupadminSubCategoryshow']);
// END PREVIOUS FILTERED-----------
//search wise previous question subactegory
Route::get('/searchexamyearbasesubcategory',[PQuestionController::class,'searchexamyearbasesubcategoryshow']);
//search exam type base wise previous question subactegory
Route::get('/searchmainexmsubcategory',[PQuestionController::class,'searchmainexmsubcategory']);
//search exam type base wise previous question category
Route::get('/searchexmtypecategory',[PQuestionController::class,'searchexmtypecategory']);
//add category
Route::get('/category', [PQuestionController::class, 'Category']);
Route::post('/addCategory', [PQuestionController::class, 'addCategory']);
Route::get('/updateCategory{pqmId}', [PQuestionController::class, 'updateCategoryForm']);
Route::post('/categoryUpdate/{pqmId}', [PQuestionController::class, 'updateCategory']);
Route::get('/pqmNameCheck',[PQuestionController::class,'categoryNameCheck']);
Route::get('/CategoryDisable/{pqmId}', [PQuestionController::class, 'disableCategory']);
Route::get('/CategoryEnable/{pqmId}', [PQuestionController::class, 'EnableCategory']);
Route::get('/categoryDelete/{pqmId}', [PQuestionController::class, 'categoryDelete']);
//Subcategory
Route::get('/subcategory', [PQuestionController::class, 'subCategory']);
Route::post('/addsubcategory', [PQuestionController::class, 'addsubcategory']);
Route::get('/subcAjNameCheck',[PQuestionController::class,'subcategoryAjaxNameCheck']);
Route::get('/updateSubCategory{pqsmId}', [PQuestionController::class, 'updateSubCategoryForm']);
Route::post('/subCategoryUpdate/{pqsmId}', [PQuestionController::class, 'updateSubCategory']);
//Route::get('/subCategoryCheck',[PQuestionController::class,'subCategoryNameCheck']);
Route::get('/subCategoryDisable/{pqsmId}', [PQuestionController::class, 'disableSubCategory']);
Route::get('/subCategoryEnable/{pqsmId}', [PQuestionController::class, 'EnableSubCategory']);
Route::get('/subCategoryDelete/{pqsmId}', [PQuestionController::class, 'subCategoryDelete']);
//pq add
Route::get('/toPQA', [PQuestionController::class, 'addPQA']);
});
Route::get('/pqModuleCheckformain',[PQuestionController::class,'pqModuleCheckformain']);
Route::get('/pqSubModuleCheck',[PQuestionController::class,'pqSubModuleCheck']);
Route::middleware(['SuperAdminRoutes'])->group(function () {
Route::post('/previousQuestionSave',[PQuestionController::class, 'postPreQues']);
//show PQA
Route::get('/showPQA',[PQuestionController::class, 'showPQA']);
Route::get('/PquestionTake',[PQuestionController::class,'PquestionTake']);
Route::get('/PmoduleShow',[PQuestionController::class, 'PmoduleShow']);
Route::get('/PquestionDelete/{questionId}',[PQuestionController::class, 'deletePQuestion']);
Route::post('/PquestionUpdate',[PQuestionController::class,'PquestionUpdate']);
Route::get('/ExamTypeshow',[PQuestionController::class, 'ExamTypeshow']);
Route::get('/Categoryshow',[PQuestionController::class, 'Categoryshow']);
Route::get('/subCategoryshow',[PQuestionController::class,'subCategoryshow']);
//update previous questions
Route::get('/updatePQQuestion{pqId}', [PQuestionController::class, 'updatePreviousQuestionForm']);
Route::post('/PreviousQuestionUpdate', [PQuestionController::class, 'PquestionUpdate']);
//END
});
Route::middleware(['SuperAdminRoutes'])->group(function () {
// previous questions main
Route::get('/pqmain', [PQuestionController::class, 'pqMainForm']);
Route::post('/addpqmain', [PQuestionController::class, 'addpqmainForm']);
Route::get('/pqmainNameCheck',[PQuestionController::class,'PQExamNameCheck']);
Route::get('/updatePQmain{pqmainId}', [PQuestionController::class, 'updatePQExamMainForm']);
Route::post('/examMainUpdate/{pqmainId}', [PQuestionController::class, 'updateExamMain']);
Route::get('/examMainDelete/{pqmainId}', [PQuestionController::class, 'examMainDelete']);
Route::get('/ExamTypeDisable/{pqmainId}', [PQuestionController::class, 'disableExamType']);
Route::get('/ExamTypeEnable/{pqmId}', [PQuestionController::class, 'ExamTypeEnable']);
/// APPROVING STAFFS ADDED PREVIOUS QUESTIONS AND ISAVAIL = 2 ---
Route::get('/draftPQA',[PQuestionController::class,'workersShowQ']);
Route::get('/draftPquestionTake',[PQuestionController::class,'PquestionTake']);
// Route::get('/PmoduleShow',[PQuestionController::class, 'PmoduleShow']);
Route::get('/draftPquestionDelete/{questionId}',[PQuestionController::class, 'draftdeletePQuestion']);
// Route::post('/PquestionUpdate',[PQuestionController::class,'PquestionUpdate']);
// //Additional
Route::get('/draftExamTypeshow',[PQuestionController::class, 'draftExamTypeshow']);
Route::get('/draftCategoryshow',[PQuestionController::class, 'draftCategoryshow']);
Route::get('/draftsubCategoryshow',[PQuestionController::class,'draftsubCategoryshow']);
// //update previous questions
Route::get('/draftupdatePQQuestion{pqId}', [PQuestionController::class, 'draftupdatePreviousQuestionForm']);
Route::post('/draftPreviousQuestionUpdate', [PQuestionController::class, 'draftPquestionUpdate']);
//APPROVING
Route::get('/ApprovePQ/{questionId}', [PQuestionController::class, 'PQapproving']);
Route::get('/RefusePQ/{questionId}', [PQuestionController::class, 'PQrefusing']);
//PREVIOUS EXAM EXCEL DOWNLOAD
Route::post('/excelgetpreviousexamdwnld',[PQuestionController::class,'excelgetpreviousexamdwnld']);
Route::post('/excelgetFilteredpreviousexamdwnld',[PQuestionController::class,'excelgetFilteredpreviousexamdwnld']);
// END PREVIOUS QUESTION AREA
});
// TOP PERFORMERS ROUTE START HERE
Route::middleware(['SuperAdminRoutes'])->group(function () {
Route::get('/showtopperformes', [PQuestionController::class, 'showtopperformes']);
Route::post('/report_of_topstudents', [PQuestionController::class, 'report_of_topstudents']);
});
//END TOP PERFORMERS ROUTE












// VIDEO CLASS AREA
// VIDEO CLASSES ROUTE START-----------------------------------------------------------------------------
Route::middleware(['SuperAdminRoutes'])->group(function () {
//THE MODULE(SUBJECT START)
Route::get('/vcmoduleform', [videoclassController::class, 'vcmoduleformamica']);
Route::post('/addvcmodule', [videoclassController::class, 'addvcmoduleamica']);
Route::get('/vcmNameCheck', [videoclassController::class, 'ajaxvcNamecheck']);
Route::get('/vcmUpdateNameCheck', [videoclassController::class, 'ajaxvcUpdateNamecheck']);
Route::get('/updatesubject{vcmId}', [videoclassController::class, 'updatesubjectForm']);
Route::post('subjectUpdate/{vcmId}', [videoclassController::class, 'subjectEditData']);
Route::get('/subjectDisable/{vcmId}', [videoclassController::class, 'disablesubject']);
Route::get('/subjectEnable/{vcmId}', [videoclassController::class, 'EnableSubject']);
Route::get('/subjectDelete/{vcmId}', [videoclassController::class, 'subjectDelete']);
// ADD VIDEO CLASS CHAPTERS
Route::get('vcchapterform',[videoclassController::class,'vcchapterformamica']);
Route::get('/chapterAjNameCheck',[videoclassController::class,'chapterAjaxNameCheck']);
Route::get('/vcModuleCheckformain',[videoclassController::class,'vcModuleCheckformain']);
Route::post('/addchapter', [videoclassController::class, 'addvcchapteramica']);
Route::get('/updatechapter{vcChapterId}', [videoclassController::class, 'updatevcchapterForm']);
Route::get('/chapterUpdateAjNameCheck',[videoclassController::class,'chapterUdateAjNameCheck']);
Route::post('chapterUpdate/{vcChapterId}', [videoclassController::class, 'chapterUpdateData']);
Route::get('/chapterDisable/{vcChapterId}', [videoclassController::class, 'disablechapter']);
Route::get('/chapterEnable/{vcChapterId}', [videoclassController::class, 'Enablechapter']);
Route::get('/chapterDelete/{vcChapterId}', [videoclassController::class, 'deletechapter']);
//////// VIDEOS ADDING -------MORE VIDEOS----------
Route::get('/addvideos', [videoclassController::class, 'addmorevideos']);
Route::get('/subjectCheckvideo', [videoclassController::class, 'subjectCheckforvideo']);
Route::post('/addvideodetails', [videoclassController::class, 'addvideodatas']);
Route::get('/videoDelete/{vcVDId}',[videoclassController::class, 'deletevideoclss']);
Route::get('/updatevideo{vcVDId}',[videoclassController::class, 'updatevideoform']);
Route::post('/videoclsUpdateformdta/{vcVDId}', [videoclassController::class, 'videoclsUpdatevcMVtbl']);
//vc EXAM  add
Route::get('/vcexamform', [videoclassController::class, 'vcAddExamForm']);
Route::get('/vcChapterCheck',[videoclassController::class,'vcChaptersCheck']);
Route::get('/videomoreCheck',[videoclassController::class,'videomoreCheck']);
Route::get('/vcModuleCheckformaindta',[videoclassController::class,'vcModuleCheckformaindtaa']);
Route::post('/vcExamSave',[videoclassController::class, 'postvdeoClsQues']);
//show VCQA
Route::get('/vcshowexam',[videoclassController::class, 'showVCQA']);
Route::get('/VCquestionTake',[videoclassController::class,'vCquestionTake']);
// Route::get('/PmoduleShow',[videoclassController::class, 'PmoduleShow']);
Route::get('/VCQuestionDelete/{questionId}',[videoclassController::class, 'deleteVCQuestion']);
Route::get('/subjectshow',[videoclassController::class, 'subjectshow']);
Route::get('/chaptershow',[videoclassController::class,'chaptershow']);
Route::get('/morevideocheck',[videoclassController::class,'morevideocheck']);
//update video class exam
Route::get('/updateVCQuestion{questionId}', [videoclassController::class, 'updateVideoClassForm']);
Route::post('/VideoClassUpdate', [videoclassController::class, 'VcquestionUpdate']);
/// APPROVING STAFFS ADDED VIDEO CLASS QUESTIONS AND ISAVAIL = 2 ---
Route::get('/draftVCQA',[videoclassController::class,'workersVclassShowQ']);
Route::get('/draftVCuestionTake',[videoclassController::class,'draftVcQuestionTake']);
Route::get('/draftVCquestionDelete/{questionId}',[videoclassController::class, 'draftdeleteVcQuestion']);
// // 
});
// End
Route::middleware(['SuperAdminRoutes'])->group(function () {
//Additional
Route::get('/subjectdraftshow',[videoclassController::class, 'draftsubjectshow']);
Route::get('/draftchaptershow',[videoclassController::class, 'draftchaptersshow']);
Route::get('/draftmorevideoshow',[videoclassController::class,'draftmorevideocheck']);
// // //update video class questions
Route::get('/draftupdateVCQuestion{questionId}', [videoclassController::class, 'draftupdateVideoclassQuestionForm']);
Route::post('/VideoClassQDraftUpdate', [videoclassController::class, 'draftVClassquestionUpdate']);
// //APPROVING
Route::get('/ApproveVQ/{questionId}', [videoclassController::class, 'VCQapproving']);
Route::get('/RefuseVQ/{questionId}', [videoclassController::class, 'VCQrefusing']);
//search subject wise chapters showing in ajax
Route::get('/searchsubjectwisechapter',[videoclassController::class,'searchsubjectwisechapter']);
//search subject wise videos showing in ajax
Route::get('/searchsubjectwisevideos',[videoclassController::class,'searchsubjectwisevideos']);
//search chapter wise videos showing in ajax
Route::get('/searchchapterbasevideo',[videoclassController::class,'searchchapterbasevideo']);
// Route::get('/PmoduleShow',[videoclassController::class, 'PmoduleShow']);
});
//  FILTERING QUESTION VIDEO CLASS ////////////////////////////////////////////////////
Route::middleware(['SuperAdminRoutes'])->group(function () {
Route::get('/showfilterformvc', [videoclassController::class, 'showfilterformvc']);
//NAH
});
//show super admin VCQA
Route::middleware(['SuperAdminRoutes'])->group(function () {
Route::get('/searchfilterdquestvideoclass',[videoclassController::class, 'searchfilterdquestvideoclass']);
Route::get('/VCsupadminquestionTake',[videoclassController::class,'VCsupadminquestionTake']);
Route::get('/VCsupadminQuestionDelete/{questionId}',[videoclassController::class, 'VCsupadminQuestionDelete']);
Route::get('/subjectsupadminshow',[videoclassController::class, 'subjectsupadminshow']);
Route::get('/chaptersupadminshow',[videoclassController::class,'chaptersupadminshow']);
Route::get('/morevideosupadmincheck',[videoclassController::class,'morevideosupadmincheck']);
// //update video class exam
Route::get('/updatesupadminVCQuestion{questionId}', [videoclassController::class, 'updatesupadminVCQuestion']);
Route::post('/VideoClasssupadminUpdate', [videoclassController::class, 'VcquestionsupadminUpdate']);
// END VIDEO CLASS FILTRATION-----------------------
// SUPER ADMIN DRAFT APPROVE FILTERED QUESTION VIDEO CLASS ////////////////////////////////////////////////////
Route::get('/showfiltersuperadminsearchformvc', [videoclassController::class, 'showfiltersuperadminformvc']);
// //show super admin VCQA
Route::get('/searchfilterdquestsadminvideoclass',[videoclassController::class, 'searchfilterdquestdraftsadminvideoclass']);
Route::get('/VCsupadmindraftquestionTake',[videoclassController::class,'VCsupadmindraftquestionTake']);
// // // Route::get('/PmoduleShow',[videoclassController::class, 'PmoduleShow']);
Route::get('/VCsupadmindraftQuestionDelete/{questionId}',[videoclassController::class, 'VCsupadmindraftvcQuestionDelete']);
Route::get('/subjectsupadmindraftshow',[videoclassController::class, 'subjectsupadmindraftshow']);
Route::get('/chaptersupadmindraftshow',[videoclassController::class,'chaptersupadmindraftshow']);
Route::get('/morevideosupadmindraftcheck',[videoclassController::class,'morevideosupadmindraftcheck']);
// // //update video class exam
Route::get('/updatesupadmindraftVCQuestion{questionId}', [videoclassController::class, 'updatesupadmindraftVCQuestion']);
Route::post('/VideoClasssupadmindraftUpdate', [videoclassController::class, 'VcquestionsupadmindraftUpdate']);
// APPROVE DRAFT FILTERED QUESTIONS
Route::get('/approveVCSubmsadmin/{parameter}', [videoclassController::class, 'VCapprovingsubcategorywisesadmin']);
// END--------
// ENABLE AND DISABLE VIDEO
Route::get('/vcvideoDisable/{vcVDId}', [videoclassController::class, 'vcvideoDisable']);
Route::get('/vcvideoEnable/{vcVDId}', [videoclassController::class, 'vcvideoEnable']);
// END
// EXCEL VIDEO CLASS DOWNLOAD
// VIDEO CLASSES
Route::post('/excelgetvidepclassexamdwnld',[videoclassController::class, 'excelgetvidepclassexamdwnld']);
Route::post('/excelgetFilteredvideoclassexamdwnld',[videoclassController::class, 'excelgetFilteredvideoclassexamdwnld']);
// END VIDEO CLASS AREA

});
// middle






// EMPLOYEES AREA
Route::middleware(['SuperAdminRoutes'])->group(function () {
//section for add_admin
Route::get('/add_admin_form',[EmployeeController::class,'Admin_add_Form']);
Route::post('/admin_add',[EmployeeController::class,'addtoAdmin']);
Route::get('/update_AdminForm{adId}', [EmployeeController::class, 'update_Admin_Form']);
Route::post('admin_details_update/{adId}', [EmployeeController::class, 'Admin_details_update']);
Route::get('/Inactive_Admin/{adId}', [EmployeeController::class, 'Inactive_Admin_1']);
Route::get('/Active_Admin/{adId}', [EmployeeController::class, 'Active_Admin_1']);
//   AUTHORIZER -----------------SUPER ADMIN ADING FORM----------------
Route::get('add_authorizer',[EmployeeController::class,'add_authorizerform']);
Route::post('author_add',[EmployeeController::class,'authorizer_add']);
Route::get('/update_Author{id}', [EmployeeController::class, 'update_Author_Form']);
Route::post('Author_details_update/{id}', [EmployeeController::class, 'Authorizer_details_update']);
Route::get('/Inactive_Author/{id}', [EmployeeController::class, 'Inactive_Authorizer']);
Route::get('/Active_Author/{id}', [EmployeeController::class, 'Active_Authorizer']);
//   END-----AUTHORIZER -----------------SUPER ADMIN ADING FORM----------------
///// EMPLY ENTRY
//section for add_employeee
Route::get('/add_employee',[EmployeeController::class,'Employee_add_Form']);
Route::post('/employee_add',[EmployeeController::class,'employee_add']);
Route::get('/update_Employee{adId}', [EmployeeController::class, 'update_Employee']);
Route::post('Employee_details_update/{adId}', [EmployeeController::class, 'Employee_details_update']);
Route::get('/Inactive_Employee/{adId}', [EmployeeController::class, 'Inactive_Employee']);
Route::get('/Active_Employee/{adId}', [EmployeeController::class, 'Active_Employee']);
// END EMPLOYEE AREA
});
//END MIDDLEWARE









// SUBSCRIPTION AREA
Route::middleware(['SuperAdminRoutes'])->group(function () {
//PAYMENT HISTORY
Route::get('/showpaymenthist_sup',[SubscriptionController::class,'showpaymenthist_sup']);
//END
// APP PLAN SUBSCRIBERS SHOWING
Route::get('/showappplansubscribers',[SubscriptionController::class,'showappplansubscribers']);
Route::get('/planSubscribers_details{planId}',[SubscriptionController::class,'planSubscribers_details']);
// END APP PLAN SUBSCRIBERS SHOWING
//subscription 
Route::get('/subscription',[SubscriptionController::class,'subscriptionForm']);
Route::post('/subscription_add',[SubscriptionController::class,'subscription_add']);
Route::get('/update_Subscription{planId}', [SubscriptionController::class, 'update_Subscription']);
Route::post('/Subscription_details_update/{planId}', [SubscriptionController::class, 'Subscription_details_update']);
Route::get('/Inactive_Subscription/{planId}', [SubscriptionController::class, 'Inactive_Subscription']);
Route::get('/Active_Subscription/{planId}', [SubscriptionController::class, 'Active_Subscription']);
// END SUBSCRIPTION AREA
});
//END SUB MIDDLE










// USERS AREA
Route::middleware(['SuperAdminRoutes'])->group(function () {
// USER ANALYTICSINGLE LIVE GAME HISTORIES SHOWING
Route::get('/getLiveGamesSingleHist{uId}',[usersController::class, 'getLiveGamesSingleHist']);
// END
//////////////  USER ANALYTICS  ////////////////  SHOWING USERS------------------------------------------
Route::get('/usersShow',[usersController::class, 'showUsers']);
Route::get('/searchusers',[usersController::class, 'searchUser']);
Route::get('/analyticsShow{uId}',[usersController::class,'singleAnalytics']);
//Single prev quest history
Route::get('/getPrevQuestSingleHist{uId}', [usersController::class, 'getSinglrPrevQuest']);
Route::get('/getMainExmSingleHist{uId}',[usersController::class, 'getSingleMainExam']);
Route::get('/getGamezoneSingleHist{uId}',[usersController::class, 'getSingleGameZon']);
Route::get('/getVideoclassSingleHist{uId}',[usersController::class, 'getSingleVideoCls']);
// END USERS
// REVISION ROUTE START HERE--
Route::get('/getSingleUserRevisionsdetails{uId}',[usersController::class, 'getSingleUserRevisionsdetails']);
//END

});
// END USERS MIDDDLE









// MODEL EXAM AREA
Route::middleware(['SuperAdminRoutes'])->group(function () {
//////////// DAILY EXAM ROUTE START--------------------
Route::get('/dailyexamform',[ModelExmController::class,'dailyExamAdding']);
Route::post('/addDailyExam',[ModelExmController::class,'InsertDailyExamblade']);
Route::get('/deletetheexam/{dId}',[ModelExmController::class, 'deleteDailyExam']);
Route::get('/examExpired/{dId}', [ModelExmController::class, 'expireddailyexam']);
Route::get('/examActive/{dId}', [ModelExmController::class, 'activedailyexam']);
/////  DAILY EXAM ROUTE END----------------------------
//// DAILY EXAM WINNERS SHOWING ------ DETAILS----------
Route::get('/dailyexamwinnerform',[ModelExmController::class,'dailyexmwinnersform']);
// ajax used to view 10 winners-------
Route::get('/toptenwinners',[ModelExmController::class,'toptenwinnerssort']);
/////  DAILY EXAM ROUTE END----------------------------
});
// CHAPTER WISE DAILY EXAM
Route::middleware(['SuperAdminRoutes'])->group(function () {
Route::get('/add_chapter_wise_daily-exam', [ModelExmController::class, 'addchapterwisedailyexam']);
Route::post('/ChapterWiseDailyexmmodulecheck', [ModelExmController::class, 'ChapterWiseDailyexmmodulecheck']);
Route::post('/addDailyChapterExam', [ModelExmController::class, 'addDailyChapterExam']);
Route::get('/deletechapterwisetheexam/{dId}',[ModelExmController::class, 'deletechapterwisetheexam']);
});
//END
// END MODEL EXAM AREA




















// AUTHORIZER AREA
Route::middleware(['AuthorizerRoute'])->group(function () {
///  AUTHORIZER --LOGIN --AND ADDING --VIEW-- AND --APPROVING--QUESTIONS-------
Route::get('/authorDashboard', [AuthorizerController::class, 'index']);
});
//pq add
Route::middleware(['AuthorizerRoute'])->group(function () {
Route::get('/authortoPQA', [AuthorizerController::class, 'addauthorPQA']);
Route::get('/authorpqSubModuleCheck',[AuthorizerController::class,'pqSubModuleCheck']);
Route::get('/authorpqModuleCheckformain',[AuthorizerController::class,'pqModuleCheckformain']);
Route::post('/previousQuestionSaveAuthor',[AuthorizerController::class, 'postPreQues']);
// //show PQA
Route::get('/authorshowPQA',[AuthorizerController::class, 'showPQAauthor']);
Route::get('/authorPquestionTake',[AuthorizerController::class,'PquestionTakeauthor']);
//Route::get('/PmoduleShow',[AuthorizerController::class, 'PmoduleShow']);
Route::get('/authorPquestionDelete/{questionId}',[AuthorizerController::class, 'deletePQuestionauthor']);
//Route::post('/PquestionUpdate',[AuthorizerController::class,'PquestionUpdate']);
//Additional
Route::get('/authorExamTypeshow',[AuthorizerController::class, 'ExamTypeshowauthor']);
Route::get('/authorCategoryshow',[AuthorizerController::class, 'Categoryshowauthor']);
Route::get('/authorsubCategoryshow',[AuthorizerController::class,'subCategoryshow']);
// //update previous questions
Route::get('/authorupdatePQQuestion{pqId}', [AuthorizerController::class, 'updatePreviousQuestionForm']);
Route::post('/authorsPreviousQuestionUpdate', [AuthorizerController::class, 'PquestionUpdateauthor']);
// approving author
Route::get('/authordraftPQA',[AuthorizerController::class,'authorsShowQ']);
Route::get('/draftPquestionTakeauthor',[AuthorizerController::class,'draftPquestionTakeauthor']);
Route::get('/draftPquestionDeleteauthor/{questionId}',[AuthorizerController::class, 'draftdeletePQuestionauthor']);
// //Additional
Route::get('/authorExamTypeshow',[AuthorizerController::class, 'draftExamTypeshowauthor']);
Route::get('/draftauthorCategoryshow',[AuthorizerController::class, 'draftCategoryshowauthor']);
Route::get('/draftsubCategoryshowauthor',[AuthorizerController::class,'draftsubCategoryshowauthor']);
// //update previous questions
Route::get('/authordraftupdatePQQuestion{questionId}', [AuthorizerController::class, 'draftupdatePreviousQuestionFormauthor']);
Route::post('/draftPreviousQuestionUpdateauthor', [AuthorizerController::class, 'draftPquestionUpdateauthor']);
//APPROVING
Route::get('/ApprovePQauthor/{questionId}', [AuthorizerController::class, 'PQapprovingauthor']);
Route::get('/RefusePQauthor/{questionId}', [AuthorizerController::class, 'PQrefusingauthor']);
/// END-AUTHORIZER --LOGIN --AND ADDING --VIEW-- AND --APPROVING--QUESTIONS-------
});
/// Authorizer VIDEO CLASS EXAM QUESTION ADDS--------------------------------------------------------
Route::middleware(['AuthorizerRoute'])->group(function () {
//vc author exam  add
Route::get('/vcexamformauthors', [AuthorizerController::class, 'vcAuthorAddExamForm']);
Route::get('/vcauthorChapterCheck',[AuthorizerController::class,'vcAuthorizerChaptersCheck']);
Route::get('/videomoreauthorCheck',[AuthorizerController::class,'videomoreAuthorizerCheck']);
Route::post('/vcExamSaveauthor',[AuthorizerController::class, 'postvdeoClsQuesauthor']);
//author show VCQA
Route::get('/vcauthorsshowexam',[AuthorizerController::class, 'showauthorizerVCQA']);
Route::get('/VCquestionTakeauthor',[AuthorizerController::class,'vCauthorquestionTake']);
Route::get('/VCQuestionDeleteauthor/{questionId}',[AuthorizerController::class, 'deleteauthorVCQuestion']);
// // //update author video class exam
Route::get('/subjectshowauthor',[AuthorizerController::class, 'subjectauthorshow']);
Route::get('/chaptershowauthor',[AuthorizerController::class,'chapterauthorshow']);
Route::get('/morevideocheckauthor',[AuthorizerController::class,'morevideoauthorcheck']);
Route::get('/authorEditVCQuestion{questionId}',[AuthorizerController::class, 'updateauthorVideoClassForm']);
Route::post('/VideoClassauthorUpdate', [AuthorizerController::class, 'VcauthorquestionUpdate']);
// approve author--
/// APPROVING STAFFS ADDED VIDEO CLASS QUESTIONS AND ISAVAIL = 2 ---
Route::get('/draftauthorVCQA',[AuthorizerController::class,'authordraftVclassShowQ']);
Route::get('/draftauthorVCuestionTake',[AuthorizerController::class,'draftAuthorizerVcQuestionTake']);
Route::get('/draftauthorVCquestionDelete/{questionId}',[AuthorizerController::class, 'draftauthordeleteVcQuestion']);
// // // //Additional
Route::get('/subjectauthordraftshow',[AuthorizerController::class, 'draftauthorsubjectshow']);
Route::get('/draftauthorchaptershow',[AuthorizerController::class, 'draftauthorchaptersshow']);
Route::get('/draftauthormorevideoshow',[AuthorizerController::class,'draftAuthorizermorevideocheck']);
// // // //update previous questions
Route::get('/draftauthorupdateVCQuestion{questionId}', [AuthorizerController::class, 'draftauthorizerupdateVideoclassQuestionForm']);
Route::post('/VideoClassAuthorQDraftUpdate', [AuthorizerController::class, 'draftauthorizerVClassquestionUpdate']);
// // //APPROVING
Route::get('/ApproveauthorVQ/{questionId}', [AuthorizerController::class, 'VCQauthorapproving']);
Route::get('/RefuseVQauthor/{questionId}', [AuthorizerController::class, 'VCQauthorrefusing']);
///// End authorizer video class--------------------------------------------------
});
//////////////   MAIN EXAM --- DRAFT ---------- APPROVING----------------------------
//  author show and approve sub module wise previous questions----
Route::middleware(['AuthorizerRoute'])->group(function () {
//show PQA sub module wise 
Route::get('/showPQAsubmauthur',[AuthorizerController::class,'showPQAsmamicaauthor']);
Route::get('/PQAauthorsubcategory',[AuthorizerController::class,'PQAauthorsubmodulecheck']);
Route::get('/PquestionauthorDeletesub/{questionId}',[AuthorizerController::class, 'deletePQauthorsubmoduleview']);
Route::get('/updatePQauthorsub{pqId}', [AuthorizerController::class, 'updatesubPreviousauthorQuestionForm']);
Route::post('/PreviousauthorQuestionSMUpdate', [AuthorizerController::class, 'PquestionauthorSubMUpdate']);
Route::get('/QuestauthorExamTypeshow',[AuthorizerController::class, 'pqsmauthorExamTypeshow']);
Route::get('/QuestauthorCategoryshow',[AuthorizerController::class, 'pqsmauthorCategoryshow']);
Route::get('/QuestauthorsubCategoryshow',[AuthorizerController::class,'pqsmauthorSubCategoryshow']);
//approve subcategory wise
Route::get('/approvePQSubmauthor/{parameter}', [AuthorizerController::class, 'PQapprovingsubcategorywiseauthor']);
Route::get('/RefusesubmPQauthor/{parameter}', [AuthorizerController::class, 'PQsubcatewiserefusingauthor']);
// new show subm wise quest checking
Route::get('/authorsubcategorypq',[AuthorizerController::class,'authorsubmodulecheckpq']);
///// ADMIN-- ENTRY
});
// authorizer approving question bank
Route::middleware(['AuthorizerRoute'])->group(function () {
///viewing questions and editing questions
Route::get('/toauthormainexmQA', [AuthorizerController::class, 'viewauthorModule']);
// AJAX ROUTE submodule
Route::get('/subModuleauthorCheck',[AuthorizerController::class,'authorizersubModulemainexmCheck']);
Route::post('/questionauthormainSave',[AuthorizerController::class, 'postauthorizermainexmQues']);
// Route::get('/viewQA',[AuthorizerController::class,'viewQA']);
Route::get('/showauthormainQA',[AuthorizerController::class, 'showauthorizermainexmQuestions']);
Route::get('/questionauthormainTake',[AuthorizerController::class,'questionauthorizermainexamTake']);
Route::post('/questionauthormainUpdate',[AuthorizerController::class,'questionauthorizermainexmUpdate']);
Route::get('/updateauthormainQuestion{cqId}', [AuthorizerController::class, 'updateauthorizermainexmQuestionForm']);
// Route::post('/questionUpdate', [AuthorizerController::class, 'questionUpdate']);
Route::get('/questionauthormainDelete/{questionId}',[AuthorizerController::class, 'deleteauthorizermainexmQuestion']);
Route::get('/Moduleauthormainshow',[AuthorizerController::class, 'Moduleauthorizermainexmshow']);
//////////////  AUTHORIZER MAIN EXAM --- DRAFT ---------- APPROVING----------------------------
});
Route::middleware(['AuthorizerRoute'])->group(function () {
///show draft questions and editing questions
Route::get('/draftauthorMainExam',[AuthorizerController::class, 'showdraftauthorizermainexmQuestions']);
Route::get('/questionauthorizermaindraftTake',[AuthorizerController::class,'questionauthorizermainexmDraftTake']);
Route::get('/updateauthormaindraftexmQuestion{cqId}', [AuthorizerController::class, 'updateauthorizerdraftmainexmQuestionForm']);
Route::post('/questionauthordraftmainexamUpdate', [AuthorizerController::class, 'mainExmauthorquestionDraftUpdate']);
Route::get('/questionauthordraftmainDelete/{questionId}',[AuthorizerController::class, 'deleteauthorizerDraftmainexmQuestion']);
Route::get('/Moduleauthordraftmainexmshow',[AuthorizerController::class, 'ModuleauthormainexmDraftshow']);
Route::get('/subModuleauthormainexmdraftCheck',[AuthorizerController::class,'subdraftauthormainexmModuleCheck']);
// //APPROVING
Route::get('/ApproveauthormainexmMainexam/{questionId}', [AuthorizerController::class, 'MEauthormainexmapproving']);
Route::get('/RefuseauthormainexmMainExam/{questionId}', [AuthorizerController::class, 'MEauthormainexamrefusing']);
////////////// AUTHORIZER END MAIN EXAM --- DRAFT ---------- APPROVING----------------------------
});
Route::middleware(['AuthorizerRoute'])->group(function () {
// author approving submodule wise question bank questions----------------------------------
Route::get('/submodulewisemainexm',[AuthorizerController::class,'submodulewisecheckingform']);
// AJAX ROUTE submodule
Route::get('/subModulewiseauthorchekauthorCheck',[AuthorizerController::class,'authorizersubModulewiseauthorizerCheck']);
// form get drafted submodule wise main exam questions--
Route::get('/getdraftapprovingmainexam',[AuthorizerController::class,'submodulewiseauthorapprovingdraftmainexam']);
///show draft questions and editing questions
Route::get('/questionauthorizersubmmaindraftTake',[AuthorizerController::class,'questionauthorizersubmodulewisemainexmDraftTake']);
Route::get('/updateauthorsubmmaindraftexmQuestion{cqId}', [AuthorizerController::class, 'updateauthorizerdraftsubmodulewisemainexmQuestionForm']);
Route::post('/questionauthordraftsubmmainexamUpdate', [AuthorizerController::class, 'mainExmsubmodulewiseauthorquestionDraftUpdate']);
 
Route::get('/questionauthordraftsubmmainDelete/{questionId}',[AuthorizerController::class, 'deleteauthorizerDraftsubmodulewisemainexmQuestion']);
Route::get('/Moduleauthordraftsubmmainexmshow',[AuthorizerController::class, 'ModuleauthorsubmmainexmDraftshow']);
Route::get('/subModuleauthorsubmmainexmdraftCheck',[AuthorizerController::class,'subdraftauthorsubmodulewisemainexmModuleCheck']);
// // //APPROVING
Route::get('/ApproveauthorsubmmainexmMainexam/{questionId}', [AuthorizerController::class, 'MEsubmodulewiseauthormainexmapproving']);
Route::get('/RefuseauthorsubmmainexmMainExam/{questionId}', [AuthorizerController::class, 'MEsubmodulewiseauthormainexamrefusing']);
// END AUTHORIZER AREA
});
// END author














// USERS QUESTION AREA
//  USERS SUGGESTION OR IDEAS VIEWING ROUTE START HERE
Route::middleware(['SuperAdminRoutes'])->group(function () {
Route::get('/show_user_suggestions_i', [UserQuestionsController::class, 'show_user_suggestions_i']);
});
//  USERS SUGGESTION OR IDEAS VIEWING ROUTE END HERE
//users doubts answers viewing super admin
Route::get('/showuserdoubtsans',[UserQuestionsController::class,'viewusersanswers']);
//take answer
Route::get('/questionadminTakeandAnswer',[UserQuestionsController::class,'questionadminansTakeandAnsweradmin']);
//view more
Route::get('/adminquestionandAnswerview',[UserQuestionsController::class,'adminquestionTakeandAnswersviewmore']);
// END USERS QUESTION AREA






// CRASH COURSE AREA
Route::middleware(['SuperAdminRoutes'])->group(function () {
// CRASH COURSE AREA START HERE SUPER ADMIN--------------------------------------------
Route::get('/addcoursesupadmin',[CrashCourseController::class,'addcoursesupadmin']);
Route::get('/updateadmincoursesup{encryptedId}',[CrashCourseController::class,'updatecoursesupadmin']);
Route::post('/update_course_supadmin_dta',[CrashCourseController::class,'update_course_supadmin_dta']);
Route::get('/addcoursesupadminbatch',[CrashCourseController::class,'addcoursesupadminbatch']);
Route::get('/updatesupadminbatch{encrypted}',[CrashCourseController::class,'updatesupadminbatch']);
Route::post('/update_supadmin_batch_dta',[CrashCourseController::class,'update_supadmin_batch_dta']);
Route::get('/addstunentsupadminstobatch',[CrashCourseController::class,'addstunentsupadminstobatch']);
Route::get('/studentssupadminaddedbatchtotalstudentsTake{cbId}',[CrashCourseController::class,'studentssupadminaddedbatchtotalstudentsTake']);
Route::get('/addbatchdaysupadminsactivities',[CrashCourseController::class,'addbatchdaysupadminsactivities']);
Route::get('/viewmoredayssupadmin_act{cbId}',[CrashCourseController::class,'viewmoredayssupadmin_act']);

Route::post('/save_course_dta_supadmin',[CrashCourseController::class,'save_course']);

//course delete
Route::get('/coursedelete_superadmin/{encrypted}',[CrashCourseController::class,'coursedelete']);


//disable enable
Route::get('/coursedisable_supadmin/{encrypted}',[CrashCourseController::class,'coursedisable']);
Route::get('/courseenable_supadmin/{encrypted}',[CrashCourseController::class,'courseenable']);



Route::post('/save_batch_dta_superadmin',[CrashCourseController::class,'save_batch']);
//batch delete
Route::get('/batchdelete_superadmin/{encrypted}',[CrashCourseController::class,'batchdelete']);

// //disable enable
Route::get('/batchdisable_superadmin/{encrypted}',[CrashCourseController::class,'batchdisable']);
Route::get('/batchenable_superadmin/{encrypted}',[CrashCourseController::class,'batchenable']);



Route::post('/save_students_intothe_batch_superadmin',[CrashCourseController::class,'save_students_intothe_batch']);
Route::get('/studentsaddedbatchtotalstudentsTake_supadmin{cbId}',[CrashCourseController::class,'studentsaddedbatchtotalstudentsTake']);
Route::get('/studentbatchdisable_supadmin/{cbId}',[CrashCourseController::class,'studentbatchdisable']);
Route::get('/studentbatchenable_supadmin/{cbId}',[CrashCourseController::class,'studentbatchenable']);


Route::get('/checkingbatchnamewisesubscriber_supadmin',[CrashCourseController::class,'checkingbatchnamewisesubscriber']);


Route::get('/checkingcoursenamewisebatch_supadmin',[CrashCourseController::class,'checkingcoursenamewisebatch']);



Route::post('/save_batch_days_supadmin',[CrashCourseController::class,'save_batch_days']);

Route::get('/checkingmodulewise_submodule_superadmin',[CrashCourseController::class,'checkingmodulewise_submodule']);
Route::get('/checkingcoursenamewisebatch_days_superadmin',[CrashCourseController::class,'checkingcoursenamewisebatch_days']);
Route::get('/lastaddeddayTake_superadmin',[CrashCourseController::class,'lastaddeddayTake']);


Route::get('/student_batch_deactive_supadmin/{cbwsId}',[CrashCourseController::class,'student_batch_deactive']);
Route::get('/student_batch_active_superadmin/{cbwsId}',[CrashCourseController::class,'student_batch_active']);


Route::get('/day_ac_delete_superadmin/{cbdId}',[CrashCourseController::class,'day_ac_delete']);





// END------
});






Route::middleware(['SuperAdminRoutes'])->group(function () {
//PAYMENT HISTORY CRASHCOURSE
Route::get('/show_crash_payment_hist',[CrashCourseController::class,'show_crash_payment_hist']);
//END
});
// CRASH COURSE SUBSCRIBERS DETAILS--------------------------
Route::get('/showcrashcoursesubscribers',[CrashCourseController::class,'showcrashcoursesubscribers']);
Route::get('/singlecrashcouse_subscriber{cmId}',[CrashCourseController::class,'singlecrashcouse_subscriber']);
// END CS------
Route::middleware(['StaffAdminRoute'])->group(function () {
// CRASH COURSE AREA START HERE--------------------------------------------
Route::get('/addcoursesub',[CrashCourseController::class,'addcoursesubform']);
Route::post('/save_course_dta',[CrashCourseController::class,'save_course']);
//course delete
Route::get('/coursedelete/{encrypted}',[CrashCourseController::class,'coursedelete']);
//update course
Route::get('/updatecourse{encrypted}',[CrashCourseController::class,'update_course_form']);
Route::post('/update_course_dta',[CrashCourseController::class,'update_course']);
//disable enable
Route::get('/coursedisable/{encrypted}',[CrashCourseController::class,'coursedisable']);
Route::get('/courseenable/{encrypted}',[CrashCourseController::class,'courseenable']);
// BATCHES--------------
Route::get('/addcoursebatch',[CrashCourseController::class,'addcoursebatch']);
Route::post('/save_batch_dta',[CrashCourseController::class,'save_batch']);
//batch delete
Route::get('/batchdelete/{encrypted}',[CrashCourseController::class,'batchdelete']);
//update batch
Route::get('/updatebatch{encrypted}',[CrashCourseController::class,'update_batch_form']);
Route::post('/update_batch_dta',[CrashCourseController::class,'update_batch']);
// //disable enable
Route::get('/batchdisable/{encrypted}',[CrashCourseController::class,'batchdisable']);
Route::get('/batchenable/{encrypted}',[CrashCourseController::class,'batchenable']);
//batch with students
Route::get('/addstunentstobatch',[CrashCourseController::class,'addstunentstobatch']);
Route::get('/checkingcoursenamewisebatch',[CrashCourseController::class,'checkingcoursenamewisebatch']);
Route::get('/checkingbatchnamewisesubscriber',[CrashCourseController::class,'checkingbatchnamewisesubscriber']);
Route::post('/save_students_intothe_batch',[CrashCourseController::class,'save_students_intothe_batch']);
Route::get('/studentsaddedbatchtotalstudentsTake{cbId}',[CrashCourseController::class,'studentsaddedbatchtotalstudentsTake']);
Route::get('/studentbatchdisable/{cbId}',[CrashCourseController::class,'studentbatchdisable']);
Route::get('/studentbatchenable/{cbId}',[CrashCourseController::class,'studentbatchenable']);
// BATCH ACTIVIES--------------------------------
Route::get('/addbatchdaysactivities',[CrashCourseController::class,'addbatchdaysactivities']);
Route::get('/checkingcoursenamewisebatch_days',[CrashCourseController::class,'checkingcoursenamewisebatch_days']);
Route::get('/checkingmodulewise_submodule',[CrashCourseController::class,'checkingmodulewise_submodule']);
Route::post('/save_batch_days',[CrashCourseController::class,'save_batch_days']);
Route::get('/lastaddeddayTake',[CrashCourseController::class,'lastaddeddayTake']);
Route::get('/viewmoredays_act{cbId}',[CrashCourseController::class,'viewmoredays_act']);
Route::get('/day_ac_delete/{cbdId}',[CrashCourseController::class,'day_ac_delete']);
Route::get('/student_batch_deactive/{cbwsId}',[CrashCourseController::class,'student_batch_deactive']);
Route::get('/student_batch_active/{cbwsId}',[CrashCourseController::class,'student_batch_active']);
// CRASH COURSE AREA END HERE--------------------------------------------
});
//  SUPER ADMIN VIEWING CRASH COURSE HISTORIES---------------
Route::middleware(['SuperAdminRoutes'])->group(function () {
Route::get('/showcrashcoursehistory',[CrashCourseController::class,'showcrashcoursehistory']);
Route::get('/studentscrash_History_view{uId}{cbId}',[CrashCourseController::class,'studentscrash_History_view']);
//  END----HIST---
});
// END CRASH COURSE AREA









// REFERED AREA
Route::middleware(['SuperAdminRoutes'])->group(function () {
// REFFERAL DATAS DETAILS START HERE---------------------------------------------
Route::get('/reffered_amount_form',[refferedUsersController::class, 'reffered_amount_form']);
Route::get('/referamountupdate{refamount_Id}',[refferedUsersController::class, 'referamountupdate']);
Route::post('/updateamountrefer',[refferedUsersController::class, 'updateamountrefer']);
//payment area
Route::get('/user_payment_request',[refferedUsersController::class, 'user_payment_request']);
Route::get('/users_details_bnk',[refferedUsersController::class, 'users_details_bnk']);
Route::get('/userrequestapprove/{request_Id}{userId}',[refferedUsersController::class, 'userrequestapprove']);
// ADD USER PAYMENT
Route::get('/add_user_payment',[refferedUsersController::class, 'add_user_payment']);
Route::get('/check_user_credit_amount',[refferedUsersController::class, 'check_user_credit_amount']);
Route::post('/save_user_payment_ami',[refferedUsersController::class, 'save_user_payment_ami']);
// START LEDGER
Route::get('/show_total_user_payments',[refferedUsersController::class, 'show_total_user_payments']);
Route::get('/show_total_user_payments',[refferedUsersController::class, 'show_total_user_payments']);
Route::get('/show_user_single_report{user_Id}',[refferedUsersController::class, 'show_user_single_report']);
// END---
});
// END REFFERED AREA






// NOTIFY
Route::middleware(['SuperAdminRoutes'])->group(function () {
// NOTIFICATION AREA
Route::get('/sent-notification-back',[ApiPushNotificationController::class,'viewNotificationForm']);
Route::post('/store_notify_datas',[ApiPushNotificationController::class,'storenotifydata']);
// END
});
// END NOTIFICATION 



// ADVERTISEMENT AREA
Route::middleware(['SuperAdminRoutes'])->group(function () {
//Add Advertisement
Route::get('/advertisements',[AdvertisementController::class,'AdvertisementForm']);
Route::post('/addadvertisements',[AdvertisementController::class,'add_advertisements']);
//Update Advertisement
Route::get('/updateAdvertisement{adId}', [AdvertisementController::class, 'updateAdvertisementForm']);
Route::post('AdvertisementUpdate/{adId}', [AdvertisementController::class, 'updateAdvertisements']);
Route::get('/advertisementInactive/{adId}', [AdvertisementController::class, 'advertisementInactive']);
Route::get('/advertisementActive/{adId}', [AdvertisementController::class, 'advertisementActive']);
Route::get('/advertisementDelete/{adId}',[AdvertisementController::class, 'deleteAdvertisement']);
// END ADVERTISEMENT
});
// END ADS MIDDLE




// IMAGE BASED QUESTIONS IMSERTING SUPERADMIN AREA ImagePQAController
Route::middleware(['SuperAdminRoutes'])->group(function () {
//richtest image upload
Route::post('/upload', [PQuestionController::class, 'uploadimage'])->name('ckeditor.upload');


Route::get('/showdraftsuperadminimagePqa',[ImagePQAController::class, 'showdraftsuperadminimagePqa']);
Route::get('/draftImageBasedAddedPquestionTake',[ImagePQAController::class,'draftImageBasedAddedPquestionTake']);
Route::get('/draftImagebasedPquestionDelete/{questionId}',[ImagePQAController::class, 'draftImagebasedPquestionDelete']);
Route::get('/DraftimagebasedaddedApprovePQ/{questionId}', [ImagePQAController::class, 'DraftimagebasedaddedApprovePQ']);
Route::get('/imagebaseaddedPquestionTake',[ImagePQAController::class,'imagebaseaddedPquestionTake']);
Route::get('/draftImagebaseaddedupdatePQQuestion{questionId}', [ImagePQAController::class, 'draftImagebaseaddedupdatePQQuestion']);

//the edit module change
Route::get('/draftImageBasespExamTypeshow',[ImagePQAController::class, 'draftImageBasespExamTypeshow']);
Route::get('/draftImagebasespCategoryshow',[ImagePQAController::class, 'draftImagebasespCategoryshow']);
Route::get('/draftImagebasespsubCategoryshow',[ImagePQAController::class, 'draftImagebasespsubCategoryshow']);
//end
//update
Route::post('/draftImagebasePreviousQuestionUpdate', [ImagePQAController::class, 'draftImagebasePreviousQuestionUpdate']);





// isavil---->0 showing super admin
Route::get('/showapprovedsuperadminimagePqa',[ImagePQAController::class, 'showapprovedsuperadminimagePqa']);
Route::get('/approvedImagebasedPquestionDelete/{questionId}',[ImagePQAController::class, 'approvedImagebasedPquestionDelete']);
Route::get('/approvedImagebaseaddedupdatePQQuestion{questionId}', [ImagePQAController::class, 'approvedImagebaseaddedupdatePQQuestion']);
Route::post('/approvedImagebasePreviousQuestionUpdate', [ImagePQAController::class, 'approvedImagebasePreviousQuestionUpdate']);








});
// END IMAGE BASED QUESTIONS IMSERTING SUPERADMIN

// QUESTION WISE MODEL EXAM IN SUPERADMIN ADDING-------HERE-----------

Route::middleware(['SuperAdminRoutes'])->group(function () {

Route::get('/modelexams-Form',[QwiseModelExamController::class, 'modelexams_Form']); 
Route::post('/ChapterWisemodelexmmodulecheck',[QwiseModelExamController::class, 'ChapterWisemodelexmmodulecheck']); 
Route::get('/modelexmreturnquest', [QwiseModelExamController::class, 'modelexmreturnquest']);
Route::post('/addModel-Exam', [QwiseModelExamController::class, 'addModel_Exam']);
Route::get('/modelexamdelete_me/{meId}',[QwiseModelExamController::class, 'modelexamdelete_me']);


//update model exam questions
Route::get('/update_ModelExamQuestionForm/{cqId}', [QwiseModelExamController::class, 'update_ModelExamQuestionForm']);

    //update
Route::post('/ModelExamquestionUpdate', [QwiseModelExamController::class, 'ModelExamquestionUpdate']);

//enable and disable model exam
Route::get('/ModelEXAMDisable/{meId}', [QwiseModelExamController::class, 'ModelEXAMDisable']);
Route::get('/ModelEXAMEnable/{meId}', [QwiseModelExamController::class, 'ModelEXAMEnable']);


//additional-26-12
Route::get('/addedQuestionsINmOdelExam', [QwiseModelExamController::class, 'addedQuestionsINmOdelExam']);
Route::post('/ModelExamArrayQuestinonInserting', [QwiseModelExamController::class, 'ModelExamArrayQuestinonInserting']);


});

//END MODEL EXAM QUESTION WISE----------------------------------------
//daily exam added question viewing
Route::middleware(['SuperAdminRoutes'])->group(function () {
Route::get('/view_exam_questions{dId}',[ModelExmController::class, 'view_exam_questions']);
Route::get('/DailyEXAMquestionTake',[ModelExmController::class,'DailyEXAMquestionTake']);
});
//end question viewing

Route::middleware(['SuperAdminRoutes'])->group(function () {
Route::get('/show-list-view-latest-questions',[UserQuestionsController::class,'show_list_view_latest_questions']);
});


//percentage wise model exam
Route::middleware(['SuperAdminRoutes'])->group(function () {
Route::get('/addpercentagewisemodelexams-Form',[QwiseModelExamController::class,'addpercentagewisemodelexams_Form']);
Route::post('/percentagewisemodelexamexmmodulecheck', [QwiseModelExamController::class, 'percentagewisemodelexamexmmodulecheck']);
Route::post('/addpercentModel_Exam', [QwiseModelExamController::class, 'addpercentModel_Exam']);
Route::get('/deletethePercentModel_exam/{meId}',[QwiseModelExamController::class, 'deletethePercentModel_exam']);
});



//add on validity for plan
Route::middleware(['SuperAdminRoutes'])->group(function () {
Route::get('/show_add_plan_form',[PlanvalidityController::class,'show_add_plan_form']);
Route::get('/searchusersplans',[PlanvalidityController::class,'searchusersplans']);
Route::get('/update_user_plan_extend',[PlanvalidityController::class,'update_user_plan_extend']); 

});


// REport routes for superadmin
Route::middleware(['SuperAdminRoutes'])->group(function () {
Route::get('/show_report_form_sadmin',[ReportQuestionController::class,'show_report_form_sadmin']);

Route::get('/show_report_response/{questionId}',[ReportQuestionController::class,'show_report_response']);
Route::get('/show_image_report_response/{questionId}',[ReportQuestionController::class,'show_image_report_response']);
Route::get('/show_previous_report_response/{questionId}',[ReportQuestionController::class,'show_previous_report_response']);

Route::post('/update_the_reported_question',[ReportQuestionController::class,'update_the_reported_question']);
Route::post('/update_the_image_reported_question',[ReportQuestionController::class,'update_the_image_reported_question']);
Route::post('/update_the_previous_reported_question',[ReportQuestionController::class,'update_the_previous_reported_question']);

});


//Preview percentage wise model exam
Route::middleware(['SuperAdminRoutes'])->group(function () {
//26-02-24
Route::get('/getSubmoduleIdandPercentagematchQuestion', [QwiseModelExamController::class, 'getSubmoduleIdandPercentagematchQuestion']);
Route::post('/savepercentage_wisemodelexam', [QwiseModelExamController::class, 'savepercentage_wisemodelexam']);

    
});








    
});



});//middleware prevent-back-history


