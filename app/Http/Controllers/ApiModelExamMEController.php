<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ModelExamMEModels\modelExamMENameModel;
use App\Models\ModelExamMEModels\modelExamMEQuestionModel;


class ApiModelExamMEController extends Controller
{
    //view model exam me names
    public function show_modelExam_name()
    {
        try {
            $data = modelExamMENameModel::select('meId','meName', 'meDescription','positiveMark','negativeMark', 'isAvail')->where('isAvail', 0)->orderBy('meName', 'asc')->get();
            return response()->json([
                'responseMessage' => 'Model exam names',
                'responseCode' => 200,
                'responseStatus' => true,
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'responseMessage' => 'sorry no data found',
                'responseCode' => 401,
                'responseStatus' => false,
            ]);
        }
    }

    //view model exam me questions and answers
    public function show_modelExam_qus_ans(Request $request){
        $method = $request->method();
        if ($method=="POST"){
            $meId = request('meId');
            if($meId==""){
                return response()->json([
                    'responseMessage' => 'please enter meId',
                    'responseCode' => 404,
                    'responseStatus' =>false,
                ]);
            }else{
                $data = modelExamMEQuestionModel::with('get_answers')->where('meId',$meId)->where('isAvail',0)->get();
                $count = $data->Count();
                if($count>0){
                    return response()->json([
                        'responseMessage' => 'all questions and answers',
                        'responseCode' => 200,
                        'responseStatus' =>true,
                        'data'=>$data,
                    ]);
                }else{
                    return response()->json([
                        'responseMessage' => 'NO QUESTIONS',
                        'responseCode' => 404,
                        'responseStatus' =>false,
                    ]);
                }
            }
        }else{
            return response()->json([
                'responseMessage' => 'NO METHOD ACCESS NOT FOUND',
                'responseCode' => 404,
                'responseStatus' =>false,
            ]);
        }
    }
}
