<?php

namespace App\Models\PreviousExamModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PreviousExamModels\PreviousAnswerModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

use Illuminate\Database\Eloquent\Concerns\HasRelationships;



class PreviousQuestionModel extends Model
{
  
    protected $table = 'p_questions';
    protected $primaryKey='pqId';
    protected $fillable = [ 
    'pqsmId',
    'question',
    'optionA', 
    'optionB',
    'optionC',
    'optionD',
    'created_by',
    'created_at',
    'updated_by',
    'updated_at'
    ];

    public function get_answers(){

        return  $this->hasOne(PreviousAnswerModel::class,'pqId','pqId');
    }
}
