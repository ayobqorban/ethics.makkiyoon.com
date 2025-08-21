<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'type',
    ];




        public function options()
        {
            return $this->hasMany(Option::class, 'question_id');
        }

    public function forms()
        {
            return $this->belongsToMany(Form::class, 'form_questions', 'question_id', 'form_id');
        }
}
