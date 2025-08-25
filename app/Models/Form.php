<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'duration',
        'attempts',
        'result_pass',
        'is_active',
        'general_form_id',
        'question_count',
        'certificate_id'
            ];

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'form_questions');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'form_users');
    }

    public function exams()
    {
        return $this->hasMany(Exam::class, 'form_id'); // افتراض أن جدول exams يحتوي على عمود form_id
    }

    // العلاقة مع جدول count_examp_success
    public function countExampSuccess()
    {
        return $this->hasMany(CountExampSuccess::class, 'forms_id');
    }
}
