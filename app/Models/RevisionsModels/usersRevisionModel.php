<?php

namespace App\Models\RevisionsModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class usersRevisionModel extends Model
{
    use HasFactory;
    protected $table = 'users_revisions';
    protected $primaryKey = 'u_RevId';
    protected $fillable = [
                            'u_RevId',
                            'dateAndTime',
                            'userId',
                            'totalQuestions',
                            'QuestionsAttended',
                            'rightAns',
                            'percentage',
                            'created_at',
                            'updated_at',
                        ];
}
