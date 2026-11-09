<?php

namespace App\Models\ReferUsersModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class refAmountModel extends Model
{
    use HasFactory;
    protected $table = 'refer_amount';
    protected $primaryKey='refamount_Id';
    protected $fillable = [
        'ref_amount',
        'ref_type',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at'
    ];
}
