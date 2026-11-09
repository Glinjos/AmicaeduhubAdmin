<?php

namespace App\Models\ReferUsersModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class userLedgerModel extends Model
{
    use HasFactory;
    protected $table = 'ref_user_ledger';
    protected $primaryKey='userledger_Id';
    protected $fillable = [
        'date',
        'user_Id',
        'user_debit',
        'user_credit',
        'request_Id',
        'payment_mode',
        'remark',
        'created_at',
        'updated_at'
    ];
}
