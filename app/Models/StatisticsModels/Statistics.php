<?php

namespace App\Models\StatisticsModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statistics extends Model
{
    use HasFactory;
    protected $table = 'user_analytics';
    protected $primaryKey='aId';
    protected $fillable = [
        'aId','dateAndTime','courseType','userId','examTypeId','examModuleId','examSubModuleId','vcChapterVideoId','totalQuestions','QuestionsAttended','rightAns','wrongAns','score','percentage','playerId','opponentId','playerAttended','playerRightAns','playerWrongAns','playerScore','playerPercentage','opponentAttended','opponentRightAns','opponentWrongAns','opponentScore','opponentPercentage','winnerId'
    ];
}
