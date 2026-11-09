<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class userdevicetokenModel extends Model
{
    protected $table = 'user_device_tokens';
    protected $primaryKey = 'udtId';
    protected $fillable = [
        'udtId',
        'uId',
        'deviceToken',
        'isAvail',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
    ];
    use HasFactory;
}
