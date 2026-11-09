<?php

namespace App\Models\GenaralQuestionModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubModuleModel extends Model
{
    use HasFactory;
    protected $table = 'sub_module';
    public $timestamps = false;
    protected $primaryKey='smId';
    protected $fillable = [
        'smId',
        'mId',
        'smCode',
        'smName',
        'currentCode',
        'isAvail',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];
}
