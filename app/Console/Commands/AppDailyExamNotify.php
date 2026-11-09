<?php

namespace App\Console\Commands;

use App\Models\SubscriptionModels\planSubscribersModel;
use App\Models\userdevicetokenModel;
use App\Models\ExamDailyModels\dailyexamModel;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use PhpParser\JsonDecoder;
use function Symfony\Component\HttpKernel\DataCollector\getMessage;

use Illuminate\Console\Command;
use Carbon\Carbon;

class AppDailyExamNotify extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dailyExam:app-notify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Daily Exam Notification Sent the App.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        date_default_timezone_set("Asia/Calcutta");
        $currentDateTime = now();
        $currentDate = $currentDateTime->format('Y-m-d');
        $currentTime = $currentDateTime->format('H:i');
    
       // $this->info('Command started.');
        $examRecord_today = dailyexamModel::select('examName','examdate','timeFrom','timeTo')
        ->where('examdate', $currentDate)
        ->where('timeFrom', $currentTime)
        ->whereIn('isExpired', [0, 1])
        ->get();

    if($examRecord_today->isNotEmpty())
    {

       $examName_today = [];
       $examDate_today = [];
       $timeFrom_today = [];
       $timeTo_today   = []; 
       
       foreach ($examRecord_today as $rec_today) {
           $examName_today[] = $rec_today->examName;
           $examDate_today[] = $rec_today->examdate;
           $timeFrom_today[] = $rec_today->timeFrom;
           $timeTo_today[]   = $rec_today->timeTo;
       }
       
       // Convert arrays to strings
       $examNameString = implode(', ', $examName_today);
       $examDateString = implode(', ', $examDate_today);
       $timeFromString = implode(', ', $timeFrom_today);
       $timeToString   = implode(', ', $timeTo_today);
       
        
      
// NOTIFICATION START
    $subscribers = planSubscribersModel::select('uId')
    ->where('isExpired', 0)
    ->orderBy('created_at', 'desc')
    ->get();

    $subscribers_id = []; 

    foreach ($subscribers as $subscriber) {
         $subscribers_id[] =$subscriber->uId;
    }


    $deviceTokendata = userdevicetokenModel::select('deviceToken')->whereIn('uId',$subscribers_id)->get();
   // print_r($deviceTokendata);die;
    $deviceTokendataCount = count($deviceTokendata);
    $deviceTokenList = [];

    for($i = 0; $i< $deviceTokendataCount;$i++){
        array_push($deviceTokenList, $deviceTokendata[$i]["deviceToken"]);
    }
    
    $tokenString = json_encode($deviceTokenList);

   // print_r($deviceTokendata);die;
    try {

       
            $client = new Client();
            $url = 'http://admin.amicaeduhub.com/api/send-notification';
           // print_r($tokenString);die;
            $form_params = [
                'title' => $examNameString,
                'body' =>  "Date Of Exam " . $examDateString  . " Starts At " . $timeFromString  . " And Ends At  " . $timeToString,
                'tokens'=> $tokenString,
                ];

        $response = $client->post($url, ['form_params' => $form_params]);
       
    }
    catch(GuzzleException $g) {
        echo $g;
    }
    }else{

    }
    // END NOTIFICATION

       // $this->info('Command completed.');
    }
}
