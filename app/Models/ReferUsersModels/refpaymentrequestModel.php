<?php

namespace App\Models\ReferUsersModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class refpaymentrequestModel extends Model
{
    use HasFactory;
    protected $table = 'ref_payment_request';
    protected $primaryKey='request_Id';
    protected $fillable = [
        'req_date',
        'req_user_Id',
        'req_coin',
        'isRequested',
        'req_accepted_date',
        'remark',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at'
    ];
}
