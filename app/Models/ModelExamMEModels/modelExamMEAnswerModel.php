<?php

namespace App\Models\ModelExamMEModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class modelExamMEAnswerModel extends Model
{
    use HasFactory;
    protected $table = 'model_exam_me_answer';
    protected $primaryKey='meqaId';
    protected $fillable = ['meqaId','meqId','optionA','optionB','optionC','optionD','isAvail','created_by','created_at','updated_by','updated_at'];

}
