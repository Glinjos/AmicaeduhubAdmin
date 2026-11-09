<?php

namespace App\Models\ModelExamMEModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class modelExamMENameModel extends Model
{
    use HasFactory;
    protected $table = 'model_exam_me';
    protected $primaryKey='meId';
    protected $fillable = [
        'meName','meDescription','noOfQuestions','positiveMark','negativeMark','isAvail','created_by','created_at','updated_by','updated_at'
    ];
}
