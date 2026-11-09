<?php

namespace App\Models\PreviousExamModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreviousExamCatogoryModel extends Model
{
    use HasFactory;
    protected $table = 'pq_module';
    protected $primaryKey='pqmId';
    protected $fillable = [
        'pqmName',
        'isAvail', 
        'created_by', 
        'created_at', 
        'updated_by', 
        'updated_at'
    ];
   
}
