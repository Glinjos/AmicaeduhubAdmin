<?php

namespace App\Models\LiveGameModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class lgmasterModel extends Model
{
    protected $table = 'livegame_master';
    protected $primaryKey = 'lgmId ';
    protected $fillable = [
                            'lgmId',
                            'questionId',
                            'dateTime',
                            'playerId',
                            'playerNickname',
                            'opponentId',
                            'opponentNickname',
                            'isAvail',
                            'created_by',
                            'created_at',
                            'updated_by',
                            'updated_at	'
                        ];
    use HasFactory;
}
