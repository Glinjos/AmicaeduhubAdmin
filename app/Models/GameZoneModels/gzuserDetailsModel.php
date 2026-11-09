<?php

namespace App\Models\GameZoneModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class gzuserDetailsModel extends Model
{
    protected $table = 'user_details';
    protected $primaryKey = 'uId';
    protected $fillable = ['uId','name','mobile','otp','onlinetoken','created_by','created_at','updated_by' ];
    use HasFactory;
}
