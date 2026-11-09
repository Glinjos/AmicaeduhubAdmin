<?php

namespace App\Models\ReferUsersModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class referUsersModel extends Model
{
    use HasFactory;
    protected $table = 'refer_users';
    protected $primaryKey='refer_Id';
    protected $fillable = [
        'refer_user_Id',
        'referral_code',
        'created_at',
        'updated_at'
    ];
}
