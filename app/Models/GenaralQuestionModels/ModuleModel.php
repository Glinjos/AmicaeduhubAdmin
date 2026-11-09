<?php
/**
 * Created by PhpStorm.
 * User: SHAZIN
 * Date: 10-02-2023
 * Time: 17:55
 */

namespace App\Models\GenaralQuestionModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModuleModel extends Model
{
    public $timestamps = false;
    protected $table = 'module';
    protected $primaryKey = 'mId';
    protected $fillable = ['mCode','mName','isAvail','created_by','created_at','updated_by','updated_at'];

    use HasFactory;
}


