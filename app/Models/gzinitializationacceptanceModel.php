<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class gzinitializationacceptanceModel extends Model
{
    protected $table = 'gz_initialization_acceptance';
    protected $primaryKey = 'giaId';
    protected $fillable = [
        'giaId',
        'giId',
        'opponentId',
        'acceptedOpponents',
        'declinedOpponents',
        'isAvail',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
    ];
    use HasFactory;
}
