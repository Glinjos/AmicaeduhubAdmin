<?php

namespace App\Models\VideoClassesModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vcchapterModel extends Model
{
    protected $table = 'vc_chapters';
    protected $primaryKey = 'vcChapterId';
    protected $fillable = ['vcChapterId','vcmId','vcChapterName','isAvail','created_by','created_at','updated_by'];
    use HasFactory;
}
