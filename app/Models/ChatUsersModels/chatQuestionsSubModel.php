<?php

namespace App\Models\ChatUsersModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class chatQuestionsSubModel extends Model
{
    use HasFactory;
    protected $table = 'chat_questions_sub';
    protected $primaryKey='chatQuestionSubId';
    protected $fillable = [
        'chatQuestionId',
        'question',
        'chatDateTime',
        'created_at',
        'updated_at'   
    ];
}
