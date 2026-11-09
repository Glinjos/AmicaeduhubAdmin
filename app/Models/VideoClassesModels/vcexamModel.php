<?php

namespace App\Models\VideoClassesModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vcexamModel extends Model
{
    protected $table = 'vc_exams';
    protected $primaryKey = 'vcExamId';
    protected $fillable = ['vcExamId','vcVDId','question','optionA','optionB','optionC','optionD','isAvail','created_by','created_at','updated_by'];
    use HasFactory;

    public function get_answers(){
        return  $this->hasOne(vcansModel::class,'vcExamId','vcExamId');
    }
}
