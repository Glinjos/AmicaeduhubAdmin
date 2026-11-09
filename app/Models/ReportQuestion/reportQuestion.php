<?php

namespace App\Models\ReportQuestion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class reportQuestion extends Model
{
    use HasFactory;
    protected $table = 'report_question';
    protected $primaryKey='rqId';
    protected $fillable = ['questionId','uId','examMode','reportReason','status','date','created_by','created_at','updated_by','updated_at'
    ];
}
