<?php

namespace App\Models\PreviousQuestionModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PQAnswerModel extends Model
{
    use HasFactory;
    protected $table = 'p_answers';
    protected $primaryKey = 'paId';
    protected $hidden = 'paId';
    protected $fillable = ['paId', 'pqId', 'optionA', 'optionB', 'optionC', 'optionD','isAvail', 'created_by', 'created_at', 'updated_by', 'updated_at'];

}
