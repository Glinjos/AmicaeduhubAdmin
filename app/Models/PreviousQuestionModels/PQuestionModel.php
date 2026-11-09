<?php

namespace App\Models\PreviousQuestionModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PQuestionModel extends Model
{
    protected $table = 'p_questions';
    protected $primaryKey = 'pqId';
    protected $hidden = 'pqId';
    protected $fillable = [
        'pqId', 'pqsmId', 'question', 'optionA', 'optionB', 'optionC', 'optionD','isAvail', 'created_by', 'created_at', 'updated_by', 'updated_at'];
    use HasFactory;
}
