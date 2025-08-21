<?php

namespace App\Livewire\Results;

use App\Models\Exam;
use App\Models\ExamQuestion;
use App\Models\Option;
use Livewire\Component;

class ResultShow extends Component
{
    public $formId;
    public $user_id;
    public $examId;

    public function mount($id){
        $this->examId = $id;
    }

    public function getCurrentPageQuestions()
    {
        return ExamQuestion::with(['question', 'question.options'])->where('exam_id', $this->examId)->get();
    }

    public function exam(){
        return Exam::find($this->examId);
    }

    public function answer_option($id, $optionId)
    {
        $value = Option::find($optionId);
        $is_answer = ExamQuestion::find($id);
        if ($is_answer) {
            $is_answer->selected_option_id = $optionId;
            $is_answer->option_value = $value->is_correct;
            $is_answer->save();

            // Emit event to notify ExamInfo
            $this->dispatch('questionUpdated');
        }
    }

    public function render()
    {
        $exam = $this->exam();
        $examQuestions = $this->getCurrentPageQuestions();
        return view('livewire.results.result-show',[
           'examQuestions' => $examQuestions,
           'exam' => $exam,

        ]);
    }
}
