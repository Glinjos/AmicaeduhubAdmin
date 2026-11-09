<?php

namespace App\Models\GameZoneModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class gzinitializeModel extends Model
{
    protected $table = 'gz_initialization';
    protected $primaryKey = 'giId';
    protected $fillable = [
                            'giId',
                            'gameType',
                            'date_time',
                            'moduleId',
                            'chapterId',
                            'gameMode',
                            'noOfQuestions',
                            'playerId',
                            'opponentId',
                            'firstOpponentId',
                            'isAccepted',
                            'isExpired',
                            'isAvail',
                            'created_by',
                            'created_at',
                            'updated_by',
                            'updated_at'
                        ];
    use HasFactory;
}
