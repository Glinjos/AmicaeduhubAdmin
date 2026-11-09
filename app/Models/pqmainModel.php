<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pqmainModel extends Model
{
    use HasFactory;
    protected $table = 'pq_main';
    protected $primaryKey='pqmainId';
    protected $fillable = [
        'pqmainName',
        'positiveMark',
        'negativeMark', 
        'isAvail',
        'created_by', 
        'created_at', 
        'updated_by', 
        'updated_at'
    ];
}
