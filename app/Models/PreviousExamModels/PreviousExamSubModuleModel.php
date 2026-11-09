<?php

namespace App\Models\PreviousExamModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreviousExamSubModuleModel extends Model
{
    use HasFactory;
    protected $table = 'pq_submodule';
    protected $primaryKey='pqsmId';
    protected $fillable = [
          'pqmId', 
          'pqsmName',
          'isAvail',
          'created_by',
          'created_at', 
          'updated_by', 
          'updated_at'
    ];
}
