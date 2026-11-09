<?php

namespace App\Models\GameZoneModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class gzanswerModel extends Model
{
    protected $table = 'cooperation_answer';
    protected $primaryKey = 'caId';
    protected $fillable = ['caId','cqId','optA','optB','optC','optD','isAvail','created_by','created_at','updated_by'];
    use HasFactory;
}
