<?php

namespace App\Models\CountryDetailsModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class statesModel extends Model
{
    use HasFactory;
    protected $table = 'states';
    protected $primaryKey='state_Id';
    protected $fillable = [
        'state_name',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at'
    ];
}
