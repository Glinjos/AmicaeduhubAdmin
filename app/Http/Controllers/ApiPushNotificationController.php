<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\userdevicetokenModel;
use GuzzleHttp\Client;
use Google\Client as googleClient;
use GuzzleHttp\Exception\GuzzleException;
use PhpParser\JsonDecoder;
use function Symfony\Component\HttpKernel\DataCollector\getMessage;

class ApiPushNotificationController extends Controller
{
    // used for sending custom notification to devices via firebase fcm 
    public function sendNotifications(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'users' => 'nullable|string',
            'payload' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'responseStatus' =>false,
                'responseCode' => 400,
                'responseMessage' => 'Invalid request data',
                'errors' => $validator->errors()
            ]);
        }

        $title = $request->input('title');
        $body = $request->input('body');
        $usersString = $request->input('users');
        $payloadString = $request->input('payload');

        $users = json_decode($usersString);

        if (filter_var($payloadString, FILTER_VALIDATE_URL) !== false) {
            $payload = ['image_url' => $payloadString];
        }

        $accessToken = $this->getAccessToken();

        $baseTopic = "amicaeduhubUser";
        $projectId = "amicaeduhub-2683a";
        $endpointUrl = "https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send";

        $message = [
            'message' => [
                'data' => [
                    'title' => $title,
                    'body' => $body,
                ],
            ],
        ];
        
        if ($payloadString !== null) {
            $message['message']['data'] = array_merge($message['message']['data'], $payload);
        }

        if ($users !== null) {
            $condition = "'$baseTopic' in topics";
            $userConditions = [];

            foreach ($users as $userId) {
                $userConditions[] = "'amicaeduhubUserId$userId' in topics";
            }

            if (!empty($userConditions)) {
                if (count($userConditions) === 1) {
                    $condition .= " && " . $userConditions[0];
                } else {
                    $condition .= " && (" . implode(' || ', $userConditions) . ")";
                }
            }

            $message['message']['condition'] = $condition;
        } else {
            $message['message']['topic'] = $baseTopic;
        }

        $response = Http::withToken($accessToken)->post($endpointUrl, $message);

        if ($response->successful()) {
            return response()->json([
                'responseStatus' =>true,
                'responseCode' => 200,
                'responseMessage' => 'Push notification sent successfully',
            ]);
        } else {
            return response()->json([
                'responseStatus' =>false,
                'responseCode' => 500,
                'responseMessage' => 'Failed to send push notification',
                'error' => $response->json()
            ]);
        }
    }

    // used for getting fcm access token
    public function getAccessToken()
    {
        // set the path to your service account JSON file
        $credentialsPath = storage_path('google-service-account.json');
        
        // initialize the Google Client
        $client = new googleClient();
        $client->setAuthConfig($credentialsPath);
        $client->addScope('https://www.googleapis.com/auth/firebase.messaging');

        // fetch the access token
        $accessToken = $client->fetchAccessTokenWithAssertion();

        // check for errors
        if (isset($accessToken['error'])) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to obtain access token',
                'error' => $accessToken['error']
            ], 500);
        }

        return $accessToken['access_token'];
    }









        // API WORKING END 
    // STARTING BACKEND WORKS


    // VIEW NOTIFICATION SENT PAGE
    public function viewNotificationForm(){

        return view('pushNotification.notificationPage');

    }



    // STORE DATA

    public function storenotifydata(Request $request){

        // $deviceTokendata = userdevicetokenModel::select('deviceToken')->get();
        // $deviceTokendataCount = count($deviceTokendata);
        // $deviceTokenList = [];

        // for($i = 0; $i< $deviceTokendataCount;$i++){
        //     array_push($deviceTokenList, $deviceTokendata[$i]["deviceToken"]);
        // }
        
        // $tokenString = json_encode($deviceTokenList);

       // print_r($deviceTokendata);die;
        try {

            if(empty( $request->file('notifyImage')))
            {
              //  http://admin.amicaeduhub.com/api/send-notification
              // http://localhost/LARAVEL/AMICA HUB/admin.amicaeduhub.com/api/send-notification
                $client = new Client();
                $url = 'http://admin.amicaeduhub.com/api/send-notification';
               // print_r($tokenString);die;
                $form_params = [
                    'title' => $request['notifyTitle'],
                    'body' => $request['notifyDescription'],
                    // 'tokens'=> $tokenString,
                    
                    ];



            }else{
               // print_r("hai");die;
                $client = new Client();
                $url = 'http://admin.amicaeduhub.com/api/send-notification';

                $form_params = [
                    'title' => $request['notifyTitle'],
                    'body' => $request['notifyDescription'],
                    // 'tokens'=> $tokenString,
                    
                    ];

                    $image = request()->file('notifyImage');
                    $extension = $image->getClientOriginalExtension();
                    $fileName = 'Payload' . time() . '.' . $extension;
                    $image->move(public_path('assets/notify_image'), $fileName);
                 //   $input['notifyImage'] = 'http://admin.amicaeduhub.com/public/assets/notify_image/' . $fileName;

                $form_params['payload'] = 'http://admin.amicaeduhub.com/public/assets/notify_image/' . $fileName;
                
               // print_r($form_params['payload']);die;

              //  $form_params['payload'] ='http://admin.amicaeduhub.com/public/assets/notify_image/' . $fileName,';

               
               

            }


            $response = $client->post($url, ['form_params' => $form_params]);
            if($response)
            {
              
             return redirect('/sent-notification-back')->with('success','Notification Sent.');
            
            }
            else
            {
                return redirect('/sent-notification-back')->with('error','Execution Failed.');
            }
        }
        catch(GuzzleException $g) {
            echo $g;
        }

    }










}
