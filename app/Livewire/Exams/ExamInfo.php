<?php

namespace App\Livewire\Exams;

use App\Models\Exam;
use App\Models\ExamQuestion;
use Livewire\Component;

class ExamInfo extends Component
{
    public $question_count;
    public $answer_count;
    public $completed_count;
    public $formId;
    public $timeout;
    public $examId;


        // Listen for the event
        protected $listeners = ['questionUpdated'];


    public function answer_count()
    {
        return ExamQuestion::whereIn('option_value', [0, 1])->where('exam_id', $this->examId->id)->count();
    }

    public function question_count()
    {
        return ExamQuestion::where('exam_id', $this->examId->id)->count();
    }

    public function completed_count()
    {
        return floor($this->answer_count() / $this->question_count() * 100);
    }


    public function completeExam(){

        if($this->question_count == $this->answer_count){
            $exam = Exam::find($this->examId->id);
            $result_pass = $exam->form->result_pass;
            $result = ExamQuestion::where('exam_id',$this->examId->id)->get();
            $answered = ExamQuestion::where('exam_id', $this->examId->id)
            ->whereIn('option_value', [0, 1])->count();
            $notAnswered = ExamQuestion::where('exam_id', $this->examId->id)
            ->whereNull('option_value')->count();

            $sum = $result->sum('option_value');
            $final_total = intval($sum / $this->question_count * 100);
            $exam->result = $final_total;
            $exam->answer_count = $answered;
            $exam->no_answer_count = $notAnswered;
            if($final_total >= $result_pass){
                $exam->status = 'completed';
            }else{
                $exam->status = 'failed';
            }

            $exam->save();
            return redirect()->route('result.exam',$this->examId->id);

        }
    }





    public function render()
    {
        $this->answer_count = $this->answer_count();
        $this->question_count = $this->question_count();
        $this->completed_count = $this->completed_count();
        return view('livewire.exams.exam-info',[
            'question_count' => $this->question_count,
            'answer_count' => $this->answer_count,
            'completed_count' => $this->completed_count,
        ]);
    }
}
