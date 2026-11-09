<?php

namespace App\Models\LiveGameModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class lgquestionModel extends Model
{
    protected $table = 'cooperation_question';
    protected $primaryKey = 'cqId';
    protected $fillable = ['cqId','smId','qCode','question','optA','optB','optC','optD','question_level','isAvail','created_by','created_at','updated_by'];
    use HasFactory;

    public function get_answers(){
        return  $this->hasOne(gzanswerModel::class,'cqId','cqId');
    }
}
