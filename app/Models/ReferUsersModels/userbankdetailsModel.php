<?php

namespace App\Models\ReferUsersModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class userbankdetailsModel extends Model
{
    use HasFactory;
    protected $table = 'ref_user_bank_details';
    protected $primaryKey='userbank_Id';
    protected $fillable = [
        'b_userId',
        'ac_number',
        'upi_number',
        'upi_id',
        'ifc_code',
        'ac_holder_name',
        'remark',
        'created_at',
        'updated_at'
    ];
}

