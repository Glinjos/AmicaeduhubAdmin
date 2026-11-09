<?php

namespace App\Models\ImagePQAModel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class imagePanswerModel extends Model
{
    use HasFactory;
    protected $table = 'image_p_answers';
    protected $primaryKey = 'ipqaId';
    protected $fillable = ['ipqaId','ipqId',
    'optionA','optionB','optionC','optionD','isAvail','created_by','created_at',
    'updated_by','updated_at'];
}
