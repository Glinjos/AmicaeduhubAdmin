<?php

namespace App\Models\CrashCourse;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class courseBatchStudentModel extends Model
{
    use HasFactory;
    protected $table = 'course_batch_with_students';
    protected $primaryKey='cbwsId';
    protected $fillable = [
                            'cbId',
                            'uId',
                            'isActive',
                            'created_by',
                            'created_at',
                            'updated_by',
                            'updated_at'
                        ];
                      
}
