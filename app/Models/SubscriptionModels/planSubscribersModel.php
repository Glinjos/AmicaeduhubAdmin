<?php

namespace App\Models\SubscriptionModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class planSubscribersModel extends Model
{
    use HasFactory;
    protected $table = 'app_plan_subscribers';
    protected $primaryKey='apsId';
    protected $fillable = [
                            'planId',
                            'uId',
                            'transactionNumber',
                            'netPayableAmount',
                            'startDate',
                            'endDate',
                            'isExpired',
                            'created_at',
                            'updated_at'
                        ];
}
