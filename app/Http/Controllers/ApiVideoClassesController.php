<?php

/**
 * Created by vsCode.
 * Use: API (FLUTTER) Video Class
 * Conducting classes or educational
 * sessions using video format. 
 * User Attendance for Exams: Tracking user
 * participation and attendance for exams.
 */

namespace App\Http\Controllers;

use App\Models\VideoClassesModels\vcchapterModel;
use App\Models\VideoClassesModels\vcexamModel;
use App\Models\VideoClassesModels\vcmoduleModel;
use App\Models\VideoClassesModels\vcmoreVideoModel;
use Illuminate\Http\Request;

class ApiVideoClassesController extends Controller
{

//All model
    public function show_vc_module()
    {
        try {
            $data = vcmoduleModel::select()->where('isAvail',0)->orderby('vcmName','ASC')->get();
            return response()->json([
                'responseMessage' => 'all modules',
                'responseCode' => 200,
                'responseStatus' =>true,
                'data'=>$data,

            ]);

        } catch (\Exception $e) {
            return response()->json([
                'responseMessage' => 'sorry no data found',
                'responseCode' => 401,
                'responseStatus' =>false,
            ]);
        }
    }

//All Chapter
    public function show_vc_chapter()
    {
        $vcmId = request('vcmId');
        if($vcmId==""){
            return response()->json([
                'responseMessage' => 'vcmId is mandatory',
                'responseCode' => 401,
                'responseStatus' =>false,
            ]);
        }else{
            $vc_chapter = vcchapterModel::where('vcmId',$vcmId)->where('isAvail',0)->orderBy('vcChapterName', 'asc')->get();
            $count = $vc_chapter->Count();
            if($count>0){
                return response()->json([
                    'responseMessage' => 'all chapters',
                    'responseCode' => 200,
                    'responseStatus' =>true,
                    'data'=>$vc_chapter,
                ]);
            }else{
                //no data found
                return response()->json([
                    'responseMessage' => 'sorry no data found',
                    'responseCode' => 401,
                    'responseStatus' =>false,
                ]);
            }
        }
    }

//All more videos
    public function show_vc_moreVideo()
    {
        $vcChapterId = request('vcChapterId');
        if($vcChapterId==""){
            return response()->json([
                'responseMessage' => 'vcChapterId is mandatory',
                'responseCode' => 401,
                'responseStatus' =>false,
            ]);
        }else{
            $vc_chapter = vcmoreVideoModel::where('vcChapterId',$vcChapterId)->where('isPublished',0)->orderBy('videoHeading','ASC')->get();
            $count = $vc_chapter->Count();
            if($count>0){
                return response()->json([
                    'responseMessage' => 'all videos',
                    'responseCode' => 200,
                    'responseStatus' =>true,
                    'data'=>$vc_chapter,
                ]);
            }else{
                //no data found
                return response()->json([
                    'responseMessage' => 'sorry no data found',
                    'responseCode' => 401,
                    'responseStatus' =>false,
                ]);
            }
        }
    }


//All Question and Answers
    public function show_vc_examAns(Request $request)
    {
        $method = $request->method();
        if ($method=="POST"){
            $vcVDId = request('vcVDId');
            if($vcVDId==""){
                return response()->json([
                    'responseMessage' => 'vcVDId is mandatory',
                    'responseCode' => 404,
                    'responseStatus' =>false,
                ]);
            }else{
                $questions_with_answers = vcexamModel::with('get_answers')->where('vcVDId',$vcVDId)->where('isAvail',0)->get();
                $count = $questions_with_answers->Count();
                if($count>0){
                    return response()->json([
                        'responseMessage' => 'all questions and answers',
                        'responseCode' => 200,
                        'responseStatus' =>true,
                        'data'=>$questions_with_answers,
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
