<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GfQuestions extends Model
{
    use HasFactory;

    protected $table = 'gf_questions';

    protected $fillable = ['title', 'type'];

    public function forms()
    {
        return $this->belongsToMany(
            Form::class,
            'gf_form_has_questions', // اسم جدول العلاقة
            'questions_id', // المفتاح الأجنبي للسؤال في جدول الربط
            'form_id' // المفتاح الأجنبي للنموذج في جدول الربط
        )->withTimestamps();
    }

    public function options()
    {
        return $this->hasMany(GfOption::class, 'question_id');
    }

}
