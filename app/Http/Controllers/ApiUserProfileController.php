<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\user_detail_Model;
use App\Models\CountryDetailsModels\districtModel;

class ApiUserProfileController extends Controller
{
    //

    public function saveUserProfile(Request $request)
    {
        $method = $request->method();
        if ($method == "POST")
        {
            date_default_timezone_set('Asia/Calcutta');
            $dateAndTime = date('Y-m-d H:i:s');

            $email = request('email');
            $address = request('address');
            $gender = request('gender');
            $dob = request('dob');
            $district_Id = request('district_Id');
     //print_r($gender);die;

           //$created_by = request('created_by');
                $uId = request('uId');

        //  if (!empty($email) && !empty($address) && ($gender == 0 || $gender == 1 ||$gender == 2))
        //     {
               
                try {
                    $store_user_profile = user_detail_Model::where('uId','=',$uId)
                    ->update([
                        'userEmail'=>$email,
                        'userAddress'=>$address,
                        'userGender'=>$gender,
                        'dob'=>$dob,
                        'district_Id'=>$district_Id,
                        'updated_by'=>$uId,
                    ]);


                    return response()->json([
                        'responseStatus' =>true,
                        'responseCode' => 200,
                        'responseMessage' => 'Record saved successfully',
                    ]);
                } catch (\Exception $e) {
                    return response()->json([
                        'responseStatus' => false,
                        'responseCode' => 400,
                        'responseMessage' => 'Something went wrong, record not saved',
                    ]);
                }
            // }
            // elseif (!empty($email) && !empty($address))
            // {
            //     try {
            //         $store_user_profile = user_detail_Model::find($uId);
            //         $store_user_profile->update([
            //             'userEmail'=>$email,
            //             'userAddress'=>$address,
            //             'updated_by'=>$uId,
            //         ]);


            //         return response()->json([
            //             'responseStatus' =>true,
            //             'responseCode' => 200,
            //             'responseMessage' => 'email & address saved successfully',
            //         ]);
            //     } catch (\Exception $e) {
            //         return response()->json([
            //             'responseStatus' => false,
            //             'responseCode' => 400,
            //             'responseMessage' => 'Something went wrong, email & address not saved',
            //         ]);
            //     }
            // }
            // elseif (!empty($email))
            // {
            //     try {
            //         $store_user_profile = user_detail_Model::find($uId);
            //         $store_user_profile->update([
            //             'userEmail'=>$email,
            //             'updated_by'=>$uId,
            //         ]);


            //         return response()->json([
            //             'responseStatus' =>true,
            //             'responseCode' => 200,
            //             'responseMessage' => 'email saved successfully',
            //         ]);
            //     } catch (\Exception $e) {
            //         return response()->json([
            //             'responseStatus' => false,
            //             'responseCode' => 400,
            //             'responseMessage' => 'Something went wrong, email not saved',
            //         ]);
            //     }
            // }

        }
        else
        {
            return response()->json([
                'responseStatus' =>false,
                'responseCode' => 404,
                'responseMessage' => 'INCORRECT METHOD, ACCESS DENIED',
            ]);
        }
    }


    public function saveProfilePhoto(Request $request)
    {
        $method = $request->method();
        if ($method == "POST")
        {
            date_default_timezone_set('Asia/Calcutta');
            $dateAndTime = date('Y-m-d H:i:s');


            //$image = request('image');

            //$created_by = request('created_by');
            $updated_by = request('updated_by');
          //  if(request()->hasFile('image')){
                $image = request()->file('image');
           // print_r($image);
                $extension = $image->getClientOriginalExtension();
                $fileName = $updated_by  . '.' . $extension;
                $image->move(public_path('assets/userImage'), $fileName);
                $input['image'] = 'assets/userImage/' . $fileName;

           // }


            try {
                $store_user_profile = user_detail_Model::find($updated_by);
                $store_user_profile->update([
                    'userImage'=>$fileName,
                    'updated_by'=>$updated_by,

                ]);


                return response()->json([
                    'responseStatus' =>true,
                    'responseCode' => 200,
                    'responseMessage' => 'Record saved successfully',
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'responseStatus' => false,
                    'responseCode' => 400,
                    'responseMessage' => 'Something went wrong, record not saved',
                ]);
            }


        }
        else
        {
            return response()->json([
                'responseStatus' =>false,
                'responseCode' => 404,
                'responseMessage' => 'INCORRECT METHOD, ACCESS DENIED',
            ]);
        }
    }

    public function getProfileDetails(Request $request)
    {
        $method = $request->method();
        if ($method == "POST")
        {
            date_default_timezone_set('Asia/Calcutta');
            $dateAndTime = date('Y-m-d H:i:s');

           // $image = request('image');



            //$created_by = request('created_by');
            $uId = request('uId');
            
            if($uId==""){

                return response()->json([
                    'responseMessage' => 'please enter uId',
                    'responseCode' => 401,
                    'responseStatus' =>false,
                    
                ]); 
            }

            try {
                $userDetails = user_detail_Model::select('uId','name','mobile','otp','userImage','userEmail','dob','district_Id','planId','userGender','userAddress','onlinetoken','created_by','created_at','updated_by','updated_at')->where('uId',$uId)->first();




                return response()->json([
                    'responseStatus' =>true,
                    'responseCode' => 200,
                    'responseMessage' => 'Record fetched successfully',
                    'data' => $userDetails
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'responseStatus' => false,
                    'responseCode' => 400,
                    'responseMessage' => 'No record found'
                ]);
            }


        }
        else
        {
            return response()->json([
                'responseStatus' =>false,
                'responseCode' => 404,
                'responseMessage' => 'INCORRECT METHOD, ACCESS DENIED',
            ]);
        }
    }


/// SARATH API START HERE------------------------------


public function showDistricts() 
{
    try {
        $data = districtModel::select('district_Id','district_name','state_Id')->where('state_id',1)->get();
        return response()->json([
            'responseStatus' => true,
            'responseCode' => 200,
            'responseMessage' => 'All districts',
            'districtData' => $data
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'responseStatus' =>false,
            'responseCode' => 401,
            'responseMessage' => 'sorry, something went wrong'+$e,
        ]);
    }
}

public function storeDistrictsToProfile(Request $request)
{
    $userId = request('userId');
    if($userId =="")
    {
        return response()->json([
            'responseStatus' =>false,
            'responseCode' => 404,
            'responseMessage' => 'userId is mandatory',
        ]);
    }
    else
    {
        $districtId = request('districtId');
        if($districtId =="")
        {
            return response()->json([
                'responseStatus' =>false,
                'responseCode' => 404,
                'responseMessage' => 'districtId is mandatory',
            ]);
        }
        else
        {
            try {
                $updateDistrict = user_detail_Model::where('uId',$userId)->update([
                    'district_Id'=>$districtId
                    ]);
        
                return response()->json([
                    'responseStatus' => true,
                    'responseCode' => 200,
                    'responseMessage' => 'district data is updated',
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'responseStatus' =>false,
                    'responseCode' => 401,
                    'responseMessage' => 'sorry, something went wrong',
                ]);
            }
        }
    }
}

public function storeDOB()
{
    $userId = request('userId');
    if($userId =="")
    {
        return response()->json([
            'responseStatus' =>false,
            'responseCode' => 404,
            'responseMessage' => 'userId is mandatory',
        ]);
    }
    else
    {
        $dob = request('dob');
        if($dob =="")
        {
            return response()->json([
                'responseStatus' =>false,
                'responseCode' => 404,
                'responseMessage' => 'dob is mandatory',
            ]);
        }
        else
        {
            try {
                $updateDOB = user_detail_Model::where('uId',$userId)->update([
                    'dob'=>$dob
                    ]);
        
                return response()->json([
                    'responseStatus' => true,
                    'responseCode' => 200,
                    'responseMessage' => 'dob is updated',
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'responseStatus' =>false,
                    'responseCode' => 401,
                    'responseMessage' => 'sorry, something went wrong',
                ]);
            }
        }
    }
}


//update nme
    public function updateName(){

        $name=request('name');
        if ($name == "") {
            return response()->json([
                'responseMessage' => 'name is mandatory',
                'responseCode' => 401,
                'responseStatus' => false,
            ]);
        }
        $uId = request('uId');
        if ($uId == "") {
            return response()->json([
                'responseMessage' => 'uId is mandatory',
                'responseCode' => 401,
                'responseStatus' => false,
            ]);
        }
        else{
            try {
                $updateName = user_detail_Model::where('uId','=',$uId)
                    ->update([
                        'name'=>$name,
                    ]);
                return response()->json([
                    'responseStatus' =>true,
                    'responseCode' => 200,
                    'responseMessage' => 'Record saved successfully',
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'responseStatus' => false,
                    'responseCode' => 400,
                    'responseMessage' => 'Something went wrong, record not saved',
                ]);
            }
        }
    }



}
