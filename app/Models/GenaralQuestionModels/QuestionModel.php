<?php

namespace App\Models\GenaralQuestionModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionModel extends Model
{
    use HasFactory;
    protected $table = 'cooperation_question';
    protected $fillable = 
    [
        'smId',
        'qCode',
        'question',
        'optA',
        'optB',
        'optC',
        'optD',
        'question_level',
        'isAvail',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];
    
      protected $primaryKey = 'cqId';
      protected $hidden = 'cqId';
}
