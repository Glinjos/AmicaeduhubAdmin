<?php

namespace App\Models\CrashCourse;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class courseBatchDaysModel extends Model
{
    use HasFactory;
    protected $table = 'course_batch_days';
    protected $primaryKey='cbdId';
    protected $fillable = [
                            'dayName',
                            'Date',
                            'mId',
                            'smId',
                            'cbId',
                            'isActive',
                            'isExam',
                            'created_by',
                            'created_at',
                            'updated_by',
                            'updated_at'
                        ];
                      

}                       
