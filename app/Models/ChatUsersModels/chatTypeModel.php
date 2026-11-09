<?php

namespace App\Models\ChatUsersModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class chatTypeModel extends Model
{
    use HasFactory;
    protected $table = 'chat_type';
    protected $primaryKey='chatTypeId';
    protected $fillable = [
        'typeName',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at'
        
    ];
}
