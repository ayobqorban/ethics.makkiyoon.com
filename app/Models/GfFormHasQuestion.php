<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GfFormHasQuestion extends Model
{
    use HasFactory;

    protected $table = 'gf_form_has_questions';

    protected $fillable = ['form_id', 'questions_id'];

    public function form()
    {
        return $this->belongsTo(Form::class, 'form_id');
    }

    public function question()
    {
        return $this->belongsTo(GfQuestions::class, 'questions_id');
    }
}



