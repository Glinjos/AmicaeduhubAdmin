<?php

namespace App\Models\GameZoneModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class gzquestionidModel extends Model
{
    protected $table = 'gz_initialization_questions';
    protected $primaryKey = 'giqId ';
    protected $fillable = [
                            'giId',
                            'qId',
                            'created_by',
                            'created_at',
                            'updated_by',
                            'updated_at'
                        ];
    use HasFactory;
}
