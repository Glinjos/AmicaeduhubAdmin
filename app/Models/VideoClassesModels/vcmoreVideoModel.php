<?php

namespace App\Models\VideoClassesModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vcmoreVideoModel extends Model
{
    protected $table = 'vc_more_videos';
    protected $primaryKey = 'vcVDId';
    protected $fillable = ['vcVDId','vcChapterId','videoHeading','videoLink','description','isPublished','created_by','created_at','updated_by'];
    use HasFactory;
}
