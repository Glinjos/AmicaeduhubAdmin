<?php

namespace App\Models\LiveGameModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class lghistoryModel extends Model
{
    protected $table = 'livegame_history';
    protected $primaryKey = 'lghId ';
    protected $fillable = [
                            'lghId',
                            'lgmId',
                            'userId',
                            'nickname',
                            'winnerId',
                            'totalQuestions',
                            'attendedQuestions',
                            'rightAns',
                            'wrongAns',
                            'score',
                            'isAvail',
                            'created_by',
                            'created_at',
                            'updated_by',
                            'updated_at',
                        ];
    use HasFactory;
}
