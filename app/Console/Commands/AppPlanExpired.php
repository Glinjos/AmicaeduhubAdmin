<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\SubscriptionModels\planSubscribersModel;

class AppPlanExpired extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'AppPlan:Expired-daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Users App Plan Expired In The Date Grater Than The End Date';

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
    
      //  $this->info('Command started.');
    
        $appPlanDatas = planSubscribersModel::select('apsId', 'planId', 'uId', 'endDate', 'isExpired')
        ->where('isExpired','=','0')
        ->get();
       // $this->info($appPlanDatas);

        if ($appPlanDatas->isNotEmpty()) {
           
            foreach ($appPlanDatas as $record) {
                
                if ($currentDate > $record->endDate ) {
                    planSubscribersModel::where('apsId', $record->apsId)->update(['isExpired' => 1]);
                   // $this->info('Record updated: ' . $record->apsId);
                } else {
                  //  $this->info('Record not updated: ' . $record->apsId);
                }
                
            }
        } else {
           // $this->info('Command Failed.');
        }
        


    }
}
