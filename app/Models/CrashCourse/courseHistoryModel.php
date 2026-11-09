<?php

namespace App\Models\CrashCourse;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class courseHistoryModel extends Model
{
    use HasFactory;
    protected $table = 'course_history';
    protected $primaryKey='chId';
    protected $fillable = [
                            'dateAndTime',
                            'cbId',
                            'cbdId',
                            'mId',
                            'smId',
                            'uId',
                            'totalQuestions',
                            'QuestionsAttended',
                            'rightAns',
                            'wrongAns',
                            'score',
                            'percentage',
                            'created_at',
                            'updated_at'
                        ];
}
