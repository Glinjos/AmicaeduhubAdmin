<?php

namespace App\Models\ReferUsersModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class refUserDetailsModel extends Model
{
    use HasFactory;
    protected $table = 'refer_users_details';
    protected $primaryKey='referUserdetails_Id';
    protected $fillable = [
        'date',
        'refered_user_Id',
        'refer_user_Id',
        'isUserSubscribed',
        'created_at',
        'updated_at'
    ];
}
