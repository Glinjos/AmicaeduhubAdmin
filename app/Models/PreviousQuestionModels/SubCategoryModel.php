<?php

namespace App\Models\PreviousQuestionModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategoryModel extends Model
{
    public $timestamps = false;
    protected $table = 'pq_submodule';
    protected $primaryKey = 'pqsmId';
    protected $fillable = ['pqmId', 'pqsmName','isAvail','created_by','created_at','updated_by'];

    use HasFactory;
}
