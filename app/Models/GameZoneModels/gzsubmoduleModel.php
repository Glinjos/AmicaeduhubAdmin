<?php

namespace App\Models\GameZoneModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class gzsubmoduleModel extends Model
{
    protected $table = 'sub_module';
    protected $primaryKey = 'smId';
    protected $fillable = ['smId','mId','smCode','smName','currentCode','isAvail','created_by','created_at','updated_by'];
    use HasFactory;
}
