<?php

namespace App\Models\CrashCourse;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class courseSubscribersModel extends Model
{
    use HasFactory;
    protected $table = 'course_subscribers';
    protected $primaryKey='csId';
    protected $fillable = [
                            'cmId',
                            'uId',
                            'transactionNumber',
                            'netPayableAmount',
                            'csDate',
                            'isAddtoBatch',
                            'created_at',
                            'updated_at'
                        ];
                       
}
