<?php

namespace App\Livewire\Forms;

use App\Models\Certificate;
use App\Models\Exam;
use App\Models\ExamQuestion;
use App\Models\Form;
use App\Models\FormQuestion;
use App\Models\GfForm;
use App\Models\Question;
use Livewire\Component;
use Livewire\WithPagination;

class ShowForm extends Component
{
    use WithPagination;

    public $formId;
    public $selectedQuestions = [];
    public $perPage = 200;
    public $refreshKey;
    public $user_id;
    public $duration;
    public $question_count;

    public function mount($id)
    {
        $this->user_id = auth()->user()->id;
        $this->formId = $id;

    }



        // public function setExamp()
        // {
        //     // $form = Form::find($this->formId);

        //     $minutes = $this->duration; // عدد الدقائق

        //     // الحصول على الوقت الحالي (UTC)
        //     $startTime = now();
        //     $endTime = $startTime->copy()->addMinutes($minutes);

        //     $startTime_sa = $startTime->setTimezone('Asia/Riyadh');
        //     $endTime_sa = $endTime->setTimezone('Asia/Riyadh');

        //     // إنشاء سجل جديد في جدول Exam
        //     $set_exam = Exam::create([
        //         'user_id' => $this->user_id,
        //         'status' => 1,
        //         'form_id' => $this->formId,
        //         'start_time' => $startTime_sa,
        //         'end_time' => $endTime_sa,
        //         'attempts' => 1,
        //     ]);

        //     // التأكد من إنشاء الامتحان بنجاح
        //     if ($set_exam) {


        //         // 1. جلب الأسئلة الثابتة (is_fixed = 1) لنموذج معين
        //         $fixedQuestions = FormQuestion::with(['question', 'question.options'])
        //             ->where('form_id', $this->formId)
        //             ->where('is_fixed', 1)
        //             ->get();

        //         // 2. جلب الأسئلة العشوائية (غير الثابتة) لنفس النموذج
        //         $randomQuestions = FormQuestion::with(['question', 'question.options'])
        //             ->where('form_id', $this->formId)
        //             ->where('is_fixed', 0) // استبعاد الأسئلة الثابتة
        //             ->inRandomOrder() // اختيار عشوائي
        //             ->limit($this->question_count) // تحديد عدد الأسئلة العشوائية إلى 8
        //             ->get();

        //         // 3. دمج القائمتين معًا
        //         $allQuestions = $fixedQuestions->merge($randomQuestions);

        //         // 4. تخزين الأسئلة في جدول exam_questions
        //         foreach ($allQuestions as $formQuestion) {
        //             ExamQuestion::create([
        //                 'exam_id' => $set_exam->id,
        //                 'user_id' => $this->user_id,
        //                 'form_id' => $this->formId,
        //                 'question_id' => $formQuestion->question_id,
        //             ]);
        //         }

        //         // 5. التوجيه إلى صفحة عرض الامتحان
        //         return redirect()->route('exams.show', $set_exam->id);
        //     }
        // }




        // جلب الأسئلة المرتبطة بالنموذج في الصفحة الحالية
        public function getCurrentPageQuestions()
        {
            return FormQuestion::with('question')->where('form_id',$this->formId)->paginate($this->perPage);
        }

        // الاسئلة الثابتة
        public function getQuestionsFixed()
        {
            return FormQuestion::with('question')->where('form_id',$this->formId)->where('is_fixed',true)->get();
        }
        public function getDoesntHaveInForm()
        {
            return Question::whereDoesntHave('forms', function($query) {
                $query->where('forms.id', $this->formId);
            })->paginate($this->perPage);
        }



    public function addQuestions()
    {
        $form = Form::find($this->formId);
        $form->questions()->attach($this->selectedQuestions);

        // إعادة تعيين المتغيرات وإغلاق الـ modal
        $this->selectedQuestions = [];
        $this->dispatch('close-modal');
        $this->refreshKey++;
        session()->flash('message', 'تم إضافة الأسئلة بنجاح.');
    }

    public function paginator($paginator)
    {
        return $paginator->links('vendor.pagination.custom-pagination');
    }

    public function toggleFixed($formQuestionId)
    {
        $question = FormQuestion::find($formQuestionId);
        if ($question) {
            $question->is_fixed = !$question->is_fixed; // تغيير القيمة إلى عكسها
            $question->save(); // حفظ التغيير

            $this->refreshKey++;
        }
    }

    public function selectGeneralForm($id)
    {
        $form = Form::find($this->formId); // البحث عن النموذج
        if ($form) {
            $form->general_form_id = $id;
            $form->save(); // حفظ التغيير
            session()->flash('message', 'تم تحديث نموذج اعتماد الاختبار بنجاح'); // رسالة تأكيد
        } else {
            session()->flash('error', 'النموذج غير موجود');
        }
    }

    public function selectCetificateForm($id)
    {
        $form = Form::find($this->formId); // البحث عن النموذج
        if ($form) {
            $form->certificate_id = $id;
            $form->save(); // حفظ التغيير
            session()->flash('message', 'تم تحديث شهادة الاختبار بنجاح'); // رسالة تأكيد
        } else {
            session()->flash('error', 'النموذج غير موجود');
        }
    }


    public function deleteformQuestion($id){
        $delte = FormQuestion::find($id);
        if($delte){
            $delte->delete();
            $this->refreshKey++;
        }
    }

    public function getAllGeneralForms(){
        return GfForm::all();
    }

    public function getAllCertificates(){
        return Certificate::all();
    }


    public function render()
    {
        $form = Form::find($this->formId);
        $this->duration = $form->duration;
        $this->question_count = $form->question_count;
        $gf_forms = $this->getAllGeneralForms();
        $cr_certificates = $this->getAllCertificates();

        $questions = $this->getDoesntHaveInForm(); // تعديل العدد حسب الحاجة
        $questionForm = $this->getCurrentPageQuestions();
        $count = count($questionForm->items());
        $fixed = count($this->getQuestionsFixed());
        return view('livewire.forms.show-form', [
            'form' => $form,
            'cr_certificates'=>$cr_certificates,
            'questions' => $questions,
            'questionForm' => $questionForm,
            'quesCount' => $count,
            'fixed' => $fixed,
            'gf_forms'=>$gf_forms,
        ]);
    }
}
