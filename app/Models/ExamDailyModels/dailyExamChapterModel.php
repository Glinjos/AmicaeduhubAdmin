<?php

namespace App\Models\ExamDailyModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dailyExamChapterModel extends Model
{
    protected $table = 'daily_exam_chapter';
    protected $primaryKey = 'dchapterId';
    protected $fillable = ['dchapterId','dId','examName','examdate','modulesId','chapterId','created_at','updated_at'];
    use HasFactory;
}
