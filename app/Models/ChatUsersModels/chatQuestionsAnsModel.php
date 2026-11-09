<?php

namespace App\Models\ChatUsersModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class chatQuestionsAnsModel extends Model
{
    use HasFactory;
    protected $table = 'chat_questions_ans';
    protected $primaryKey='chatQuestionAnsId';
    protected $fillable = [
        'chatQuestionId',
        'AssignedTo',
        'AssignedBy',
        'Answer',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at'    
    ];
}
