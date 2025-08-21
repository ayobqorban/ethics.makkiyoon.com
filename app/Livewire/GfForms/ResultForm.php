<?php

namespace App\Livewire\GfForms;

use App\Models\Form;
use App\Models\GfForm;
use App\Models\GfSubmission;
use App\Models\Submission;
use Livewire\Component;

class ResultForm extends Component
{
    public $formId;          // معرف النموذج
    public $questions = [];  // قائمة الأسئلة
    public $results = [];    // نتائج الاختيارات
    public $textResponses = []; // الإجابات النصية

    public function mount($id)
    {
        $this->formId = $id;
        $this->loadQuestions();
        $this->calculateResults();
    }

    /**
     * تحميل الأسئلة المرتبطة بالنموذج
     */
    public function loadQuestions()
    {
        $form = GfForm::findOrFail($this->formId);
        $this->questions = $form->questions()->with('options')->get();
    }

    /**
     * حساب النتائج لكل سؤال
     */
    public function calculateResults()
    {
        foreach ($this->questions as $question) {
            if ($question->type === 'radios') {
                $this->results[$question->id] = [];
                $totalResponses = GfSubmission::where('question_id', $question->id)->count();

                foreach ($question->options as $option) {
                    $optionCount = GfSubmission::where('question_id', $question->id)
                        ->where('answer', (string) $option->id) // تحويل الإجابة إلى نص لأن الإجابات قد تكون نصوصًا
                        ->count();

                    $this->results[$question->id][$option->id] = [
                        'count' => $optionCount,
                        'percentage' => $totalResponses > 0 ? round(($optionCount / $totalResponses) * 100, 2) : 0,
                    ];
                }
            } elseif ($question->type === 'textarea') {
                $this->textResponses[$question->id] = GfSubmission::where('question_id', $question->id)
                    ->pluck('answer')
                    ->toArray();
            }
        }
    }

    public function render()
    {
        return view('livewire.gf-forms.result-form');
    }
}
