<?php

namespace App\Models\CountryDetailsModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class districtModel extends Model
{
    use HasFactory;
    protected $table = 'districts';
    protected $primaryKey='district_Id';
    protected $fillable = [
        'district_name',
        'state_Id',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at'
    ];
}
