<?php

namespace App\Models\ExamBankModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubmoduleModel extends Model
{
    protected $table = 'sub_module';
    protected $primaryKey = 'smId';
    protected $fillable = ['smId','mId','smCode','smName','currentCode','isAvail','created_by','created_at','updated_by'];
    use HasFactory;
}
