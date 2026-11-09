<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ExamDailyModels\dailyexamModel;
use Carbon\Carbon;

class ExecuteExamExpiredQuery extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exam:expired-daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Execute query when current date and time match exam date and time the exam is expired';

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
    
        $examRecords = dailyexamModel::select('dId','examdate','timeTo')->where('examdate', $currentDate)
        ->where('timeTo', $currentTime)
        ->where('isExpired', 1)
        ->get();
        
       // dd($examRecords);

        if ($examRecords->isNotEmpty()) {
            foreach ($examRecords as $record) {
                dailyexamModel::where('dId', $record->dId) // Assuming you have an 'id' column
                    ->update(['isExpired' => 2]);// Expiring THE EXAM 
            }

           // $this->info('Updated ' . $examRecords->count() . ' records: ' . $currentDate . ' ' . $currentTime);
        } else {
           // $this->info('No records to update: ' . $currentDate . ' ' . $currentTime);
        }

       // $this->info('Command completed.');
    }
}
