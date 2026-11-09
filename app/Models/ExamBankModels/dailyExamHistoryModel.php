<?php

namespace App\Models\ExamBankModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dailyExamHistoryModel extends Model
{
    protected $table = 'daily_exam_history';
    protected $primaryKey = 'historyId';
    protected $fillable = ['historyId','dId','uId','totalMark','rightAns','wrongAns','created_by','created_at','updated_by','updated_at'];
    use HasFactory;
}

