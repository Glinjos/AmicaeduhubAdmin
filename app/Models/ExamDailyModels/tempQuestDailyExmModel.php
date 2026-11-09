<?php

namespace App\Models\ExamDailyModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tempQuestDailyExmModel extends Model
{
    protected $table = 'temp_dailyexam_quest';
    protected $primaryKey = 'tdqId';
    protected $fillable = ['tdqId','dId','question','optionA','optionB',
                            'optionC','optionD',
                            'created_by',
                            'created_at','updated_by','updated_at'];
    use HasFactory;
}
