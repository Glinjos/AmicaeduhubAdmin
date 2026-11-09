<?php

namespace App\Http\Controllers;

use App\Models\PreviousQuestionModels\CategoryModel;
use App\Models\PreviousQuestionModels\PQAnswerModel;
use App\Models\PreviousQuestionModels\PQuestionModel;
use App\Models\PreviousQuestionModels\SubCategoryModel;
use App\Models\pqmainModel;
use Illuminate\Routing\Controller;

use Illuminate\Http\Request;
use App\Models\ModuleModel;

use DB;
use App\Models\ImagePQAModel\imagePquestionModel;
use App\Models\ImagePQAModel\imagePanswerModel;

use Illuminate\Support\Facades\Crypt;


use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Session;

class PQuestionController extends Controller
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

//Previous year question

//addCategory
    function Category()
    {
       //$category =CategoryModel::orderBy('isAvail', 'ASC')->get();
        $select1 =pqmainModel::select('pqmainId','pqmainName')->where('isAvail','=','0')->get();
       $select2=DB:: select("SELECT A.pqmainId,A.pqmainName,B.pqmId,B.pqmName,B.isAvail FROM pq_main AS A INNER JOIN pq_module as B ON A.pqmainId=B.pqmainId ORDER BY B.isAvail ASC");
       
       return view('previous_question/category', compact('select1','select2'));
    }

    function addCategory(Request $request)
    {
        $validatedData = $request->validate([
            'CategoryName' => 'required|min:2|max:50',
            'examType' => 'required',

        ], [
             'CategoryName.required' => 'This field is required.',
            'examType.required' => 'This field is required.',
        ]);

        $createdBy=$request['user_id'];
        $updatedBy='0';

        $createdAt= $this->currentDateTime;
        
        $pqmainId=$request['examType'];


        $pqmName = $request['CategoryName'];
        $pqmName=preg_replace('/\s+/', ' ', $pqmName);
        $pqmName=strtoupper($pqmName);

         $pqmodule2 = CategoryModel::where('pqmName', $request->CategoryName)
                           ->where('pqmainId',$request->examType)
                           ->first();

        if ($pqmodule2 != null) {
            return redirect()->back()->with('error','Category is Already Exists');
        } else {
            $pqmodule = new CategoryModel();
            $pqmodule->pqmainId = $pqmainId;
            $pqmodule->pqmName = $pqmName;
            $pqmodule->created_by = $createdBy;
            $pqmodule->created_at = $createdAt;
            $pqmodule->updated_by = $updatedBy;

            $pqmodule->save();
            return redirect()->back()->with('success','Category Added');
        }
    }

    function updateCategoryForm($pqmId)
    {
        $category = CategoryModel::select('pqmId','pqmName')->where('pqmId',$pqmId)->get();
        return view('previous_question/updateCategory', compact('category'));
    }

    function updateCategory(Request $request,$pqmId)
    {
        $validatedData = $request->validate([
            'CategoryName' => 'required|min:2|max:50'],
            ['CategoryName.required' => 'Category name field is required.']);

        $updatedBy=$request['user_id'];
        $updatedAt= $this->currentDateTime;

        $pqmName = $request['CategoryName'];
        $pqmName=preg_replace('/\s+/', ' ', $pqmName);
        $pqmName=strtoupper($pqmName);

        $module2=DB::select("SELECT * FROM `pq_module` WHERE `pqmId` NOT IN ($pqmId) AND (`pqmName`='$pqmName')");
         if($module2 != null ) {
            return redirect()->back()->with('error','Category Name Already Exists');
        } else {
             $category = CategoryModel::find($pqmId);

             $category->update([
                'pqmId'=>$pqmId,
                'pqmName' =>  $pqmName,
                'updated_by'=> $updatedBy,
                'updated_at'=>$updatedAt
            ]);
            return redirect("/category")->with('success','Category Updated');
        }
    }

    function categoryNameCheck()
    {
        $pqmName=request()->get('pqmName');
        $pqmainId=request()->get('pqmainId');
        // $category=DB::select("SELECT * FROM `pq_module` WHERE `pqmName`='$pqmName'");
        $category=DB::select("SELECT pqmId, pqmainId, pqmName 
        FROM pq_module 
        WHERE pqmainId = '$pqmainId' 
        AND pqmName = '$pqmName'
        ");
        return $category;
    }

    function categoryDelete($pqmId)
    {
        $category=CategoryModel::find($pqmId);
        $category->delete($pqmId);

        $selectPQsmId=(DB::select("SELECT `pqsmId` FROM `pq_submodule` WHERE `pqmId`='$pqmId'"));

        foreach($selectPQsmId as $row) {
            $pqsmId = $row->pqsmId;
            $subCategory = SubCategoryModel::find($pqsmId);
            $subCategory->delete($pqsmId);



            $selectPQId = (DB::select("SELECT `pqId` FROM `p_questions` WHERE `pqsmId`='$pqsmId'"));
            foreach ($selectPQId as $row) {
                $pqId = $row->pqId;
                $PQuestions = PQuestionModel::find($pqId);
                $PQuestions->delete($pqId);

                $selectPAId = (DB::select("SELECT `paId` FROM `p_answers` WHERE `pqId`='$pqId'"));
                foreach ($selectPAId as $row) {
                    $paId = $row->paId;
                    $PAnswers = PQAnswerModel::find($paId);
                    $PAnswers->delete($paId);
                }
            }
        }
        return redirect()->back()->with('success','Category Deleted');
    }

    public function disableCategory($pqmId)
    {
        $isAvail=1;
        CategoryModel::where('pqmId',$pqmId)->update(['isAvail'=>$isAvail]);
        SubCategoryModel::where('pqmId',$pqmId)->update(['isAvail'=>$isAvail]);

        $selectPQSmId=(DB::select("SELECT `pqsmId` FROM `pq_submodule` WHERE `pqmId`='$pqmId'"));

        foreach($selectPQSmId as $row)
        {
            $pqsmId = $row->pqsmId;
            PQuestionModel::where('pqsmId',$pqsmId)->update(['isAvail'=>$isAvail]);
            $selectPQId=(DB::select("SELECT `pqId` FROM `p_questions` WHERE `pqsmId`='$pqsmId'"));
            foreach($selectPQId as $row)
            {
                $pqId = $row->pqId;
                PQAnswerModel::where('pqId',$pqId)->update(['isAvail'=>$isAvail]);
            }
        }

        return redirect()->back()->with('success','Category Deactivated');
    }

    public function EnableCategory($pqmId)
    {
        $isAvail=0;
        CategoryModel::where('pqmId',$pqmId)->update(['isAvail'=>$isAvail]);
        SubCategoryModel::where('pqmId',$pqmId)->update(['isAvail'=>$isAvail]);

        $selectPQSmId=(DB::select("SELECT `pqsmId` FROM `pq_submodule` WHERE `pqmId`='$pqmId'"));

        foreach($selectPQSmId as $row)
        {
            $pqsmId = $row->pqsmId;
            PQuestionModel::where('pqsmId',$pqsmId)->update(['isAvail'=>$isAvail]);
            $selectPQId=(DB::select("SELECT `pqId` FROM `p_questions` WHERE `pqsmId`='$pqsmId'"));
            foreach($selectPQId as $row)
            {
                $pqId = $row->pqId;
                PQAnswerModel::where('pqId',$pqId)->update(['isAvail'=>$isAvail]);
            }
        }

        return redirect()->back()->with('success','Category Activated');
    }


    //subCategory

    function subCategory()
    {
        $select3 =pqmainModel::select('pqmainId','pqmainName')->where('isAvail','=','0')->get();
       // $select1 =CategoryModel::select()->orderBy('isAvail', 'ASC')->where('isAvail','0')->get();
        $select1 =CategoryModel::select()->orderBy('isAvail', 'ASC')->get();
        $select=DB:: select("SELECT A.pqmId, A.pqmainId, A.pqmName, B.pqsmId, B.pqmId, B.pqsmName, B.isAvail, C.pqmainId, C.pqmainName
            FROM pq_module AS A
            INNER JOIN pq_submodule AS B ON A.pqmId = B.pqmId
            INNER JOIN pq_main AS C ON C.pqmainId = A.pqmainId
            ORDER BY B.isAvail ASC");
        return view('previous_question/subcategory', compact('select','select1','select3'));
    }

    public function addsubcategory(Request $request)
    {
        $validatedData = $request->validate([
            'subCategory' => 'required|min:3|max:100',

        ], [
            'subCategory.required' => 'Sub Category Name field is required.',
        ]);


        $createdBy=request('user_id');                                                      //FROM SESSION

        //FROM SESSION
        // $createdAt= $this->currentDateTime;

        $pqmainId=request('examtype');
        $pqmId =request('module');

        $pqsmName = request('subCategory');
        $pqsmName=preg_replace('/\s+/', ' ', $pqsmName);
        $pqsmName=ucwords($pqsmName);

        $subcategory = SubCategoryModel::where('pqsmName', $request->subCategory)
                           ->where('pqmId',$request->module)
                           ->first();
        
        if ($subcategory != null) {
            return redirect()->back()->with('error','Subcategory Already Exists');
        }
        else
        {
            $subcategory = new SubCategoryModel();
            $subcategory->pqmId = $pqmId;
            $subcategory->pqsmName = $pqsmName;
            $subcategory->created_by = $createdBy;
            $subcategory->save();
            
            return redirect()->back()->with([
                'success' => 'Sub Category Added',
                'pqmId' => $pqmId,
                'pqmainid' =>$pqmainId
            ]); 
        }
    }

//    function subCategoryNameCheck()
//    {
//        $pqsmName=request()->get('pqsmName');
//        $subcategory=DB::select("SELECT * FROM `pq_submodule` WHERE `pqsmName`='$pqsmName'");
//        return $subcategory;
//    }
    function subcategoryAjaxNameCheck()
    {
        $pqsmName=request('subcatname');
        $pqmId=request('pqmId');
        $isAvail=0;

        $submodule=DB::select("SELECT pqsmId, pqmId, pqsmName 
        FROM pq_submodule 
        WHERE pqmId = '$pqmId' 
        AND pqsmName = '$pqsmName'
        ");

        return $submodule;

    }


    function updateSubCategoryForm($pqsmId)
    {
        $subcategory = SubCategoryModel::select('pqsmId','pqsmName')->where('pqsmId',$pqsmId)->get();
        return view('previous_question/updateSubCategory', compact('subcategory'));
    }

    public function updateSubCategory(Request $request,$pqsmId)
    {
        $validatedData = $request->validate([
            'pqsmName' => 'required|min:3|max:100',

        ], [
            'pqsmName.required' => 'Sub Category name field is required.',
        ]);


        $updatedBy=$request['user_id'];
        $updatedAt= $this->currentDateTime;


        $pqsmName = $request['pqsmName'];
        // dd($smName);
        $pqsmName=preg_replace('/\s+/', ' ', $pqsmName);
        $pqsmName=ucwords($pqsmName);

        $subcategory=DB::select("SELECT * FROM `pq_submodule` WHERE `pqsmId` NOT IN ($pqsmId) AND (`pqsmName`='$pqsmName')");
        if($subcategory != null ) {
            return redirect()->back()->with('error','Sub Category Name Already Exists');
        } else {

            $subcategory = SubCategoryModel::find($pqsmId);

            $subcategory->update([
                'pqsmId' => $pqsmId,
                'pqsmName' => $pqsmName,
                'updated_by' => $updatedBy,
                'updated_at' => $updatedAt
            ]);
            return redirect("/subcategory")->with('success', 'Sub Category Updated');
        }

    }

    function subCategoryDelete($pqsmId)
    {
        $subcategory=SubCategoryModel::find($pqsmId);
        $subcategory->delete($pqsmId);

        $selectPQId = (DB::select("SELECT `pqId` FROM `p_questions` WHERE `pqsmId`='$pqsmId'"));
        foreach ($selectPQId as $row) {
            $pqId = $row->pqId;
            $PQuestions = PQuestionModel::find($pqId);
            $PQuestions->delete($pqId);

            $selectPAId = (DB::select("SELECT `paId` FROM `p_answers` WHERE `pqId`='$pqId'"));
            foreach ($selectPAId as $row) {
                $paId = $row->paId;
                $PAnswers = PQAnswerModel::find($paId);
                $PAnswers->delete($paId);
            }
        }
        return redirect("/subcategory")->with('success','Sub Category Deleted');
    }


    public function disableSubCategory($pqsmId)
    {
        $isAvail=1;
        SubCategoryModel::where('pqsmId',$pqsmId)->update(['isAvail'=>$isAvail]);

            PQuestionModel::where('pqsmId',$pqsmId)->update(['isAvail'=>$isAvail]);
            $selectPQId=(DB::select("SELECT `pqId` FROM `p_questions` WHERE `pqsmId`='$pqsmId'"));
            foreach($selectPQId as $row)
            {
                $pqId = $row->pqId;
                PQAnswerModel::where('pqId',$pqId)->update(['isAvail'=>$isAvail]);
            }


        return redirect()->back()->with('success','Sub Category Deactivated');
    }

    public function EnableSubCategory($pqsmId)
    {
        $isAvail=0;
        SubCategoryModel::where('pqsmId',$pqsmId)->update(['isAvail'=>$isAvail]);

        PQuestionModel::where('pqsmId',$pqsmId)->update(['isAvail'=>$isAvail]);
        $selectPQId=(DB::select("SELECT `pqId` FROM `p_questions` WHERE `pqsmId`='$pqsmId'"));
        foreach($selectPQId as $row)
        {
            $pqId = $row->pqId;
            PQAnswerModel::where('pqId',$pqId)->update(['isAvail'=>$isAvail]);
        }

        return redirect()->back()->with('success','Sub Category Activated');
    }




    function addPQA()
    {

        $select3 =pqmainModel::select('pqmainId','pqmainName')->where('isAvail','=','0')->get();
       // $categoryView = CategoryModel::select()->orderBy('isAvail', 'ASC')->where('isAvail','0')->get();
        $categoryView = CategoryModel::select()->orderBy('isAvail', 'ASC')->get();
       
        return view('previous_question/PQ_add_form',compact('categoryView','select3'));
    }

    function pqModuleCheckformain()
    {

        $pqmainid=request()->get('pqmainId');
       // $pq_submodule_view = CategoryModel::select()->where('pqmainId',$pqmainid)->where('isAvail','0')->get();
        $pq_submodule_view = CategoryModel::select()->where('pqmainId',$pqmainid)->orderBy('pqmName', 'ASC')->get();
        return $pq_submodule_view;
    }

    function pqSubModuleCheck()
    {

        $pqmid=request()->get('pqmid');
       // $pq_submodule_view = SubCategoryModel::select()->where('pqmId',$pqmid)->where('isAvail','0')->get();
        $pq_submodule_view = SubCategoryModel::select()->where('pqmId',$pqmid)->orderBy('pqsmName', 'ASC')->get();
        return $pq_submodule_view;
    }

//   public function postPreQues(Request $Request)
//     {

//         $validatedData = $Request->validate([
//             'question' => 'required',
//             'option1' => 'required',
//             'option2' => 'required',
//             'option3' => 'required',
//             'option4' => 'required',

//         ], [
//             'question.required' => 'Spell Something!',
//             'option1.required' => 'Spell Something!',
//             'option2.required' => 'Spell Something!',
//             'option3.required' => 'Spell Something!',
//             'option4.required' => 'Spell Something!',
//         ]);

//         $pqmainid= request('examtype');

//         $pqmid= request('module');
       
//         $pqsmid = request('smodule');
//         // print_r($pqsmid);die();

//         $question = request('question');
//         $option1 = request('option1');
//         $option2 = request('option2');
//         $option3 = request('option3');
//         $option4 = request('option4');
//         $answer = request('answer');

//         $created_by =  request('user_id');
//         $updated_by =  '0';
//         $isAvail =  '2';

// //check the answers

//         if($answer=="option1")
//         {
//             $value1=1;
//             $value2=0;
//             $value3=0;
//             $value4=0;
//         }
//         else if($answer=="option2")
//         {
//             $value1=0;
//             $value2=1;
//             $value3=0;
//             $value4=0;
//         }
//         else if($answer=="option3")
//         {
//             $value1=0;
//             $value2=0;
//             $value3=1;
//             $value4=0;
//         }
//         else if($answer=="option4")
//         {
//             $value1=0;
//             $value2=0;
//             $value3=0;
//             $value4=1;
//         }

// //INSERT QUESTIONS TO QUESTION TABLE

//         PQuestionModel::create([
//             'pqsmId'=>$pqsmid,//pqsmid
//             'question'=>$question,
//             'optionA'=>$option1,
//             'optionB'=>$option2,
//             'optionC'=>$option3,
//             'optionD'=>$option4,
//             'isAvail'=>$isAvail,
//             'created_by'=>$created_by,
//             'updated_by'=>$updated_by

//         ]);

//         $pqId=PQuestionModel::get()->max('pqId');

// //INSERT ANSWER TO PQANSWERS TABLE
//         PQAnswerModel::create([
//             'pqId'=>$pqId,
//             'optionA'=>$value1,
//             'optionB'=>$value2,
//             'optionC'=>$value3,
//             'optionD'=>$value4,
//             'isAvail'=>$isAvail,
//             'created_by'=>$created_by,
//             'updated_by'=>$updated_by
//         ]);

// //update CURRENT CODE AND UPDATED BY INTO PQSUBMODULE

//         DB::update("UPDATE `pq_submodule` SET`updated_by`= $updated_by where `pqsmId`=$pqsmid");

//       // return redirect()->back()->with('success','Question Added');
//         return redirect()->back()->with([
//             'success' => 'Question Added',
//             'pqmainid' =>$pqmainid,
//             'pqmid' => $pqmid,
//             'pqsmid' =>$pqsmid
//         ]); 
//     }

 //image upload
    //richtext image upload


    public function uploadimage (Request $request){ 


        if ($request->hasFile('upload')) {
        
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName.time().'.'.$extension;
        
        $request->file('upload')->move(public_path('imagePQA'),$fileName);
        $url = asset('public/imagePQA/'.$fileName);
        
        //  $request->file('upload')->storeAs('imagePQA', $fileName, 'public');
        //  $url = asset('storage/imagePQA/' . $fileName);
        
        
        return response()->json(['fileName' => $fileName, 'uploaded'=> 1, 'url' => $url]);
            
        }
        }

    //richtext image upload end

   public function postPreQues(Request $Request)
    {

        // $validatedData = $Request->validate([
        //     'question' => 'required',
        //     'option1' => 'required',
        //     'option2' => 'required',
        //     'option3' => 'required',
        //     'option4' => 'required',

        // ], [
        //     'question.required' => 'Spell Something!',
        //     'option1.required' => 'Spell Something!',
        //     'option2.required' => 'Spell Something!',
        //     'option3.required' => 'Spell Something!',
        //     'option4.required' => 'Spell Something!',
        // ]);

        $pqmainid= request('examtype');

        $pqmid= request('module');
       
        $pqsmid = request('smodule');


        $radio_button_check= request('group1');
        if($radio_button_check == 07)
        {

             // for normal image insertion
                $question = request('question');
                $option1 = request('option1');
                $option2 = request('option2');
                $option3 = request('option3');
                $option4 = request('option4');
                $answer = request('answer');

                $created_by =  request('user_id');
                $updated_by =  '0';
                $isAvail =  '2';

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

                PQuestionModel::create([
                    'pqsmId'=>$pqsmid,//pqsmid
                    'question'=>$question,
                    'optionA'=>$option1,
                    'optionB'=>$option2,
                    'optionC'=>$option3,
                    'optionD'=>$option4,
                    'isAvail'=>$isAvail,
                    'created_by'=>$created_by,
                    'updated_by'=>$updated_by

                ]);

                $pqId=PQuestionModel::get()->max('pqId');

        //INSERT ANSWER TO PQANSWERS TABLE
                PQAnswerModel::create([
                    'pqId'=>$pqId,
                    'optionA'=>$value1,
                    'optionB'=>$value2,
                    'optionC'=>$value3,
                    'optionD'=>$value4,
                    'isAvail'=>$isAvail,
                    'created_by'=>$created_by,
                    'updated_by'=>$updated_by
                ]);

        //update CURRENT CODE AND UPDATED BY INTO PQSUBMODULE

                DB::update("UPDATE `pq_submodule` SET`updated_by`= $updated_by where `pqsmId`=$pqsmid");

            // return redirect()->back()->with('success','Question Added');
                return redirect()->back()->with([
                    'success' => 'Question Added',
                    'pqmainid' =>$pqmainid,
                    'pqmid' => $pqmid,
                    'pqsmid' =>$pqsmid
                ]); 

        }else{

            $question = request('questionIMAGE');
            $option1 = request('option_1image');
            $option2 = request('option_2image');
            $option3 = request('option_3image');
            $option4 = request('option_4image');
            $answer = request('answerImage');

            $created_by =  request('user_id');
            $updated_by =  '0';
            $isAvail =  '2';

        //check the answers

            if($answer=="option1image")
            {
                $value1=1;
                $value2=0;
                $value3=0;
                $value4=0;
            }
            else if($answer=="option2image")
            {
                $value1=0;
                $value2=1;
                $value3=0;
                $value4=0;
            }
            else if($answer=="option3image")
            {
                $value1=0;
                $value2=0;
                $value3=1;
                $value4=0;
            }
            else if($answer=="option4image")
            {
                $value1=0;
                $value2=0;
                $value3=0;
                $value4=1;
            }

    //INSERT QUESTIONS TO QUESTION TABLE

    imagePquestionModel::create([
                'pqsmId'=>$pqsmid,//pqsmid
                'question'=>$question,
                'optionA'=>$option1,
                'optionB'=>$option2,
                'optionC'=>$option3,
                'optionD'=>$option4,
                'isAvail'=>$isAvail,
                'created_by'=>$created_by,
                'updated_by'=>$updated_by

            ]);

            $ipqId=imagePquestionModel::get()->max('ipqId');

    //INSERT ANSWER TO PQANSWERS TABLE
    imagePanswerModel::create([
                'ipqId'=>$ipqId,
                'optionA'=>$value1,
                'optionB'=>$value2,
                'optionC'=>$value3,
                'optionD'=>$value4,
                'isAvail'=>$isAvail,
                'created_by'=>$created_by,
                'updated_by'=>$updated_by
            ]);

   
            return redirect()->back()->with([
                'success' => 'Question Added',
                'pqmainid' =>$pqmainid,
                'pqmid' => $pqmid,
                'pqsmid' =>$pqsmid
            ]); 

        }//end 
       


    }// end fumction





    public function showPQA()
    {
        $module_view=CategoryModel::select()->get();

        $question=DB::select("SELECT  a.pqId AS questionId, a.pqsmId AS subModuleId,a.question,
        a.optionA as optionA,
        a.optionB as optionB,
        a.optionC as optionC,
        a.optionD as optionD,
        b.optionA as a,
        b.optionB as b,
        b.optionC as c,
        b.optionD as d, 
    f.pqmainName as PmainName,f.pqmainId AS PmainId,
    c.pqsmName as PsubModuleName, c.pqsmId AS PsubModuleId,
    d.pqmName as PmoduleName,d.pqmId as PmoduleId    
        FROM `p_questions`as a 
         
        JOIN `pq_submodule` as c
        ON c.pqsmId=a.pqsmId
        
        JOIN `pq_module` as d
        ON c.pqmId=d.pqmId
        
        JOIN `pq_main` as f
        
         ON f.pqmainId=d.pqmainId 
        
        JOIN  `p_answers`as b  
        ON a.`pqId`=b.`pqId`
         WHERE a.`isAvail`=0
            AND b.`isAvail`=0 
            AND d.`isAvail` IN (0,1)
            AND c.`isAvail` IN (0,1)
            AND f.`isAvail`=0
            ORDER BY b.pqId DESC");
        return view('previous_question/PQAshow',compact('module_view','question'));
    }

    function PquestionTake()
    {
        $pqId=request()->get('pqId');
        $allQuestions=
            (DB::select("SELECT t1.*, t2.*, t3.*, t4.*, b.`optionA` as ansA, b.`optionB` as ansB, b.`optionC` as ansC, b.`optionD` as ansD
              FROM `p_questions` t4
              INNER JOIN `pq_submodule` t3 ON t4.pqsmId = t3.pqsmId
              INNER JOIN `pq_module` t2 ON t3.pqmId = t2.pqmId
              INNER JOIN `pq_main` t1 ON t2.pqmainId = t1.pqmainId
              INNER JOIN `p_answers` b ON t4.`pqId` = b.`pqId`
              WHERE t4.`pqId` =$pqId;"));
        return $allQuestions;
    }

    function PmoduleShow(){
        $pqmodule= DB::select("SELECT * from `pq_module`");
        return $pqmodule;
    }
    public function deletePQuestion($questionId)
    {
        PQuestionModel::where('pqId',$questionId)->delete();
        PQAnswerModel::where('pqId',$questionId)->delete();
        return redirect("/showPQA")->with('success','Question Deleted');
    }


    public function PquestionUpdate(Request $request)
    {
        $pqId = request('pqId');

        $smIdfrominput = request('pqsmId');
        $smIdfromdropdown = request('showsubmoduledropdown');
        if($smIdfromdropdown==""){
            $pqsmId=$smIdfrominput;//NO DROPDOWN SELECTED
        }else{
            $pqsmId=$smIdfromdropdown;//SUBCATEGORY CHANGED
        }

        $question = request('question');
        $option1 = request('option1');
        $option2 = request('option2');
        $option3 = request('option3');
        $option4 = request('option4');
        $answer = request('answer');

        $updated_by = request('user_id');                  /////////////from SESSION VALUE
        $updated_at= $this->currentDateTime;   /////////////from date
        $isAvail='0';

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

        $pqmodule = PQuestionModel::find($pqId);
        //print_r($pqId);die;

        $pqmodule->update([
            'pqsmId' =>  $pqsmId,
            'question'=>$question,
            'optionA'=> $option1,
            'optionB'=> $option2,
            'optionC'=> $option3,
            'optionD'=> $option4,
            'isAvail'=>$isAvail,
            'updated_at'=>$updated_at,
            'updated_by'=>$updated_by]);
        //UPDATE ANSWER TO ANSWERS TABLE
        DB::update("UPDATE `p_answers` SET `optionA`=$value1,`optionB`=$value2,`optionC`=$value3,`optionD`=$value4,`isAvail`=$isAvail,`updated_by`=$updated_by WHERE `pqId`=$pqId");

        return redirect("/showPQA")->with('success','Question Updated');
    }

    function Categoryshow(){
        $pqmainId=request()->get('pqmainId');
      //  $category=  CategoryModel::select()->where('pqmainId',$pqmainId)->where('isAvail','0')->get();
        $category=  CategoryModel::select()->where('pqmainId',$pqmainId)->get();
        return $category;
    }

    function subCategoryshow()
    {
        $pqmId=request()->get('pqmId');
       // $subcategory = SubCategoryModel::select()->where('pqmId',$pqmId)->where('isAvail','0')->get();
        $subcategory = SubCategoryModel::select()->where('pqmId',$pqmId)->get();
        return $subcategory;
    }
    function ExamTypeshow(){
        $category= DB::select("SELECT * from `pq_main` WHERE `isAvail`='0'");
        return $category;
    }
    function updatePreviousQuestionForm()
    {
        $pqId=request('pqId');
        // $allQuestions=(DB::select("SELECT a.* , (SELECT `pqmId` FROM `pq_submodule` WHERE `pqsmId`=(a.pqsmId)) as pqmId,
        //  (SELECT `pqmName` FROM `pq_module` WHERE `pqmId`=(SELECT `pqmId` FROM `pq_submodule`WHERE `pqsmId`=(a.pqsmId)))as pqmName,
        //   (SELECT `pqsmName` FROM `pq_submodule` WHERE `pqsmId`=(a.pqsmId))as pqsmName, b.`optionA` as ansA,b.`optionB` as ansB,b.`optionC` as ansC,b.`optionD` as ansD FROM `p_questions`
        //    as a JOIN `p_answers`
        //  as b on a.`pqId`=`b`.`pqId` where a.`pqId`=$pqId;"));
         $allQuestions=(DB::select("SELECT t1.*, t2.*, t3.*, t4.*, b.`optionA` as ansA, b.`optionB` as ansB, b.`optionC` as ansC, b.`optionD` as ansD
         FROM `p_questions` t4
         INNER JOIN `pq_submodule` t3 ON t4.pqsmId = t3.pqsmId
         INNER JOIN `pq_module` t2 ON t3.pqmId = t2.pqmId
         INNER JOIN `pq_main` t1 ON t2.pqmainId = t1.pqmainId
         INNER JOIN `p_answers` b ON t4.`pqId` = b.`pqId`
         WHERE t4.`pqId` =$pqId;"));
        return view('previous_question/edit_pq_question',compact('allQuestions'));
    }
    
    
    
    ////PREVIOUS QUESTION MAIN

    function pqMainForm(){

        
        $examtype =pqmainModel::orderBy('isAvail', 'ASC')->get();
        return view('previous_question/PQ_add_main', compact('examtype'));

        //return view('previous_question.PQ_add_main');

    }


    function addpqmainForm(Request $request)
    {
       // print_r('bcuqsbub');die();
        $validatedData = $request->validate([
            'examName' => 'required|regex:/^[\pL\s]+$/u|min:2|max:50',

        ], [
            'examName.required' => 'Exam name field is required.',
        ]);

        $createdBy=$request['user_id'];
        $updatedBy='0';
       

        $createdAt= $this->currentDateTime;
        $positiveMark = $request['positiveMark'];
        $negativeMark = $request['negativeMark'];
       // print_r($negativeMark);die;


        $pqmainName = $request['examName'];
       
        $pqmainName=preg_replace('/\s+/', ' ', $pqmainName);
        $pqmainName=strtoupper($pqmainName);

        $pqmodule = pqmainModel::where('pqmainName',$request->examName)->first();
       
        // dd($pqmodule2);
       // print_r($pqmodule2);die();

        if ($pqmodule != null) {
            return redirect()->back()->with('error','Exam Name Already Exists');
        } else {
        
            $pqmodule = new pqmainModel();
            $pqmodule->pqmainName = $pqmainName;
            $pqmodule->positiveMark = $positiveMark;
            $pqmodule->negativeMark = $negativeMark;
            $pqmodule->created_by = $createdBy;
            $pqmodule->created_by = $createdBy;          
            $pqmodule->created_at = $createdAt;         
            $pqmodule->updated_by = $updatedBy;
            
           // dd($pqmodule);
            $pqmodule->save();
           
            return redirect()->back()->with('success','Exam  Added');
        }
    }


    function PQExamNameCheck()
    {
        $examName=request()->get('pqmainName');
        $pqmainName=DB::select("SELECT * FROM `pq_main` WHERE `pqmainName`='$examName'");
        return $pqmainName;
    }


    function updatePQExamMainForm($pqmainId)
    {
        $examtype = pqmainModel::select('pqmainId','pqmainName','positiveMark','negativeMark')->where('pqmainId',$pqmainId)->get();
        return view('previous_question/PQ_edit_main', compact('examtype'));
    }


   function updateExamMain(Request $request,$pqmainId)
    {
        $validatedData = $request->validate([
            'examName' => 'required|regex:/^[\pL\s]+$/u|min:2|max:50'],
            ['examName.required' => 'Category name field is required.']);

        $updatedBy=$request['user_id'];
        $updatedAt= $this->currentDateTime;

        $positiveMark = $request['positiveMark'];
        $negativeMark = $request['negativeMark'];

        $pqmainName = $request['examName'];
        $pqmainName=preg_replace('/\s+/', ' ', $pqmainName);
        $pqmainName=strtoupper($pqmainName);

        $module2=DB::select("SELECT * FROM `pq_main` WHERE `pqmainId` NOT IN ($pqmainId) AND (`pqmainName`='$pqmainName')");
         if($module2 != null ) {
            return redirect()->back()->with('error','Exam Name Already Exists');
        } else {
             $category = pqmainModel::find($pqmainId);

             $category->update([
                'pqmainId'=>$pqmainId,
                'pqmainName' =>  $pqmainName,
                'positiveMark' =>  $positiveMark,
                'negativeMark' =>  $negativeMark,
                'updated_by'=> $updatedBy,
                'updated_at'=>$updatedAt
            ]);
            return redirect("/pqmain")->with('success','Exam Name Updated');
        }
    }


    function examMainDelete($pqmainId)
    {
        $ExamMain=pqmainModel::find($pqmainId);
        $ExamMain->delete($pqmainId);

        $selectPQmId=(DB::select("SELECT `pqmId` FROM `pq_module` WHERE `pqmainId`='$pqmainId'"));

        foreach($selectPQmId as $row) {
            $pqmId = $row->pqmId;
            $Category = CategoryModel::find($pqmId);
            $Category->delete($pqmId);

        $selectPQsmId=(DB::select("SELECT `pqsmId` FROM `pq_submodule` WHERE `pqmId`='$pqmId'"));

        foreach($selectPQsmId as $row) {
            $pqsmId = $row->pqsmId;
            $subCategory = SubCategoryModel::find($pqsmId);
            $subCategory->delete($pqsmId);



            $selectPQId = (DB::select("SELECT `pqId` FROM `p_questions` WHERE `pqsmId`='$pqsmId'"));
            foreach ($selectPQId as $row) {
                $pqId = $row->pqId;
                $PQuestions = PQuestionModel::find($pqId);
                $PQuestions->delete($pqId);

                $selectPAId = (DB::select("SELECT `paId` FROM `p_answers` WHERE `pqId`='$pqId'"));
                foreach ($selectPAId as $row) {
                    $paId = $row->paId;
                    $PAnswers = PQAnswerModel::find($paId);
                    $PAnswers->delete($paId);
                }
            }
        }
    }
        return redirect()->back()->with('success','Exam Type Deleted');
    }


    public function disableExamType($pqmainId)
    {
        $isAvail=1;
        $module = pqmainModel::where('pqmainId',$pqmainId)->update(['isAvail'=>$isAvail]);
        CategoryModel::where('pqmainId',$pqmainId)->update(['isAvail'=>$isAvail]);

        return redirect()->back()->with('success','Exam Type Deactivated');
    }

    public function ExamTypeEnable($pqmainId)
    {
        $isAvail=0;
        $module = pqmainModel::where('pqmainId',$pqmainId)->update(['isAvail'=>$isAvail]);
        CategoryModel::where('pqmainId',$pqmainId)->update(['isAvail'=>$isAvail]);

        return redirect()->back()->with('success','Exam Type Activated');
    }
    
    
    
    
    /// APPROVING WORKERS ADDED QUESTIONS ------------------------------- DRAFT QUESTIONS RUD


    public function workersShowQ()
    {
        $module_view=CategoryModel::select()->get();

        $question=DB::select("SELECT  a.pqId AS questionId, a.pqsmId AS subModuleId,a.question,
        a.optionA as optionA,
        a.optionB as optionB,
        a.optionC as optionC,
        a.optionD as optionD,
        b.optionA as a,
        b.optionB as b,
        b.optionC as c,
        b.optionD as d, 
    f.pqmainName as PmainName,f.pqmainId AS PmainId,
    c.pqsmName as PsubModuleName, c.pqsmId AS PsubModuleId,
    d.pqmName as PmoduleName,d.pqmId as PmoduleId,
    a.isAvail as isAvail,b.isAvail as isAvail    
        FROM `p_questions`as a 
         
        JOIN `pq_submodule` as c
        ON c.pqsmId=a.pqsmId
        
        JOIN `pq_module` as d
        ON c.pqmId=d.pqmId
        
        JOIN `pq_main` as f
        
         ON f.pqmainId=d.pqmainId 
        
        JOIN  `p_answers`as b  
        ON a.`pqId`=b.`pqId`
         WHERE a.`isAvail` =2
            AND b.`isAvail` =2
            AND d.`isAvail` IN (0,1)
            AND c.`isAvail` IN (0,1)
            AND f.`isAvail`=0
            ORDER BY b.pqId DESC;");
        return view('previous_question/draftPQshow',compact('module_view','question'));
    }

    function draftPquestionTake()
    {
        $pqId=request()->get('pqId');
        $allQuestions=
            // (DB::select("SELECT a.* , (SELECT `pqmId` FROM `pq_submodule` WHERE `pqsmId`=(a.pqsmId)) as pqmId,
            //  (SELECT `pqmName` FROM `pq_module` WHERE `pqmId`=(SELECT `pqmId` FROM `pq_submodule`WHERE `pqsmId`=(a.pqsmId)))as pqmName, 
            //  (SELECT `pqsmName` FROM `pq_submodule` WHERE `pqsmId`=(a.pqsmId))as pqsmName,
            //   b.`optionA` as ansA,b.`optionB` as ansB,b.`optionC` as ansC,b.`optionD` as ansD FROM `p_questions` 
            //   as a JOIN `p_answers` as b on a.`pqId`=`b`.`pqId` where a.`pqId`=$pqId;"));
              (DB::select("SELECT t1.*, t2.*, t3.*, t4.*, b.`optionA` as ansA, b.`optionB` as ansB, b.`optionC` as ansC, b.`optionD` as ansD
              FROM `p_questions` t4
              INNER JOIN `pq_submodule` t3 ON t4.pqsmId = t3.pqsmId
              INNER JOIN `pq_module` t2 ON t3.pqmId = t2.pqmId
              INNER JOIN `pq_main` t1 ON t2.pqmainId = t1.pqmainId
              INNER JOIN `p_answers` b ON t4.`pqId` = b.`pqId`
              WHERE t4.`pqId` =$pqId;"));
        return $allQuestions;
    }

    // function PmoduleShow(){
    //     $pqmodule= DB::select("SELECT * from `pq_module`");
    //     return $pqmodule;
    // }
    public function draftdeletePQuestion($questionId)
    {
        PQuestionModel::where('pqId',$questionId)->delete();
        PQAnswerModel::where('pqId',$questionId)->delete();
        return redirect("/draftPQA")->with('success','Question Deleted');
    }


    public function draftPquestionUpdate(Request $request)
    {
        $pqId = request('pqId');

        $smIdfrominput = request('pqsmId');
        $smIdfromdropdown = request('showsubmoduledropdown');
        if($smIdfromdropdown==""){
            $pqsmId=$smIdfrominput;//NO DROPDOWN SELECTED
        }else{
            $pqsmId=$smIdfromdropdown;//SUBCATEGORY CHANGED
        }

        $question = request('question');
        $option1 = request('option1');
        $option2 = request('option2');
        $option3 = request('option3');
        $option4 = request('option4');
        $answer = request('answer');

        $updated_by = request('user_id');                  /////////////from SESSION VALUE
        $updated_at= $this->currentDateTime;   /////////////from date
        $isAvail=2;

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

        $pqmodule = PQuestionModel::find($pqId);
        //print_r($pqId);die;

        $pqmodule->update([
            'pqsmId' =>  $pqsmId,
            'question'=>$question,
            'optionA'=> $option1,
            'optionB'=> $option2,
            'optionC'=> $option3,
            'optionD'=> $option4,
            'isAvail'=> $isAvail,
            'updated_at'=>$updated_at,
            'updated_by'=>$updated_by]);
        //UPDATE ANSWER TO ANSWERS TABLE
        DB::update("UPDATE `p_answers` SET `optionA`=$value1,`optionB`=$value2,`optionC`=$value3,`optionD`=$value4,`isAvail`=$isAvail,`updated_by`=$updated_by WHERE `pqId`=$pqId");

        return redirect("/draftPQA")->with('success','Question Updated');
    }
   
    function draftCategoryshow(){
        $pqmainId=request()->get('pqmainId');
       // $category=  CategoryModel::select()->where('pqmainId',$pqmainId)->where('isAvail','0')->get();
       
        $category=  CategoryModel::select()->where('pqmainId',$pqmainId)->get();
        return $category;
    }

    function draftsubCategoryshow()
    {
        $pqmId=request()->get('pqmId');
       // $subcategory = SubCategoryModel::select()->where('pqmId',$pqmId)->where('isAvail','0')->get();
        $subcategory = SubCategoryModel::select()->where('pqmId',$pqmId)->get();
        return $subcategory;
    }
    function draftExamTypeshow(){
        $category= DB::select("SELECT * from `pq_main` WHERE `isAvail`='0'");
        return $category;
    }
    function draftupdatePreviousQuestionForm()
    {
        $pqId=request('pqId');
        // $allQuestions=(DB::select("SELECT a.* , (SELECT `pqmId` FROM `pq_submodule` WHERE `pqsmId`=(a.pqsmId)) as pqmId,
        //  (SELECT `pqmName` FROM `pq_module` WHERE `pqmId`=(SELECT `pqmId` FROM `pq_submodule`WHERE `pqsmId`=(a.pqsmId)))as pqmName,
        //   (SELECT `pqsmName` FROM `pq_submodule` WHERE `pqsmId`=(a.pqsmId))as pqsmName, b.`optionA` as ansA,b.`optionB` as ansB,b.`optionC` as ansC,b.`optionD` as ansD FROM `p_questions`
        //    as a JOIN `p_answers`
        //  as b on a.`pqId`=`b`.`pqId` where a.`pqId`=$pqId;"));
         $allQuestions=(DB::select("SELECT t1.*, t2.*, t3.*, t4.*, b.`optionA` as ansA, b.`optionB` as ansB, b.`optionC` as ansC, b.`optionD` as ansD
         FROM `p_questions` t4
         INNER JOIN `pq_submodule` t3 ON t4.pqsmId = t3.pqsmId
         INNER JOIN `pq_module` t2 ON t3.pqmId = t2.pqmId
         INNER JOIN `pq_main` t1 ON t2.pqmainId = t1.pqmainId
         INNER JOIN `p_answers` b ON t4.`pqId` = b.`pqId`
         WHERE t4.`pqId` =$pqId;"));
        return view('previous_question/draftPQedit',compact('allQuestions'));
    }


    /// APPROVING
    public function PQapproving($questionId)
    {
      
        $question = PQuestionModel::find($questionId);
        $answer = PQAnswerModel::find($questionId);
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
    public function PQrefusing($questionId)
    {
      
        $question = PQuestionModel::find($questionId);
        $answer = PQAnswerModel::find($questionId);
        
        $question->update(['isAvail' => 2]);
        $answer->update(['isAvail' => 2]);
  
  
        return redirect()->back()->with('success','Question Refused');
          
  
    }
    
    
    
    
    
    
    
    
    
     //search module wise previous question subcategory show
     public function searchexamyearbasesubcategoryshow(Request $request)
     {
         $searchmainValue = $request->input('selvalueexamtype');
         $searchmoduleValue = $request->input('selvaluemodule');
     
         $users = DB::select("SELECT A.pqmId, A.pqmainId, A.pqmName, B.pqsmId, B.pqmId, B.pqsmName, B.isAvail, C.pqmainId, C.pqmainName
         FROM pq_module AS A
         INNER JOIN pq_submodule AS B ON A.pqmId = B.pqmId
         INNER JOIN pq_main AS C ON C.pqmainId = A.pqmainId
         WHERE C.pqmainId = '$searchmainValue' AND B.pqmId = '$searchmoduleValue'
         ORDER BY B.isAvail ASC;
         ");
     
         $output = [];
         $i = 1;
     
         foreach ($users as $item) {
             $output[] = [
                 'slNo' => $i++,
                 'isAvail' => ($item->isAvail == 0) ? 'green' : 'red',
                 'pqmainName' => wordwrap($item->pqmainName, 20, "\n", true),
                 'pqmName' => $item->pqmName,
                 'pqsmName' => wordwrap($item->pqsmName, 20, "\n", true),
                 'editUrl' => url('updateSubCategory'.$item->pqsmId),
                 'deactivateUrl' => ($item->isAvail == 0) ? url('subCategoryDisable/'.$item->pqsmId) : '',
                 'activateUrl' => ($item->isAvail == 1) ? url('subCategoryEnable/'.$item->pqsmId) : '',
                 'deleteUrl' => url('subCategoryDelete/'.$item->pqsmId),
             ];
         }
     
         return response()->json($output);
     }
    
    
    
 //search exam type  wise subcategory show
     public function searchmainexmsubcategory(Request $request)
     {
         $searchmainValue = $request->input('selvalueexamtype');
     
         $users = DB::select("SELECT A.pqmId, A.pqmainId, A.pqmName, B.pqsmId, B.pqmId, B.pqsmName, B.isAvail, C.pqmainId, C.pqmainName
         FROM pq_module AS A
         INNER JOIN pq_submodule AS B ON A.pqmId = B.pqmId
         INNER JOIN pq_main AS C ON C.pqmainId = A.pqmainId
         WHERE C.pqmainId = '$searchmainValue' 
         ORDER BY B.isAvail ASC;
         ");
     
         $output = [];
         $i = 1;
     
         foreach ($users as $item) {
             $output[] = [
                 'slNo' => $i++,
                 'isAvail' => ($item->isAvail == 0) ? 'green' : 'red',
                 'pqmainName' => wordwrap($item->pqmainName, 20, "\n", true),
                 'pqmName' => $item->pqmName,
                 'pqsmName' => wordwrap($item->pqsmName, 20, "\n", true),
                 'editUrl' => url('updateSubCategory'.$item->pqsmId),
                 'deactivateUrl' => ($item->isAvail == 0) ? url('subCategoryDisable/'.$item->pqsmId) : '',
                 'activateUrl' => ($item->isAvail == 1) ? url('subCategoryEnable/'.$item->pqsmId) : '',
                 'deleteUrl' => url('subCategoryDelete/'.$item->pqsmId),
             ];
         }
     
         return response()->json($output);
     }




     //search exam type  wise category show
      public function searchexmtypecategory(Request $request)
      {
          $searchcategoryValue = $request->input('selvalue');
      
          $users = DB::select("SELECT A.pqmainId,A.pqmainName,B.pqmId,B.pqmName,B.isAvail
           FROM pq_main AS A 
           INNER JOIN pq_module as B ON A.pqmainId=B.pqmainId 
           WHERE B.pqmainId = '$searchcategoryValue'
           ORDER BY B.isAvail ASC;");
      
          $output = [];
          $i = 1;
      
          foreach ($users as $item) {
              $output[] = [
                  'slNo' => $i++,
                  'isAvail' => ($item->isAvail == 0) ? 'green' : 'red',
                  'pqmainName' => wordwrap($item->pqmainName, 20, "\n", true),     
                  'pqmName' => wordwrap($item->pqmName, 20, "\n", true),
                  'editUrl' => url('updateCategory'.$item->pqmId),
                  'deactivateUrl' => ($item->isAvail == 0) ? url('CategoryDisable/'.$item->pqmId) : '',
                  'activateUrl' => ($item->isAvail == 1) ? url('CategoryEnable/'.$item->pqmId) : '',
                  'deleteUrl' => url('categoryDelete/'.$item->pqmId),
              ];
          }
      
          return response()->json($output);
      }











    
          // PREVIOUS QUESTION SUBMODULE WISE RETRIVING
    
    
        public function PquestionsupadminSubMUpdate(Request $request)
        {
            $pqId = request('pqId');
            $pqmId = request('pqmId');
            $pqmainId = request('pqmainId');
    
            $smIdfrominput = request('pqsmId');
            $smIdfromdropdown = request('showsubmoduledropdown');
            if($smIdfromdropdown==""){
                $pqsmId=$smIdfrominput;//NO DROPDOWN SELECTED
            }else{
                $pqsmId=$smIdfromdropdown;//SUBCATEGORY CHANGED
            }
    
            $question = request('question');
            $option1 = request('option1');
            $option2 = request('option2');
            $option3 = request('option3');
            $option4 = request('option4');
            $answer = request('answer');
    
            $updated_by = request('user_id');  
            /////////////from SESSION VALUE
            $updated_at= $this->currentDateTime;   
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
    
            $pqmodule = PQuestionModel::find($pqId);
            //print_r($pqId);die;
    
            $pqmodule->update([
                'pqsmId' =>  $pqsmId,
                'question'=>$question,
                'optionA'=> $option1,
                'optionB'=> $option2,
                'optionC'=> $option3,
                'optionD'=> $option4,
                'isAvail'=> $isAvail,
                'updated_at'=>$updated_at,
                'updated_by'=>$updated_by]);
            //UPDATE ANSWER TO ANSWERS TABLE
            DB::update("UPDATE `p_answers` SET `optionA`=$value1,`optionB`=$value2,`optionC`=$value3,`optionD`=$value4,`isAvail`=$isAvail,`updated_by`=$updated_by WHERE `pqId`=$pqId");
    
           // return redirect("/showPQAsubm")->with('success','Question Updated');
            return redirect("/showpqfilter")->with([
                'success' => 'Question Updated',
                'pqmainid' =>$pqmainId,
                'pqmid' => $pqmId,
                'pqsmid' =>$pqsmId
            ]); 
        }
       
        function pqsmsupadminCategoryshow(){
            $pqmainId=request()->get('pqmainId');
            $category=  CategoryModel::select()->where('pqmainId',$pqmainId)->where('isAvail','0')->get();
            return $category;
        }
    
        function pqsmsupadminSubCategoryshow()
        {
            $pqmId=request()->get('pqmId');
            $subcategory = SubCategoryModel::select()->where('pqmId',$pqmId)->where('isAvail','0')->get();
            return $subcategory;
        }
        function pqsmsupadminExamTypeshow(){
            $category= DB::select("SELECT * from `pq_main` WHERE `isAvail`='0'");
            return $category;
        }
        function showpqfilteradminSuper()
        {
           // dd("hai");
           
            $select3 =pqmainModel::select('pqmainId','pqmainName')->where('isAvail','=','0')->get();
            $categoryView = CategoryModel::select()->orderBy('isAvail', 'ASC')->where('isAvail','0')->get();
               
            return view('admin/view_pqsm_question',compact('select3','categoryView'));
            
        }
    
    
        
    
        public function deletePQsupadminsubmoduleview($questionId)
        {
            PQuestionModel::where('pqId',$questionId)->delete();
            PQAnswerModel::where('pqId',$questionId)->delete();
           // return redirect("/showPQAsubmauthur")->with('success','Question Deleted');
            return redirect()->back()->with('success','Question Deleted');
        }
    
        function updatesubPreviousadminQuestionForm($pqId)
        {
            //print_r('hai');die;
           // dd('hai');
            $pqId=request('pqId');
           
             $allQuestions=(DB::select("SELECT t1.*, t2.*, t3.*, t4.*, b.`optionA` as ansA, b.`optionB` as ansB, b.`optionC` as ansC, b.`optionD` as ansD
             FROM `p_questions` t4
             INNER JOIN `pq_submodule` t3 ON t4.pqsmId = t3.pqsmId
             INNER JOIN `pq_module` t2 ON t3.pqmId = t2.pqmId
             INNER JOIN `pq_main` t1 ON t2.pqmainId = t1.pqmainId
             INNER JOIN `p_answers` b ON t4.`pqId` = b.`pqId`
             WHERE t4.`pqId` =$pqId;"));
            return view('admin/edit_pqsm_question',compact('allQuestions'));
        }
    
    
    
    
    // // just checking -- sub--quest
    
    function subcategorypqshowadminsuper(Request $request)
    {
        $smodule = request('smodule');
        $smodule2 = $request->input('smodule');
       
       // dd($smodule);
        $question = DB::select("
            SELECT t1.*, t2.*, t3.*, t4.*, b.`optionA` as ansA, b.`optionB` as ansB, b.`optionC` as ansC, b.`optionD` as ansD
            FROM `p_questions` t4
            INNER JOIN `pq_submodule` t3 ON t4.pqsmId = t3.pqsmId
            INNER JOIN `pq_module` t2 ON t3.pqmId = t2.pqmId
            INNER JOIN `pq_main` t1 ON t2.pqmainId = t1.pqmainId
            INNER JOIN `p_answers` b ON t4.`pqId` = b.`pqId`
            WHERE t4.`pqsmId` = $smodule
            AND t4.`isAvail`=0 AND b.`isAvail`=0 ;
        ");
       
      //  dd($question);
        return view('admin/view_pqsm_draftquest',compact('question', 'smodule2'));
    }


   // filter excep pq download
    public function excelgetFilteredpreviousexamdwnld(Request $request){
        $smId = request('smId');
        $data=DB::select("SELECT 
        t1.pqmainName,
        t2.pqmName,
        t3.pqsmName,
        t4.question,
        t4.`optionA` as optionA,
        t4.`optionB` as optionB,
        t4.`optionC` as optionC,
        t4.`optionD` as optionD,
        CASE
         WHEN b.optionA = 1 THEN t4.optionA 
         WHEN b.optionB = 1 THEN t4.optionB
         WHEN b.optionB = 1 THEN t4.optionC 
         WHEN b.optionD = 1 THEN t4.optionD
        END AS answer
        
                   FROM `p_questions` t4
                    JOIN `pq_submodule` t3 ON t4.pqsmId = t3.pqsmId
                    JOIN `pq_module` t2 ON t3.pqmId = t2.pqmId
                    JOIN `pq_main` t1 ON t2.pqmainId = t1.pqmainId
                    JOIN `p_answers` b ON t4.`pqId` = b.`pqId`
                   WHERE t4.`pqsmId` = '$smId'
                   AND t4.`isAvail`=0 AND b.`isAvail`=0;");
        return $data;
    }






     


      // SUPER ADMIN DRAFT AND APPROVING PREVIOUS QUESTION SUBMODULE WISE RETRIVING------------------------------------------------


      public function PquestionsadminSubMUpdate(Request $request)
      {
          $pqId = request('pqId');
          $pqmId = request('pqmId');
          $pqmainId = request('pqmainId');
  
          $smIdfrominput = request('pqsmId');
          $smIdfromdropdown = request('showsubmoduledropdown');
          if($smIdfromdropdown==""){
              $pqsmId=$smIdfrominput;//NO DROPDOWN SELECTED
          }else{
              $pqsmId=$smIdfromdropdown;//SUBCATEGORY CHANGED
          }
  
          $question = request('question');
          $option1 = request('option1');
          $option2 = request('option2');
          $option3 = request('option3');
          $option4 = request('option4');
          $answer = request('answer');
  
          $updated_by = request('user_id');                  
          /////////////from SESSION VALUE
          $updated_at= $this->currentDateTime;   
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
  
          $pqmodule = PQuestionModel::find($pqId);
          //print_r($pqId);die;
  
          $pqmodule->update([
              'pqsmId' =>  $pqsmId,
              'question'=>$question,
              'optionA'=> $option1,
              'optionB'=> $option2,
              'optionC'=> $option3,
              'optionD'=> $option4,
              'updated_at'=>$updated_at,
              'updated_by'=>$updated_by]);
          //UPDATE ANSWER TO ANSWERS TABLE
          DB::update("UPDATE `p_answers` SET `optionA`=$value1,`optionB`=$value2,`optionC`=$value3,`optionD`=$value4,`updated_by`=$updated_by WHERE `pqId`=$pqId");
  
         // return redirect("/showPQAsubm")->with('success','Question Updated');
          return redirect("/draftfilterqapqsadmin")->with([
              'success' => 'Question Updated',
              'pqmainid' =>$pqmainId,
              'pqmid' => $pqmId,
              'pqsmid' =>$pqsmId
          ]); 
      }
     
      function pqsmsadminCategoryshow(){
          $pqmainId=request()->get('pqmainId');
          $category=  CategoryModel::select()->where('pqmainId',$pqmainId)->where('isAvail','0')->get();
          return $category;
      }
  
      function pqsmsadminsSubCategoryshow()
      {
          $pqmId=request()->get('pqmId');
          $subcategory = SubCategoryModel::select()->where('pqmId',$pqmId)->where('isAvail','0')->get();
          return $subcategory;
      }
      function pqsmsadminExamTypeshow(){
          $category= DB::select("SELECT * from `pq_main` WHERE `isAvail`='0'");
          return $category;
      }
      function showPQAsmamicasadmin()
      {
         // dd("hai");
         
          $select3 =pqmainModel::select('pqmainId','pqmainName')->where('isAvail','=','0')->get();
         // $categoryView = CategoryModel::select()->orderBy('isAvail', 'ASC')->where('isAvail','0')->get();
          $categoryView = CategoryModel::select()->orderBy('isAvail', 'ASC')->get();
             
          return view('previous_question/view_pqsm_checkform',compact('select3','categoryView'));
          
      }
  
//       function PQAauthorsubmodulecheck()
//       {
//           $pqsmId = request('pqsmId');
         
//           $questions = DB::select("
//               SELECT t1.*, t2.*, t3.*, t4.*, b.`optionA` as ansA, b.`optionB` as ansB, b.`optionC` as ansC, b.`optionD` as ansD
//               FROM `p_questions` t4
//               INNER JOIN `pq_submodule` t3 ON t4.pqsmId = t3.pqsmId
//               INNER JOIN `pq_module` t2 ON t3.pqmId = t2.pqmId
//               INNER JOIN `pq_main` t1 ON t2.pqmainId = t1.pqmainId
//               INNER JOIN `p_answers` b ON t4.`pqId` = b.`pqId`
//               WHERE t4.`pqsmId` = $pqsmId;
//           ");
         
//           return $questions;
//       }
      
  
      public function deletePQsadminsubmoduleview($questionId)
      {
          PQuestionModel::where('pqId',$questionId)->delete();
          PQAnswerModel::where('pqId',$questionId)->delete();
         // return redirect("/showPQAsubmauthur")->with('success','Question Deleted');
          return redirect()->back()->with('success','Question Deleted');
      }
  
      function updatesubPrevioussadminQuestionForm($pqId)
      {
          //print_r('hai');die;
         // dd('hai');
          $pqId=request('pqId');
         
           $allQuestions=(DB::select("SELECT t1.*, t2.*, t3.*, t4.*, b.`optionA` as ansA, b.`optionB` as ansB, b.`optionC` as ansC, b.`optionD` as ansD
           FROM `p_questions` t4
           INNER JOIN `pq_submodule` t3 ON t4.pqsmId = t3.pqsmId
           INNER JOIN `pq_module` t2 ON t3.pqmId = t2.pqmId
           INNER JOIN `pq_main` t1 ON t2.pqmainId = t1.pqmainId
           INNER JOIN `p_answers` b ON t4.`pqId` = b.`pqId`
           WHERE t4.`pqId` =$pqId;"));
          return view('previous_question/edit_pqsm_draftquestions',compact('allQuestions'));
      }
  
  
//       //approve subcategory wise
      public function PQapprovingsubcategorywisesadmin($parameter)
      {
          $pqId = Crypt::decrypt($parameter);
          $question = PQuestionModel::find($pqId);
          $answer = PQAnswerModel::find($pqId);
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
//       public function PQsubcatewiserefusingauthor($parameter)
//       {
//          // dd();
//          $pqId = Crypt::decrypt($parameter);
//           $question = PQuestionModel::find($pqId);
//           $answer = PQAnswerModel::find($pqId);
          
//           $question->update(['isAvail' => 2]);
//           $answer->update(['isAvail' => 2]);
    
    
//           return redirect()->back()->with('success','Question Refused');
            
    
//       }
  
  
  
//   // just checking -- sub--quest
  
  function sadminsubmodulecheckpq(Request $request)
  {
      $smodule = request('smodule');
     
     // dd($smodule);
      $question = DB::select("
          SELECT t1.*, t2.*, t3.*, t4.*, b.`optionA` as ansA, b.`optionB` as ansB, b.`optionC` as ansC, b.`optionD` as ansD
          FROM `p_questions` t4
          INNER JOIN `pq_submodule` t3 ON t4.pqsmId = t3.pqsmId
          INNER JOIN `pq_module` t2 ON t3.pqmId = t2.pqmId
          INNER JOIN `pq_main` t1 ON t2.pqmainId = t1.pqmainId
          INNER JOIN `p_answers` b ON t4.`pqId` = b.`pqId`
          WHERE t4.`pqsmId` = $smodule
          AND t4.`isAvail`=2 AND b.`isAvail`=2 ;
      ");
     
    //  dd($question);
      return view('previous_question/view_pqsm_draftquestions',compact('question'));
  }
  
  
  
  // END--

    // previous question excel downlod here
     // excel previous exam
    public function excelgetpreviousexamdwnld(){
        $data=DB::select("SELECT   f.pqmainName as PmainName,
        d.pqmName as PmoduleName,   
        c.pqsmName as PsubModuleName,
           a.question,
           a.optionA as optionA,
           a.optionB as optionB,
           a.optionC as optionC,
           a.optionD as optionD,
      
        CASE
        WHEN b.optionA = 1 THEN a.optionA
        WHEN b.optionB = 1 THEN a.optionB
        WHEN b.optionC = 1 THEN a.optionC
        WHEN b.optionD = 1 THEN a.optionD
        END AS answer
 
       FROM `p_questions`as a 
        
       JOIN `pq_submodule` as c
       ON c.pqsmId=a.pqsmId
       
       JOIN `pq_module` as d
       ON c.pqmId=d.pqmId
       
       JOIN `pq_main` as f
       
        ON f.pqmainId=d.pqmainId 
       
       JOIN  `p_answers`as b  
       ON a.`pqId`=b.`pqId`
        WHERE a.`isAvail`=0
           AND b.`isAvail`=0 
           AND d.`isAvail` IN (0,1)
           AND c.`isAvail` IN (0,1)
           AND f.`isAvail`=0
           ORDER BY b.pqId DESC;");

           return $data;
    }
    
    
    
    
    // TOP PERFORMERS FUNCTIONS START HERE

    public function showtopperformes(){

        $select3 =pqmainModel::select('pqmainId','pqmainName')->get();
        $categoryView = CategoryModel::select()->orderBy('isAvail', 'ASC')->get();

        return view('top_performers.performers_form',compact('select3','categoryView'));
    }
    
   public function report_of_topstudents(Request $request){

    $pqmainId = request('exam_type');
    $pqmId    = request('exam_year');
    $pqsmId   = request('exam_name');

    $take_top_per_sel_pqsmid = DB::select("SELECT DISTINCT
    anal.aId, udel.name,anal.dateAndTime,anal.totalQuestions,anal.QuestionsAttended,
    anal.rightAns,anal.wrongAns,anal.score,anal.percentage
    FROM `user_analytics` as anal
    JOIN `user_details` as udel on udel.uId = anal.userId
    LEFT JOIN `pq_main` as main on main.pqmainId = anal.examTypeId
    left JOIN `pq_module` as pqm on pqm.pqmainId = anal.examModuleId
    LEFT JOIN `pq_submodule` as sub on sub.pqmId = anal.examSubModuleId
    WHERE anal.courseType = '2' AND anal.percentage >= '75'
    AND anal.examTypeId = '$pqmainId' AND anal.examModuleId='$pqmId'
    AND anal.examSubModuleId='$pqsmId'
    ORDER BY anal.percentage DESC;");

    return $take_top_per_sel_pqsmid;

   }
    
    
    
    
    
    
    
    
    
    
    
}
