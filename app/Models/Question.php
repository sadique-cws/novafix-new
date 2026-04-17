<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'problem_id',
        'question_text',
        'yes_question_id',
        'no_question_id',
        'image_url',
        'image_file_id',
        'description',
    ];
}
