<?php

namespace App\Livewire\GfForms;

use App\Models\GfQuestions;
use Livewire\Component;

class Questions extends Component
{

    public $title;
    public $type;
    public $questions;
    public $isEditMode = false;
    public $questionId;

    public function mount()
    {
        $this->loadQuestions();
    }

    public function loadQuestions()
    {
        $this->questions = GfQuestions::all();
    }

    public function addQuestion()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'type' => 'required',
        ]);

        GfQuestions::create([
            'title' => $this->title,
        ]);

        session()->flash('success', 'تم إضافة السؤال بنجاح!');
        $this->resetForm();
        $this->loadQuestions();
    }

    public function editQuestion($id)
    {
        $question = GfQuestions::findOrFail($id);
        $this->questionId = $question->id;
        $this->title = $question->title;
        $this->type = $question->type;
        $this->isEditMode = true;
    }

    public function updateQuestion()
    {

        $this->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:radio,textarea',
        ]);

        $question = GfQuestions::findOrFail($this->questionId);
        $question->update([
            'title' => $this->title,
            'type' => $this->type,
        ]);

        session()->flash('success', 'تم تحديث السؤال بنجاح!');
        $this->resetForm();
        $this->loadQuestions();
    }

    public function deleteQuestion($id)
    {
        $question = GfQuestions::findOrFail($id);
        $question->delete();

        session()->flash('success', 'تم حذف السؤال بنجاح!');
        $this->loadQuestions();
    }

    public function resetForm()
    {
        $this->title = '';
        $this->isEditMode = false;
        $this->questionId = null;
    }

    public function render()
    {
        return view('livewire.gf-forms.questions');
    }
}
