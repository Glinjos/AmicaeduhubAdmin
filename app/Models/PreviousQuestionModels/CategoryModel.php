<?php
/**
 * Created by PhpStorm.
 * User: SHAZIN
 * Date: 10-02-2023
 * Time: 17:55
 */

namespace App\Models\PreviousQuestionModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryModel extends Model
{
    public $timestamps = false;
    protected $table = 'pq_module';
    protected $primaryKey = 'pqmId';
    protected $fillable = ['pqmId','pqmainId','pqmName','isAvail','created_by','created_at','updated_by'];

    use HasFactory;
}


