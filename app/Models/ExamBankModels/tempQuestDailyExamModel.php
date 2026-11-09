<?php

namespace App\Models\ExamBankModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tempQuestDailyExamModel extends Model
{
    protected $table = 'temp_dailyexam_quest';
    protected $primaryKey = 'tdqId';
    protected $fillable = ['tdqId','dId','question','optionA','optionB','optionC','optionD','created_by','created_at','updated_by'];
    use HasFactory;

    public function get_answers(){
        return  $this->hasOne(tempAnsDailyExamModel::class,'tdqId','tdqId');
    }
}
