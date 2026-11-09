<?php

namespace App\Models\GameZoneModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class gzhistoryModel extends Model
{
    protected $table = 'gz_history';
    protected $primaryKey = 'ghId';
    protected $fillable = [
                            'ghId',
                            'giId',
                            'userId',
                            'winnerId',
                            'totalQuestion',
                            'attendedQuestions',
                            'rightAns',
                            'wrongAns',
                            'score',
                            'isPlayer',
                            'isOpponent',
                            'isAvail',
                            'created_by',
                            'created_at',
                            'updated_by',
                            'updated_at'
                        ];
    use HasFactory;
}
