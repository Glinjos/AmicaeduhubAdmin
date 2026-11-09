<?php

namespace App\Models\VideoClassesModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vcansModel extends Model
{
    protected $table = 'vc_exam_ans';
    protected $primaryKey = 'vcAnswerId';
    protected $fillable = ['vcAnswerId','vcExamId','optionA','optionB','optionC','optionD','isAvail','created_by','created_at','updated_by'];
    use HasFactory;
}
