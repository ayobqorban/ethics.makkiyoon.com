<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GfForm extends Model
{
    use HasFactory;

    protected $table = 'gf_forms';

    protected $fillable = ['title', 'description'];

    public function questions()
    {
        return $this->belongsToMany(GfQuestions::class, 'gf_form_has_questions', 'form_id', 'questions_id')
                    ->withTimestamps();
    }
}
