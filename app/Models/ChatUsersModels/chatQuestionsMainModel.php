<?php

namespace App\Models\ChatUsersModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class chatQuestionsMainModel extends Model
{
    use HasFactory;
    protected $table = 'chat_questions_main';
    protected $primaryKey='chatQuestionId';
    protected $fillable = [
        'uId',
        'chatTypeId',
        'mId',
        // 'question',
        // 'chatDateTime',
        'isClosed',
        'assigned',
        'created_at',
        'updated_at'   
    ];
}
