<?php

namespace App\Models\VideoClassesModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vcmoduleModel extends Model
{
    protected $table = 'vc_module';
    protected $primaryKey = 'vcmId';
    protected $fillable = ['vcmId','vcmName','isAvail','created_by','created_at','updated_by'];
    use HasFactory;
}
