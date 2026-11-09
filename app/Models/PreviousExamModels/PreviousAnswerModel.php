<?php

namespace App\Models\PreviousExamModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PreviousAnswerModel extends Model
{
    use HasFactory;
    protected $table = 'p_answers';
    protected $primaryKey='paId';
    protected $fillable = [
        'pqId',
        'optionA',
        'optionB', 
        'optionC',
        'optionD',
        'created_by',
        'created_at', 
        'updated_by', 
        'updated_at',
    ];

    // public function getQuestionWithAnswers(){
    //     return $this->belongsTo(PreviousQuestionModel::class,'pqId','paId');
    // }
}
