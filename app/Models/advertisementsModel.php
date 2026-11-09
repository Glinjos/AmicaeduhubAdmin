<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class advertisementsModel extends Model
{
    
    use HasFactory;
    protected $table = 'advertisements';
    protected $primaryKey='adId';
    protected $fillable = [
                            'heading',
                            'contentType',
                            'image',
                            'videos',
                            'addType',
                            'isAvail',
                            'created_by',
                            'created_at',
                            'updated_by',
                            'updated_at'
                        ];
}
