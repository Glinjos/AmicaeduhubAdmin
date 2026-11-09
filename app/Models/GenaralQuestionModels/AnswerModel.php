<?php

namespace App\Models\GenaralQuestionModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnswerModel extends Model
{
    use HasFactory;
    protected $table = 'cooperation_answer';
    protected $fillable = ['cqId','optA','optB','optC','optD','isAvail','created_by','updated_by','created_at','updated_at'];
    protected $primaryKey = 'caId';
    protected $hidden = 'caId';

}
 