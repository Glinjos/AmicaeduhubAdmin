<?php

namespace App\Models\SubscriptionModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionModel extends Model
{
    use HasFactory;
    protected $table = 'subscriptions';
    protected $primaryKey='planId';
    protected $fillable = [
        'planName',
        'actualPrice',
        'offerPrice',
        'planDescription',
        'planValidity',
        'previousQuestion',
        'isExpired',
        'videoClass',
        'crashCourse',
        'gameZone',
        'modelExams',
        'isAvail',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at'
    ];
}
