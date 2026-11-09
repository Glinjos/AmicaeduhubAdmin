<?php

namespace App\Http\Controllers;

use App\Models\ReportQuestion\reportQuestion;
use Illuminate\Http\Request;

class ApiReportQuestionController extends Controller
{
    public function report_question()
    {
        $questionId=request('questionId');
        if ($questionId== "") {
            return response()->json([
                'responseMessage' => 'questionId is mandatory',
                'responseCode' => 401,
                'responseStatus' => false,
            ]);
        }
        else{
            $uId=request('uId');
            if ($uId== "") {
                return response()->json([
                    'responseMessage' => 'uId is mandatory',
                    'responseCode' => 401,
                    'responseStatus' => false,
                ]);
            }
            else{
                
                
                $examMode=request('examMode');
                if ($examMode== "") {
                    return response()->json([
                        'responseMessage' => 'examMode is mandatory',
                        'responseCode' => 401,
                        'responseStatus' => false,
                    ]);
                }
                else{
                    $reportReason=request('reportReason');
                    if ($reportReason== "") {
                        return response()->json([
                            'responseMessage' => 'reportReason is mandatory',
                            'responseCode' => 401,
                            'responseStatus' => false,
                        ]);
                    }
                    else{
                        $date=request('date');
                        if ($date== "") {
                            return response()->json([
                                'responseMessage' => 'date is mandatory',
                                'responseCode' => 401,
                                'responseStatus' => false,
                            ]);
                        }
                        else{
                            $created_by=request('created_by');
                            if ($created_by== "") {
                                return response()->json([
                                    'responseMessage' => 'created_by is mandatory',
                                    'responseCode' => 401,
                                    'responseStatus' => false,
                                ]);
                            }
                            else{
                                
                                
                                $sameQuestionUIDrepeat=reportQuestion::where('questionId',$questionId)
                                ->where('uId',$uId)->value('rqId');

                                if($sameQuestionUIDrepeat){
                                    return response()->json([
                                        'responseMessage' => 'You reported that the same question already exists.',
                                        'responseCode' => 401,
                                        'responseStatus' => false,
                                    ]);
                                }else{
                                
                                
                                
                                $data = new reportQuestion;
                                $data->questionId=$questionId;
                                $data->uId=$uId;
                                $data->examMode=$examMode;
                                $data->reportReason=$reportReason;
                                $data->date=$date;
                                $data->created_by=$created_by;
                                $data->save();
                                if($data){
                                    return response()->json([
                                        'responseMessage' => 'Question reported',
                                        'responseCode' => 200,
                                        'responseStatus' => true,
                                    ]);
                                }
                                else{
                                    return response()->json([
                                        'responseMessage' => 'Question not reported',
                                        'responseCode' => 401,
                                        'responseStatus' => false,
                                    ]);
                                }
                                
                                }//already question same user
                                

                            }//createdby

                        }//date
                    }//reasone
                }//exam mode
            }
        }

    }
}
