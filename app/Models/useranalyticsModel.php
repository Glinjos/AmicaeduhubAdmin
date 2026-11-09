<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class useranalyticsModel extends Model
{
    protected $table = 'user_analytics';
    protected $primaryKey = 'aId';
    protected $fillable = [
                            'aId',
                            'dateAndTime',
                            'courseType',
                            'userId',
                            'examTypeId',
                            'examModuleId',
                            'examSubModuleId',
                            'vcChapterVideoId',
                            'totalQuestions',
                            'QuestionsAttended',
                            'rightAns',
                            'wrongAns',
                            'score',
                            'percentage',
                            'playerId',
                            'opponentId',
                            'playerAttended',
                            'playerRightAns',
                            'playerWrongAns',
                            'playerScore',
                            'playerPercentage',
                            'opponentAttended',
                            'opponentRightAns',
                            'opponentWrongAns',
                            'opponentScore',
                            'opponentPercentage',
                            'winnerId',
                            'created_by',
                            'created_at',
                            'updated_by',
                            'updated_at',
                        ];
    use HasFactory;
}
