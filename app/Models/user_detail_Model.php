<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user_detail_Model extends Model
{
    use HasFactory;
    protected $table = 'user_details';
    protected $primaryKey='uId';
    protected $fillable = [
        'name',
        'mobile',
        'otp',
        'planId',
        'userImage',
        'userEmail',
        'dob',
        'district_Id',
        'userGender',
        'userAddress',
        'onlinetoken',
        'ActiveUser',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at'
    ];
}
