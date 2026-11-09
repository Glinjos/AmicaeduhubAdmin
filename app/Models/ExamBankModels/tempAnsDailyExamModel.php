<?php

namespace App\Models\ExamBankModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tempAnsDailyExamModel extends Model
{
    protected $table = 'temp_dailyexam_ans';
    protected $primaryKey = 'tdaId';
    protected $fillable = ['tdaId','tdqId','optionA','optionB','optionC','optionD','created_by','created_at','updated_by'];
    use HasFactory;
}
