<?php

namespace App\Models\ExamBankModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dailyexamModel extends Model
{
    protected $table = 'daily_exam';
    protected $primaryKey = 'dId';
    protected $fillable = ['dId','examName','examdate','timeFrom','timeTo','modulesId','noOfQuestions','postiveMark','negativeMark','isExpired','created_by','created_at','updated_by'];
    use HasFactory;
}
