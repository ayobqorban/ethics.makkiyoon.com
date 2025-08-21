<?php

namespace App\Livewire\questions;

use Livewire\Component;
use App\Models\Question;

class Questions extends Component
{
    public $title;
    public $questionId; // لتحديد السؤال الذي سيتم تعديله
    public $isEditMode = false; // للتحقق من حالة التعديل

    public function mount(){

    }
    public function addQuestion()
    {


        $this->validate([
            'title' => 'required|string|max:255',
        ]);

        if ($this->isEditMode && $this->questionId) {
            // تعديل السؤال الحالي
            $question = Question::find($this->questionId);
            if ($question) {
                $question->title = $this->title;
                $question->save();
            }
        } else {
            // إضافة سؤال جديد
            Question::create([
                'title' => $this->title,
                 'is_fixed' => false, // يمكن التعديل حسب متطلباتك
            ]);
        }

        // إعادة ضبط الحقول بعد الإضافة أو التحديث
        $this->resetForm();
    }

    public function editQuestion($id)
    {
        $question = Question::find($id);
        if ($question) {
            $this->title = $question->title;
            $this->questionId = $question->id;
            $this->isEditMode = true; // وضع التعديل
        }
    }

    public function deleteQuestion($id)
{
    $question = Question::find($id);
    if ($question) {
        if ($question->options()->count() == 0) {
            $question->delete();
        } else {
            session()->flash('error', 'لا يمكن حذف السؤال لأنه مرتبط بخيارات.');
        }
    }
}

    public function resetForm()
    {
        $this->title = '';
        $this->questionId = null;
        $this->isEditMode = false;
    }

    public function render()
    {
        $questions = Question::all();
        return view('livewire.questions.index', compact('questions'));
    }
}
