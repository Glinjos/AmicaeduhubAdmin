<?php

namespace App\Models\ImagePQAModel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class imagePquestionModel extends Model
{
    use HasFactory;
    protected $table = 'image_p_questions';
    protected $primaryKey = 'ipqId';
    protected $fillable = ['ipqId','pqsmId','question',
    'optionA','optionB','optionC','optionD','isAvail','created_by','created_at',
    'updated_by','updated_at'];

    public function get_answers(){
        return  $this->hasOne(imagePanswerModel::class,'ipqId','ipqId');
    }
}
