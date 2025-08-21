<?php

namespace App\Livewire;

use App\Models\Exam;
use App\Models\ExamQuestion;
use App\Models\Form;
use App\Models\FormQuestion;
use Livewire\Component;

class CreateExamButton extends Component
{
    public $user_id;
    public $formId;
    public $question_count;
    public $newExamCan;
    public $check_status;
    public $formData;
    public $status_faild;
    public $attempts = 1;
    public $btnName;

    public function mount($formId,$btnName='دخول الاختبار'){
        $this->formId = $formId;
        $this->formData = Form::find($this->formId);
        $this->user_id = auth()->user()->id;
        $this->newExamCan = $this->canCreateExam();
        $this->btnName = $btnName;
    }

    public function canCreateExam(){
        $this->check_status = Exam::where('form_id', $this->formId)->where('user_id', $this->user_id)->whereIn('status', ['ongoing', 'completed'])->count();
        if($this->check_status === 1){
            // dd('false');
            return false;
        }else{
            $this->status_faild = Exam::where('form_id', $this->formId)->where('user_id', $this->user_id)->where('status','failed')->count();
            if($this->formData->attempts > $this->status_faild ){
                $this->attempts = $this->status_faild + 1;
                // dd('true');
                return true;
            }else{
                return false;
            }
        }
    }

    public function setExamp()
    {

        if($this->canCreateExam()){
            $attempts = $this->attempts;
            $form = $this->formData;
            $this->question_count = $form->question_count;

            $minutes = $form->duration; // عدد الدقائق
            // الحصول على الوقت الحالي (UTC)
            $startTime = now();
            $endTime = $startTime->copy()->addMinutes($minutes);

            // إنشاء سجل جديد في جدول Exam
            $set_exam = Exam::create([
                'user_id' => $this->user_id,
                'status' => 1,
                'form_id' => $this->formId,
                'start_time' => $startTime,
                'end_time' => $endTime,
                'attempts' => $attempts,
            ]);

            // التأكد من إنشاء الامتحان بنجاح
            if ($set_exam) {


                // 1. جلب الأسئلة الثابتة (is_fixed = 1) لنموذج معين
                $fixedQuestions = FormQuestion::with(['question', 'question.options'])
                    ->where('form_id', $this->formId)
                    ->where('is_fixed', 1)
                    ->get();
                    // 2. جلب الأسئلة العشوائية (غير الثابتة) لنفس النموذج
                    $randomQuestions = FormQuestion::with(['question', 'question.options'])
                    ->where('form_id', $this->formId)
                    ->where('is_fixed', 0) // استبعاد الأسئلة الثابتة
                    ->inRandomOrder() // اختيار عشوائي
                    ->limit($this->question_count) // تحديد عدد الأسئلة العشوائية إلى 8
                    ->get();

                // 3. دمج القائمتين معًا
                $allQuestions = $fixedQuestions->merge($randomQuestions);

                // 4. تخزين الأسئلة في جدول exam_questions
                foreach ($allQuestions as $formQuestion) {
                    ExamQuestion::create([
                        'exam_id' => $set_exam->id,
                        'user_id' => $this->user_id,
                        'form_id' => $this->formId,
                        'question_id' => $formQuestion->question_id,
                    ]);
                }

                // 5. التوجيه إلى صفحة عرض الامتحان
                return redirect()->route('exams.show', $set_exam->id);
            }
        }else{

            $this->newExamCan = false;
        }
    }

    public function render()
    {
        return view('livewire.create-exam-button');
    }
}
