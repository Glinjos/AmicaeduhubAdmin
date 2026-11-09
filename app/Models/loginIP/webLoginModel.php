<?php

namespace App\Models\loginIP;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class webLoginModel extends Model
{
    use HasFactory;
    protected $table = 'web_logins';
    protected $primaryKey='login_Id';
    protected $fillable = [
        'date',
        'username',
        'ipConfig',
        'hitCount',
        'created_at',
        'updated_at'
    ];
}
