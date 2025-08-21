<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'form_id',
        'status',
        'start_time',
        'end_time',
        'attempts',
        'result',
        'answer_count',
        'no_answer_count',
        'gf_form',
        'certificated_name',

    ];

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'exam_questions');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function form(){
        return $this->belongsTo(Form::class);
    }




}
