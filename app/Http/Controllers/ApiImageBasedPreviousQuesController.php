<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ImagePQAModel\imagePquestionModel;


class ApiImageBasedPreviousQuesController extends Controller
{
    //view image based question and answers
    public function show_image_previous_que_ans(Request $request){
        $method = $request->method();
                if ($method=="POST"){
                $pqsmId = request('pqsmId');
                    if($pqsmId==""){
                        return response()->json([
                            'responseMessage' => 'please enter pqsmId',
                            'responseCode' => 404,
                            'responseStatus' =>false,  
                            ]);
                    }else{
                    $image_pqa = imagePquestionModel::with('get_answers')->where('pqsmId',$pqsmId)->where('isAvail',0)->get();
                                $count = $image_pqa->Count();
                                    if($count>0){
                                        return response()->json([
                                                    'responseMessage' => 'all questions and answers',
                                                    'responseCode' => 200,
                                                    'responseStatus' =>true,
                                                    'data'=>$image_pqa,
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
