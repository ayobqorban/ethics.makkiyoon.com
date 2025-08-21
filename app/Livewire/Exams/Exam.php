<?php

namespace App\Livewire\Exams;

use App\Models\Exam as ModelsExam;
use App\Models\ExamQuestion;
use App\Models\Form;
use App\Models\Option;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

use App\Models\Certificate;
use Mpdf\Mpdf;
use Illuminate\Support\Facades\Storage;


class Exam extends Component
{
    use WithPagination;

    public $formId;
    public $user_id;
    public $answer_count;
    public $question_count;
    public $completed_count;
    public $end_time;
    public $refreshkey;
    public $examId;
    // public $finish_question;

    public $timeout;


    public function mount($id)
    {
        $this->examId = ModelsExam::find($id);

        if ($this->examId) {
            $this->formId = $this->examId->form_id;
            $this->user_id = auth()->user()->id;
            $this->timeout = $this->check_timeout();
        }
    }


    public function check_timeout()
    {
        $exam = ModelsExam::find($this->examId->id);
        $this->end_time = $exam->end_time ;
        $nowtime = Carbon::now();
        $endtime = Carbon::parse($this->end_time);

        if ($endtime->lessThan($nowtime)) {

            // إذا أنتهى الوقت يتم التحقق من البيانات وتعيينها حسب النتيجة
            if(empty($exam->result)){
                $result_pass = $exam->form->result_pass;
                $result = ExamQuestion::where('exam_id',$this->examId->id)->get();
                $answered = ExamQuestion::where('exam_id', $this->examId->id)
                ->whereIn('option_value', [0, 1])->count();
                $notAnswered = ExamQuestion::where('exam_id', $this->examId->id)
                ->whereNull('option_value')->count();

                $sum = $result->sum('option_value');
                $final_total = intval($sum / count($result) * 100);
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

                return $this->timeout = false;
        }else{
            return $this->timeout =  true;
            return redirect()->route('result.exam',$this->examId->id);
        }

    }








    public function render()
    {
        return view('livewire.exams.exam', [
            'formId' => $this->formId,
             'timeout'=> $this->check_timeout()
        ]);
    }
}
