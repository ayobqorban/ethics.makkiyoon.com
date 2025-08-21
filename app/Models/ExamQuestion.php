<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamQuestion extends Model
{
    use HasFactory;

    // تحديد الجدول المرتبط بالموديل
    protected $table = 'exam_questions';

    // الأعمدة القابلة للتعبئة
    protected $fillable = [
        'form_id',
        'user_id',
        'exam_id',
        'question_id',
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
}
