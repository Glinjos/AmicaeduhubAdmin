<?php
/**
 * Created by vsCode.
 * Use: Crash course based (Main Exam)
 * .

 */
namespace App\Http\Controllers;

use Illuminate\Routing\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

use DB;
use App\Models\GenaralQuestionModels\ModuleModel;
use App\Models\GenaralQuestionModels\SubModuleModel;
use App\Models\user_detail_Model;

use App\Models\CrashCourse\courseSubscribersModel;
use App\Models\CrashCourse\courseMasterModel;
use App\Models\CrashCourse\courseBatchStudentModel;
use App\Models\CrashCourse\courseBatchesModel;
use App\Models\CrashCourse\courseBatchDaysModel;
use App\Models\CrashCourse\courseHistoryModel;

use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Session;




class CrashCourseController extends Controller
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

    // add course master---subscriptions---
    //FORM
    public function addcoursesubform()
    {
        $course_details = courseMasterModel::select()->orderBy('isClosed','ASC')->get();

        return view('crash_course.add_crash_course_master',compact('course_details'));
    }


    // save course
    public function save_course(Request $request)
    {
        $validatedData = $request->validate([
            'coursename' => 'required',
            'coursedesc' => 'required',
            'activeprice' => 'required|numeric',
            'offerprice' => 'required|numeric',
            'coursedays' => 'required',

        ], [
            'coursename.required' => 'This field is required.',
            'coursedesc.required' => 'This field is required.',
            'activeprice.required' => 'This field is required.',
            'offerprice.required' => 'This field is required.',
            'coursedays.required' => 'This field is required.',
        ]);
       
        $user_id = request('user_id');

        $courseName = request('coursename');
        $courseName=preg_replace('/\s+/', ' ', $courseName);
        $courseName=strtoupper($courseName);
        //$courseName  =  request('coursename');
        $courseDesc  =  request('coursedesc');
        $Activeprice =  request('activeprice');
        $offerPrice  =  request('offerprice');
        $Days        =  request('coursedays');
        $isClose     = "0";

        $saveCourse = courseMasterModel::create([
            "coName"             => $courseName,
            "coDescription"      => $courseDesc,
            "coActivePrice"      => $Activeprice,
            "coOfferPrice"       => $offerPrice,
            "coDays"             => $Days,
            "isClosed"           => $isClose,
            "created_by"         => $user_id
        ]);

        return redirect()->back()->with('success','Course Added');


    }


    // course delete

    public function coursedelete($encrypted)
    {
        $cmId = Crypt::decrypt($encrypted);
    
        $course_specific_data=courseMasterModel::find($cmId);
        $course_specific_data->delete($cmId);

        return redirect()->back()->with('success','Course Deleted');
       
    }

    //update_course form

    public function update_course_form($encrypted)
    {
        
        $cmId = Crypt::decrypt($encrypted);
        
        $select_course_single = courseMasterModel::where('cmId',$cmId)->get();
       

        return view('crash_course.edit_crash_course_master',compact('select_course_single'));
    
    }

    //update course

    public function update_course(Request $request)
    {
        $validatedData = $request->validate([
            'coursename' => 'required',
            'coursedesc' => 'required',
            'activeprice' => 'required|numeric',
            'offerprice' => 'required|numeric',
            'coursedays' => 'required',

        ], [
            'coursename.required' => 'This field is required.',
            'coursedesc.required' => 'This field is required.',
            'activeprice.required' => 'This field is required.',
            'offerprice.required' => 'This field is required.',
            'coursedays.required' => 'This field is required.',
        ]);


        $user_id = request('user_id');
        $cmId    = request('cmId');

        $courseName = request('coursename');
        $courseName=preg_replace('/\s+/', ' ', $courseName);
        $courseName=strtoupper($courseName);
        //$courseName  =  request('coursename');
        $courseDesc  =  request('coursedesc');
        $Activeprice =  request('activeprice');
        $offerPrice  =  request('offerprice');
        $Days        =  request('coursedays');
       /// $isClose     = "0";

        $saveCourse = courseMasterModel::find($cmId);

        $saveCourse->update([
            "coName"             => $courseName,
            "coDescription"      => $courseDesc,
            "coActivePrice"      => $Activeprice,
            "coOfferPrice"       => $offerPrice,
            "coDays"             => $Days,
        
            "updated_by"         => $user_id
        ]);

        return redirect('/addcoursesub')->with('success','Course Updated');



    }

    //isAvail fields
    public function coursedisable($encrypted)
    {
        $isClose =1;
        $cmId = Crypt::decrypt($encrypted);
       // print_r($cmId);die;
        $updateisClose = courseMasterModel::find($cmId);

        $updateisClose->update([
            "isClosed"   => $isClose
        ]);

        return redirect()->back()->with('error','Course Deactivated');
    }

    public function courseenable($encrypted)
    {
        $isClose =0;
        $cmId = Crypt::decrypt($encrypted);
       // print_r($cmId);die;
        $updateisClose = courseMasterModel::find($cmId);

        $updateisClose->update([
            "isClosed"   => $isClose
        ]);

        return redirect()->back()->with('success','Course Activated');
    }


    // BATCHES-------------------------------------------------------

    public function addcoursebatch()
    {
        $course_data = courseMasterModel::select()->where('isClosed',0)->get();

        $batch_details =courseBatchesModel::select('course_batches.*', 't2.coName')
        ->join('course_master as t2', 't2.cmId', '=', 'course_batches.cmId')
        ->where('t2.isClosed',0)
        ->orderBy('course_batches.isClosed','ASC')
        ->get();

        return view('crash_course.add_batches',compact('course_data','batch_details'));
    }

    //save_batch

    public function save_batch(Request $request)
    {

        $validatedData = $request->validate([
            'coursename' => 'required',
            'batchname'  => 'required',
            'startdate'  => 'required',
            'enddate'    => 'required',
            'batchdays' => 'required',

        ], [
            'coursename.required'  => 'This field is required.',
            'batchname.required'   => 'This field is required.',
            'startdate.required'   => 'This field is required.',
            'enddate.required'     => 'This field is required.',
            'batchdays.required'  => 'This field is required.',
        ]);

        $user_id       = request('user_id');
        $courseName    = request('coursename');
        $batchname     = request('batchname');
        $startdate     = request('startdate');
        $enddate       = request('enddate');
        $batchdays    = request('batchdays');

        $save_batch   = courseBatchesModel::create([
                        "cmId"                => $courseName,
                        "cbatchName"          => $batchname,
                        "cbatchStartDate"     => $startdate,
                        "cbatchEndDate"       => $enddate,
                        "cbatchDays"          => $batchdays,
                        "created_by"          => $user_id,
        ]);

        return redirect()->back()->with([
            'success' => 'Batch Added',
            'cmid' =>$courseName
        ]); 
    }


    public function batchdelete($encrypted)
    {
        $cbId = Crypt::decrypt($encrypted);
    
        $batch_specific_data=courseBatchesModel::find($cbId);
        $batch_specific_data->delete($cbId);

        return redirect()->back()->with('success','Batch Deleted');
       
    }


    public function update_batch_form($encrypted)
    {
        
        $cbId = Crypt::decrypt($encrypted);
        
        $select_batch_single = courseBatchesModel::where('cbId',$cbId)->get();
        $select_course_details =courseMasterModel::select('cmId','coName')->where('isClosed',0)->get();
       

        return view('crash_course.edit_batch',compact('select_batch_single','select_course_details'));
    
    }


    //update course

    public function update_batch(Request $request)
    {
        $validatedData = $request->validate([
            'coursename' => 'required',
            'batchname'  => 'required',
            'startdate'  => 'required',
            'enddate'    => 'required',
            'batchdays' => 'required',

        ], [
            'coursename.required'  => 'This field is required.',
            'batchname.required'   => 'This field is required.',
            'startdate.required'   => 'This field is required.',
            'enddate.required'     => 'This field is required.',
            'batchdays.required'  => 'This field is required.',
        ]);

        $user_id       = request('user_id');
        $cbId          = request('cbId');
        $courseName    = request('coursename');
        $batchname     = request('batchname');
        $startdate     = request('startdate');
        $enddate       = request('enddate');
        $batchdays     = request('batchdays');

       

        $updateBatch = courseBatchesModel::find($cbId);

        $updateBatch->update([
                        "cmId"                => $courseName,
                        "cbatchName"          => $batchname,
                        "cbatchStartDate"     => $startdate,
                        "cbatchEndDate"       => $enddate,
                        "cbatchDays"          => $batchdays,
                       
                         "updated_by"         => $user_id
        ]);

        return redirect('/addcoursebatch')->with('success','Batch Updated');



    }



     //isAvail fields
     public function batchdisable($encrypted)
     {
         $isClose =1;
         $cbId = Crypt::decrypt($encrypted);
        // print_r($cmId);die;
         $updateisClose = courseBatchesModel::find($cbId);
 
         $updateisClose->update([
             "isClosed"   => $isClose
         ]);
 
         return redirect()->back()->with('error','Batch Deactivated');
     }
 
     public function batchenable($encrypted)
     {
         $isClose =0;
         $cbId = Crypt::decrypt($encrypted);
        // print_r($cmId);die;
         $updateisClose = courseBatchesModel::find($cbId);
 
         $updateisClose->update([
             "isClosed"   => $isClose
         ]);
 
         return redirect()->back()->with('success','Batch Activated');
     }
 
   //<----------------------------------------------------------------------------->



   //batch with students
   public function addstunentstobatch()
   {

    $students_in_batches=DB::select("SELECT DISTINCT
    batches.cbId,
    course.coName,
    batches.cbatchName,
    COALESCE(total_students.total_count, 0) AS total_students,
    batch_student.isActive
    FROM `course_master` AS course
    JOIN `course_subscribers` AS subscriber ON subscriber.cmId = course.cmId
    JOIN `course_batches` AS batches ON batches.cmId = course.cmId
    JOIN ( SELECT cbId, COUNT(uId) AS total_count
    FROM `course_batch_with_students`
    GROUP BY cbId ) AS total_students ON total_students.cbId = batches.cbId
    JOIN ( SELECT cbId, MAX(uId) AS latest_uId
    FROM `course_batch_with_students`
    GROUP BY cbId ) AS latest_students ON latest_students.cbId = batches.cbId
    JOIN `course_batch_with_students` AS batch_student ON batch_student.cbId = batches.cbId
    ORDER BY batch_student.isActive ASC; ");

    $course_data = courseMasterModel::select()->where('isClosed',0)->get();

    return view('crash_course.add_students_toBatch',compact('course_data','students_in_batches'));
   }

   public function checkingcoursenamewisebatch(Request $request)
   {

    $cmId = request('cmId');
    $batchname = courseBatchesModel::select('cbId','cbatchName')
    ->where('isClosed',0)
    ->where('cmId',$cmId)
    ->get();

    return $batchname;
   }

   public function checkingbatchnamewisesubscriber()
   {

    $cmId = request('cmId');
    $batchname = courseSubscribersModel::select('course_subscribers.uId','t2.name')
    ->join('user_details as t2', 't2.uId', '=', 'course_subscribers.uId')
    ->where('cmId',$cmId)
    ->where('isAddtoBatch',0)
    ->get();

    return $batchname;
   }



   public function save_students_intothe_batch(Request $request)
   {

    $validatedData = $request->validate([
        'coursename' => 'required',
        'batchname'  => 'required',
        'username'  => 'required',
        //'activedate'    => 'required',
        

    ], [
        'coursename.required'  => 'This field is required.',
        'batchname.required'   => 'This field is required.',
        'username.required'   => 'This field is required.',
       // 'activedate.required'     => 'This field is required.',
        
    ]);

    $user_id       = request('user_id');
    $courseName    = request('coursename');
    $batchname     = request('batchname');
   // $activedate     = request('activedate');
    
    $username    = request('username');
    $isAddtoBatch = 1;

    $save_student_to_batch   = courseBatchStudentModel::create([
                    "cbId"                => $batchname,
                    "uId"                 => $username,
                   // "Active_Date"         => $activedate,
                    "created_by"          => $user_id,
    ]);

    $update_subscriber=courseSubscribersModel::select()->where('uId','=',$username)->get();
    if ($update_subscriber->isNotEmpty()) {
            foreach ($update_subscriber as $subscriber) {           
            $csId = $subscriber->csId;
 
            $get_subscriber = courseSubscribersModel::find($csId);
   
            $get_subscriber->update([
                "isAddtoBatch" => $isAddtoBatch
            ]);
        }
    }

    return redirect()->back()->with([
        'success' => 'Student Added To The Batch',
        'cbId' =>$batchname,
        'uId'  =>$username,
        'cmid' =>$courseName
    ]); 


   }




//    public function studentsaddedbatchtotalstudentsTake(Request $request)
//    {

//     $cbId = request('cbId');

//     $students_in_batches=DB::select("SELECT DISTINCT course.coName, batches.cbatchName,students.name
//                          FROM  `course_master` AS course
//                          JOIN  `course_subscribers` AS subscriber ON subscriber.cmId = course.cmId
//                          LEFT JOIN  `course_batches` AS batches ON batches.cmId = course.cmId
//                          LEFT JOIN  `course_batch_with_students` as batch_student ON batch_student.cbId = batches.cbId
//                          LEFT JOIN `user_details` as students on students.uId = batch_student.uId
//                          WHERE batch_student.cbId = $cbId;");

//           return $students_in_batches;
//    }
    public function studentsaddedbatchtotalstudentsTake(Request $request,$cbId)
    {

   // $cbId = request('cbId');
    $batch_name =courseBatchesModel::select('cbatchName')->where('cbId',$cbId)->get();

    $students_in_batches=DB::select("SELECT DISTINCT course.coName, batches.cbatchName,students.name,batch_student.cbwsId,batch_student.isActive
                        FROM  `course_master` AS course
                        JOIN  `course_subscribers` AS subscriber ON subscriber.cmId = course.cmId
                        LEFT JOIN  `course_batches` AS batches ON batches.cmId = course.cmId
                        LEFT JOIN  `course_batch_with_students` as batch_student ON batch_student.cbId = batches.cbId
                        LEFT JOIN `user_details` as students on students.uId = batch_student.uId
                        WHERE batch_student.cbId = $cbId;");

        return view('crash_course.show_batch_added_students',compact('students_in_batches','batch_name'));
    }


   //isAvail fields
   public function studentbatchdisable($cbId)
   {
       $isActive =1;
       //$cmId = Crypt::decrypt($encrypted);
      // print_r($cmId);die;
      
       $affectedRows = courseBatchStudentModel::where('cbId', $cbId)
       ->update([
           "isActive" => $isActive
       ]);

       return redirect()->back()->with('error','Batch With Students Deactivated');
   }

   public function studentbatchenable($cbId)
   {
    $isActive =0;
    //$cmId = Crypt::decrypt($encrypted);
   // print_r($cmId);die;
   
    $affectedRows = courseBatchStudentModel::where('cbId', $cbId)
    ->update([
        "isActive" => $isActive
    ]);

    return redirect()->back()->with('success','Batch With Students Activated');
   }

///////////////-------------------------------------------------------------------------



//  BATCH DAYS ACTIVITIES-------------------

   public function addbatchdaysactivities()
   {

    $batch_days_details =DB::select("SELECT DISTINCT  batch_days.cbId,c_master.coName, batches.cbatchName,
    batches.cbatchDays as duration,
    COUNT(batch_days.cbId) as total_days
    FROM course_master AS c_master
    JOIN course_batches AS batches ON batches.cmId = c_master.cmId
    JOIN course_batch_days AS batch_days ON batch_days.cbId = batches.cbId
    GROUP BY c_master.coName, batches.cbatchName,batch_days.cbId,batches.cbatchDays;");


    $module_data = ModuleModel::select()->where('isAvail',0)->get();
    $course_data = courseMasterModel::select()->where('isClosed',0)->get();

    return view('crash_course.add_days_batch_activity',compact('course_data','module_data','batch_days_details'));
   }


   public function checkingcoursenamewisebatch_days(Request $request)
   {

    $cmId = request('cmId');
    $batchname = courseBatchesModel::select('cbId','cbatchName')
    ->where('isClosed',0)
    ->where('cmId',$cmId)
    ->get();

    return $batchname;
   }

   public function checkingmodulewise_submodule(Request $request)
   {

    $mId = request('mId');
    $submodules = SubModuleModel::select('smId','smName')
    ->where('isAvail',0)
    ->where('mId',$mId)
    ->get();

    return $submodules;
   }



   public function save_batch_days(Request $request)
   {

    $validatedData = $request->validate([
        'coursename'    => 'required',
        'batchname'     => 'required',
        'modulename'    => 'required',
       // 'submodule'     => 'required',
        'dayname'       => 'required',
        'activedate'    => 'required',
        

    ], [
        'coursename.required'     => 'This field is required.',
        'batchname.required'      => 'This field is required.',
        'modulename.required'     => 'This field is required.',
       // 'submodule.required'      => 'This field is required.',
        'dayname.required'        => 'This field is required.',
        'activedate.required'     => 'This field is required.',
        
    ]);

    $user_id       = request('user_id');
    $courseName    = request('coursename');
    $batchname     = request('batchname');
    $modulename    = request('modulename');


    $isExam = "0"; 

    if (request()->has('isExam')) {
        $isExam = "1"; 
    } 

   
   


   $submoduleIdString = $request->input('submodule', []);
   $submodule = implode(',', $submoduleIdString);
   // $submodule     = request('submodule');

   $dayname = request('dayname');
   $dayname=preg_replace('/\s+/', ' ', $dayname);
   $dayname=strtoupper($dayname);
   //$dayname       = request('dayname');

    $activedate    = request('activedate');
    

    $save_batch_day  = courseBatchDaysModel::create([
                    "cbId"                => $batchname,
                    'mId'                 => $modulename,
                    'smId'                => $submodule,
                    "dayName"             => $dayname,
                    "Date"                => $activedate,
                    'isExam'              => $isExam,
                    "created_by"          => $user_id,
    ]);

    
    return redirect()->back()->with([
        'success' => 'Batch Day Added',
        'cbId' =>$batchname,
        'mid'  =>$modulename,
        'smId'  =>$submodule,
        'cmid' =>$courseName
    ]); 


   }



   public function lastaddeddayTake(Request $request)
   {

    $cbId = request('cbId');
    $last_day_name = courseBatchDaysModel::select('dayName')
    ->where('isActive',0)
    ->where('cbId',$cbId)
    ->orderBy('created_at', 'desc') 
    ->first();

    return $last_day_name;
   }



   public function viewmoredays_act($cbId)
   {

    $batch_name = courseBatchesModel::select('cbatchName')
    ->where('cbId','=',$cbId)
    ->get();

    // $batch_days_details =DB::select("SELECT batch_days.Date,batch_days.dayName,batch_days.cbdId,
    // c_master.coName,
    // batches.cbatchName,
    // module.mName,
    // subm.smName
    // FROM course_master AS c_master
    // JOIN course_batches AS batches ON batches.cmId = c_master.cmId
    // JOIN course_batch_days AS batch_days ON batch_days.cbId = batches.cbId
    // JOIN module ON module.mId = batch_days.mId
    // JOIN sub_module AS subm ON subm.smId = batch_days.smId
    // WHERE batch_days.cbId = '$cbId'
    // AND batch_days.isActive = 0;
    // ");
    $batch_days_details =DB::select("SELECT batch_days.Date,batch_days.dayName,batch_days.cbdId,
    c_master.coName,
    batches.cbatchName,
    module.mName,
    GROUP_CONCAT(subm.smName SEPARATOR ',') as smName
    
    FROM course_master AS c_master
    JOIN course_batches AS batches ON batches.cmId = c_master.cmId
    JOIN course_batch_days AS batch_days ON batch_days.cbId = batches.cbId
    JOIN module ON module.mId = batch_days.mId
    
    JOIN sub_module AS subm ON  FIND_IN_SET(subm.smId, batch_days.smId)
    
    WHERE FIND_IN_SET (subm.smId, batch_days.smId) > 0
    AND batch_days.cbId = '$cbId'
    AND batch_days.isActive = 0
    GROUP BY batch_days.Date,batch_days.dayName,batch_days.cbdId,
    c_master.coName,
    batches.cbatchName,
    module.mName
    ORDER BY batch_days.cbdId ASC;");


    

    return view('crash_course.show_batch_days',compact('batch_days_details','batch_name'));
   }



   public function day_ac_delete($cbdId)
   {
      // $cmId = Crypt::decrypt($encrypted);
      $isActive=1;
   
    //    $day_specific_data=courseBatchDaysModel::where('cbdId', $cbdId)
    //    ->update([
    //        "isActive" => $isActive
    //    ]);
       $day_specific_data=courseBatchDaysModel::find($cbdId);
       $day_specific_data->delete($cbdId);

       return redirect()->back()->with('success','Day Deleted');
      
   }


   ///=========================================================================//








   public function  student_batch_deactive($cbwsId)
   {

    $isActive=1;
    $updateisDeActive = courseBatchStudentModel::find($cbwsId);

       $updateisDeActive->update([
           "isActive"   => $isActive
       ]);

       return redirect()->back()->with('error','Student Deactivated');
   

   }

   public function student_batch_active($cbwsId)
   {
    $isActive=0;
    $updateisActive = courseBatchStudentModel::find($cbwsId);

       $updateisActive->update([
           "isActive"   => $isActive
       ]);

       return redirect()->back()->with('success','Student Activated');
   }

//--------------------------------------------

//-------------------------------------------- END -- THE ADMIN CRASH COURSE AREA--


















public function showcrashcoursehistory()
{
   

    $total_students_crash_hist=DB::select("SELECT users.uId,batch.cbId,users.name, c_master.coName, batch.cbatchName
    FROM `course_history` as history
    JOIN `user_details` as users ON users.uId = history.uId
    JOIN `course_batches` as batch ON batch.cbId = history.cbId
    JOIN `course_master` as c_master ON c_master.cmId = batch.cmId
    GROUP BY  users.uId,users.name, c_master.coName, batch.cbatchName,batch.cbId;");

    return view('crash_course.show_histories',compact('total_students_crash_hist'));
}



   public function studentscrash_History_view($uId,$cbId)
   {

    $user_name=user_detail_Model::select('name')
    ->where('uId','=',$uId)
    ->get();

    $batch_name=courseBatchesModel::select('cbatchName')
    ->where('cbId','=',$cbId)
    ->get();

    $course_name = courseBatchesModel::select('coName')
    ->join('course_master', 'course_master.cmId', '=', 'course_batches.cmId')
    ->where('course_batches.cbId', '=', $cbId)
    ->get();


    $user_history=DB::select("SELECT  history.chId,module.mName,history.dateAndTime,history.totalQuestions,history.QuestionsAttended,history.rightAns,
    history.wrongAns,history.score,history.percentage,
        GROUP_CONCAT(subm.smName SEPARATOR ',') as smName
        FROM `course_history` as history
        JOIN `user_details` as users on users.uId =history.uId
        JOIN `module` as module on module.mId = history.mId
        JOIN `sub_module` AS subm ON  FIND_IN_SET(subm.smId, history.smId)
        
        WHERE FIND_IN_SET (subm.smId, history.smId) > 0
        AND users.uId = '$uId'
        
        GROUP BY history.chId,module.mName,history.dateAndTime,history.totalQuestions,history.QuestionsAttended,history.rightAns,
    history.wrongAns,history.score,history.percentage;");

    return view('crash_course.show_single_user_history',compact('user_history','user_name','batch_name','course_name'));
   }





   

   // CRASH COURSE SUBSCRIBERS DETAILS --------START HERE---------

   public function showcrashcoursesubscribers()
   {

    $course_details=courseMasterModel::select()->where('isClosed',0)->orderBy('cmId','desc')->get();

    return view('crash_course.show_course_price_details',compact('course_details'));
   }


   public function singlecrashcouse_subscriber($cmId)
   {

    $course_name=courseMasterModel::select('coName')->where('cmId',$cmId)->get();

    $single_course_details=DB::select("SELECT c_users.name,c_users.mobile,c_batch.cbatchName,subscribers.csDate,c_batch.cbatchStartDate,c_batch.cbatchEndDate
    FROM `course_master` as c_master
    INNER JOIN `course_batches` as c_batch on c_batch.cmId = c_master.cmId
    
    INNER JOIN `course_subscribers` as subscribers on subscribers.cmId = c_master.cmId
    
    INNER JOIN `user_details` as c_users on c_users.uId = subscribers.uId
    
    WHERE c_master.cmId = '$cmId' 
    ORDER BY subscribers.csDate DESC  ;");

    return view('crash_course.single_course subscribers',compact('single_course_details','course_name'));


   }





   

   // CRASH COURSE SUPER ADMIN AREA
   public function addcoursesupadmin()
   {
       $course_details = courseMasterModel::select()->orderBy('isClosed','ASC')->get();

       return view('admin.add_crash_course_master',compact('course_details'));
   }


   public function updatecoursesupadmin($encryptedId)
   {
   // print_r($encryptedId);die;
       $cmId = Crypt::decrypt($encryptedId);

    //   print_r($cmId);die;
       
       $select_course_single = courseMasterModel::where('cmId',$cmId)->get();
      

       return view('admin.edit_crash_course_master',compact('select_course_single'));
   
   }

   //update course

   public function update_course_supadmin_dta(Request $request)
   {
       $validatedData = $request->validate([
           'coursename' => 'required',
           'coursedesc' => 'required',
           'activeprice' => 'required|numeric',
           'offerprice' => 'required|numeric',
           'coursedays' => 'required',

       ], [
           'coursename.required' => 'This field is required.',
           'coursedesc.required' => 'This field is required.',
           'activeprice.required' => 'This field is required.',
           'offerprice.required' => 'This field is required.',
           'coursedays.required' => 'This field is required.',
       ]);


       $user_id = request('user_id');
       $cmId    = request('cmId');

       $courseName = request('coursename');
       $courseName=preg_replace('/\s+/', ' ', $courseName);
       $courseName=strtoupper($courseName);
       //$courseName  =  request('coursename');
       $courseDesc  =  request('coursedesc');
       $Activeprice =  request('activeprice');
       $offerPrice  =  request('offerprice');
       $Days        =  request('coursedays');
      /// $isClose     = "0";

       $saveCourse = courseMasterModel::find($cmId);

       $saveCourse->update([
           "coName"             => $courseName,
           "coDescription"      => $courseDesc,
           "coActivePrice"      => $Activeprice,
           "coOfferPrice"       => $offerPrice,
           "coDays"             => $Days,
       
           "updated_by"         => $user_id
       ]);

       return redirect('/addcoursesupadmin')->with('success','Course Updated');



   }




   public function addcoursesupadminbatch()
   {
       $course_data = courseMasterModel::select()->where('isClosed',0)->orderBy('coName', 'ASC')->get();

       $batch_details =courseBatchesModel::select('course_batches.*', 't2.coName')
       ->join('course_master as t2', 't2.cmId', '=', 'course_batches.cmId')
       ->where('t2.isClosed',0)
       ->orderBy('course_batches.isClosed','ASC')
       ->get();

       return view('admin.add_batches',compact('course_data','batch_details'));
   }


   
   public function updatesupadminbatch($encrypted)
   {
       
       $cbId = Crypt::decrypt($encrypted);
       
       $select_batch_single = courseBatchesModel::where('cbId',$cbId)->get();
       $select_course_details =courseMasterModel::select('cmId','coName')->where('isClosed',0)->get();
      

       return view('admin.edit_batch',compact('select_batch_single','select_course_details'));
   
   }


   //update course

   public function update_supadmin_batch_dta(Request $request)
   {
       $validatedData = $request->validate([
           'coursename' => 'required',
           'batchname'  => 'required',
           'startdate'  => 'required',
           'enddate'    => 'required',
           'batchdays' => 'required',

       ], [
           'coursename.required'  => 'This field is required.',
           'batchname.required'   => 'This field is required.',
           'startdate.required'   => 'This field is required.',
           'enddate.required'     => 'This field is required.',
           'batchdays.required'  => 'This field is required.',
       ]);

       $user_id       = request('user_id');
       $cbId          = request('cbId');
       $courseName    = request('coursename');
       $batchname     = request('batchname');
       $startdate     = request('startdate');
       $enddate       = request('enddate');
       $batchdays     = request('batchdays');

      

       $updateBatch = courseBatchesModel::find($cbId);

       $updateBatch->update([
                       "cmId"                => $courseName,
                       "cbatchName"          => $batchname,
                       "cbatchStartDate"     => $startdate,
                       "cbatchEndDate"       => $enddate,
                       "cbatchDays"          => $batchdays,
                      
                        "updated_by"         => $user_id
       ]);

       return redirect('/addcoursesupadminbatch')->with('success','Batch Updated');



   }



   
   //batch with students
   public function addstunentsupadminstobatch()
   {

    $students_in_batches=DB::select("SELECT DISTINCT
    batches.cbId,
    course.coName,
    batches.cbatchName,
    COALESCE(total_students.total_count, 0) AS total_students,
    batch_student.isActive
    FROM `course_master` AS course
    JOIN `course_subscribers` AS subscriber ON subscriber.cmId = course.cmId
    JOIN `course_batches` AS batches ON batches.cmId = course.cmId
    JOIN ( SELECT cbId, COUNT(uId) AS total_count
    FROM `course_batch_with_students`
    GROUP BY cbId ) AS total_students ON total_students.cbId = batches.cbId
    JOIN ( SELECT cbId, MAX(uId) AS latest_uId
    FROM `course_batch_with_students`
    GROUP BY cbId ) AS latest_students ON latest_students.cbId = batches.cbId
    JOIN `course_batch_with_students` AS batch_student ON batch_student.cbId = batches.cbId
    ORDER BY batch_student.isActive ASC; ");

    $course_data = courseMasterModel::select()->where('isClosed',0)->get();

    return view('admin.add_students_toBatch',compact('course_data','students_in_batches'));
   }


   public function studentssupadminaddedbatchtotalstudentsTake(Request $request,$cbId)
   {

  // $cbId = request('cbId');
   $batch_name =courseBatchesModel::select('cbatchName')->where('cbId',$cbId)->get();

   $students_in_batches=DB::select("SELECT DISTINCT course.coName, batches.cbatchName,students.name,batch_student.cbwsId,batch_student.isActive
                       FROM  `course_master` AS course
                       JOIN  `course_subscribers` AS subscriber ON subscriber.cmId = course.cmId
                       LEFT JOIN  `course_batches` AS batches ON batches.cmId = course.cmId
                       LEFT JOIN  `course_batch_with_students` as batch_student ON batch_student.cbId = batches.cbId
                       LEFT JOIN `user_details` as students on students.uId = batch_student.uId
                       WHERE batch_student.cbId = $cbId;");

       return view('admin.show_batch_added_students',compact('students_in_batches','batch_name'));
   }



   
   public function addbatchdaysupadminsactivities()
   {

    $batch_days_details =DB::select("SELECT DISTINCT  batch_days.cbId,c_master.coName, batches.cbatchName,
    batches.cbatchDays as duration,
    COUNT(batch_days.cbId) as total_days
    FROM course_master AS c_master
    JOIN course_batches AS batches ON batches.cmId = c_master.cmId
    JOIN course_batch_days AS batch_days ON batch_days.cbId = batches.cbId
    GROUP BY c_master.coName, batches.cbatchName,batch_days.cbId,batches.cbatchDays;");


    $module_data = ModuleModel::select()->where('isAvail',0)->get();
    $course_data = courseMasterModel::select()->where('isClosed',0)->get();

    return view('admin.add_days_batch_activity',compact('course_data','module_data','batch_days_details'));
   }



   

   public function viewmoredayssupadmin_act($cbId)
   {

    $batch_name = courseBatchesModel::select('cbatchName')
    ->where('cbId','=',$cbId)
    ->get();

    // $batch_days_details =DB::select("SELECT batch_days.Date,batch_days.dayName,batch_days.cbdId,
    // c_master.coName,
    // batches.cbatchName,
    // module.mName,
    // subm.smName
    // FROM course_master AS c_master
    // JOIN course_batches AS batches ON batches.cmId = c_master.cmId
    // JOIN course_batch_days AS batch_days ON batch_days.cbId = batches.cbId
    // JOIN module ON module.mId = batch_days.mId
    // JOIN sub_module AS subm ON subm.smId = batch_days.smId
    // WHERE batch_days.cbId = '$cbId'
    // AND batch_days.isActive = 0;
    // ");
    $batch_days_details =DB::select("SELECT batch_days.Date,batch_days.dayName,batch_days.cbdId,
    c_master.coName,
    batches.cbatchName,
    module.mName,
    GROUP_CONCAT(subm.smName SEPARATOR ',') as smName
    
    FROM course_master AS c_master
    JOIN course_batches AS batches ON batches.cmId = c_master.cmId
    JOIN course_batch_days AS batch_days ON batch_days.cbId = batches.cbId
    JOIN module ON module.mId = batch_days.mId
    
    JOIN sub_module AS subm ON  FIND_IN_SET(subm.smId, batch_days.smId)
    
    WHERE FIND_IN_SET (subm.smId, batch_days.smId) > 0
    AND batch_days.cbId = '$cbId'
    AND batch_days.isActive = 0
    GROUP BY batch_days.Date,batch_days.dayName,batch_days.cbdId,
    c_master.coName,
    batches.cbatchName,
    module.mName
    ORDER BY batch_days.cbdId ASC;");


    

    return view('admin.show_batch_days',compact('batch_days_details','batch_name'));
   }


   // PAYMENT HISTORY
    public function show_crash_payment_hist()
   {

    $payment_his=DB::select("SELECT subscribers.csDate,subscribers.transactionNumber,det.name,det.mobile,c_mast.coName,subscribers.netPayableAmount
    FROM `course_subscribers` as subscribers
    JOIN `course_master` as c_mast on c_mast.cmId = subscribers.cmId
    JOIN `user_details` as det on det.uId = subscribers.uId
    ORDER BY subscribers.csDate DESC;");

    return view('crash_course.show_users_payment_hist',compact('payment_his'));
   }












}
