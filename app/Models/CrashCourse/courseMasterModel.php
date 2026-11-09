<?php

namespace App\Models\CrashCourse;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class courseMasterModel extends Model
{
    use HasFactory;
    protected $table = 'course_master';
    protected $primaryKey='cmId';
    protected $fillable = [
                            'coName',
                            'coDescription',
                            'coActivePrice',
                            'coOfferPrice',
                            'coDays',
                            'isClosed',
                            'created_by',
                            'created_at',
                            'updated_by',
                            'updated_at'
                        ];
                       
}
