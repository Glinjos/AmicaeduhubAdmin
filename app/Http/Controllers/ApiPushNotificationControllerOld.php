<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use App\Models\userdevicetokenModel;
use GuzzleHttp\Client;
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
           'tokens' => 'required',
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

       // $tokens = $request->input('tokens');
       $tokensString = $request->input('tokens');

       // $payload = $request->input('payload');
       $payloadString = $request->input('payload');

       $tokens = json_decode($tokensString);
       // $payload = json_decode($payloadString);
       $payload = $payloadString;

       if ($tokens === null) {
           return response()->json([
               'responseStatus' =>false,
               'responseCode' => 400,
               'responseMessage' => 'Invalid tokens format',
           ]);
       }

       if (filter_var($payload, FILTER_VALIDATE_URL) !== false) {
           $payload = ['image_url' => $payload];
       }

       $serverKey = 'AAAAqqf47Q8:APA91bH0g2hjUW6zzN8DO9xzAPmMI7NMQ9nGUTc8wqxUXlXc4ikGP9S9zmfU8qWWV7D3t3mCDULr7aMRlsEl9OLphh8JTukUTjcuOICFniCoAT4L-WHgKRZRhDC8f78R24C0k6ujx5H0';

       // $message = [
       //     'notification' => [
       //         'title' => $title,
       //         'body' => $body,
       //     ],
       // ];

       $message = [
           'data' => [
               'title' => $title,
               'body' => $body,
           ],
       ];

       // if ($payload !== null) {
       //     $message['data'] = $payload;
       // }
       if ($payload !== null) {
           $message['data'] = array_merge($message['data'], $payload);
       }

       if (count($tokens) > 1) {
           $message['registration_ids'] = $tokens;
       } else {
           $message['to'] = $tokens[0];
       }

       $response = Http::withHeaders([
           'Authorization' => 'key=' . $serverKey,
           'Content-Type' => 'application/json',
       ])->post('https://fcm.googleapis.com/fcm/send', $message);

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









        // API WORKING END 
    // STARTING BACKEND WORKS


    // VIEW NOTIFICATION SENT PAGE
    public function viewNotificationForm(){

        return view('pushNotification.notificationPage');

    }



    // STORE DATA

    public function storenotifydata(Request $request){

        $deviceTokendata = userdevicetokenModel::select('deviceToken')->get();
        $deviceTokendataCount = count($deviceTokendata);
        $deviceTokenList = [];

        for($i = 0; $i< $deviceTokendataCount;$i++){
            array_push($deviceTokenList, $deviceTokendata[$i]["deviceToken"]);
        }
        
        $tokenString = json_encode($deviceTokenList);

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
                    'tokens'=> $tokenString,
                    
                    ];



            }else{
               // print_r("hai");die;
                $client = new Client();
                $url = 'http://admin.amicaeduhub.com/api/send-notification';

                $form_params = [
                    'title' => $request['notifyTitle'],
                    'body' => $request['notifyDescription'],
                    'tokens'=> $tokenString,
                    
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
