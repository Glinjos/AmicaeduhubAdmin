<?php

namespace App\Models\ModelExamMEModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class modelExamMEQuestionModel extends Model
{
    use HasFactory;
    protected $table = 'model_exam_me_question';
    protected $primaryKey='meqId';
    protected $fillable = ['meqId','meId','question','optionA','optionB','optionC','optionD','isAvail','created_by','created_at','updated_by','updated_at'];

    public function get_answers(){
        return  $this->hasOne(modelExamMEAnswerModel::class,'meqId','meqId');
    }
}
