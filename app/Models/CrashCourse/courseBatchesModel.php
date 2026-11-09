<?php

namespace App\Models\CrashCourse;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class courseBatchesModel extends Model
{
    use HasFactory;
    protected $table = 'course_batches';
    protected $primaryKey='cbId';
    protected $fillable = [
                            'cmId',
                            'cbatchName',
                            'cbatchStartDate',
                            'cbatchEndDate',
                            'cbatchDays',
                            'isClosed',
                            'created_by',
                            'created_at',
                            'updated_by',
                            'updated_at'
                        ];
                     
}
