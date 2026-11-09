<?php

namespace App\Models\loginIP;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class appLoginModel extends Model
{
    use HasFactory;
    protected $table = 'app_login';
    protected $primaryKey='app_loginId';
    protected $fillable = [
        'DateAndTime',
        'username',
        'ipConfig',
        'hitCount',
        'created_at',
        'updated_at'
    ];
}
