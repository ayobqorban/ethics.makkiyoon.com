<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    // تحديد الجدول المرتبط بالموديل
    protected $table = 'answers';

    // الأعمدة القابلة للتعبئة
    protected $fillable = [
        'user_id',
        'form_id',
        'exam_id',
        'question_id',
        'selected_option_id',
        'option_value',
    ];

    // العلاقة مع موديل Exam
    public function exam()
    {
        return $this->belongsTo(Exam::class, 'exam_id');
    }

    // العلاقة مع موديل Question
    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }

    // العلاقة مع موديل Option
    public function selectedOption()
    {
        return $this->belongsTo(Option::class, 'selected_option_id');
    }

    // العلاقة مع موديل User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
