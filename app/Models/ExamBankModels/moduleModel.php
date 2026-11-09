<?php

namespace App\Models\ExamBankModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class moduleModel extends Model
{
    protected $table = 'module';
    protected $primaryKey = 'mId';
    protected $fillable = ['mId','mCode','mName','isAvail','created_by','created_at','updated_by'];
    use HasFactory;
}
