<?php

namespace App\Models\chatSuggestionsModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class chatSuggestionSub extends Model
{
    use HasFactory;
    protected $table = 'chat_suggestion_sub';
    protected $primaryKey='cssubId';
    protected $fillable = [
        'chatQuestionId',
        'suggestions',
        'chatDateTime',
        'created_at',
        'updated_at'   
    ];
}
