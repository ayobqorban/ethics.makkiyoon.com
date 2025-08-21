<?php

// namespace App\Http\Livewire\Forms;
namespace App\Livewire\Forms;

use App\Models\Form;
use Livewire\Component;
use Illuminate\Support\Facades\Log;
class Forms extends Component
{

    public $title;
    public $description;
    public $start_date;
    public $end_date;
    public $duration;
    public $attempts;
    public $isEditMode = false;
    public $formId;
    public $result_pass;
    public $question_count;
     public $defult_date;

    public function mount(){
         $this->defult_date = now()->toDateString();
    }

    // قواعد التحقق
    protected $rules = [
        'title' => 'required|string|min:10',
        'description' => 'nullable|string|max:255',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'duration' => 'required|integer',
        'attempts' => 'required|integer',
        'result_pass' => 'required|integer',
        'question_count' => 'required|integer',
    ];

     // رسائل التحقق المخصصة
     protected $messages = [
        'title.required' => 'يرجى إدخال عنوان النموذج.',
        'title.string' => 'يجب أن يكون العنوان نصًا صالحًا.',
        'title.max' => 'يجب ألا يزيد العنوان عن 255 حرفًا.',
        'start_date.required' => 'يرجى تحديد بداية الاختبار.',
        'start_date.date' => 'يجب أن يكون تاريخ البداية بصيغة صالحة.',
        'end_date.required' => 'يرجى تحديد نهاية الاختبار.',
        'end_date.date' => 'يجب أن يكون تاريخ النهاية بصيغة صالحة.',
        'end_date.after_or_equal' => 'يجب أن يكون تاريخ النهاية بعد أو يساوي تاريخ البداية.',
        'duration.required' => 'يرجى تحديد مدة الاختبار.',
        'duration.integer' => 'يجب أن تكون المدة رقمًا صحيحًا.',
        'attempts.required' => 'يرجى تحديد عدد المحاولات.',
        'attempts.integer' => 'يجب أن يكون عدد المحاولات رقمًا صحيحًا.',
        'result_pass.required' => 'يجب إدخال درجة النجاح.',
        'result_pass.integer' => 'يجب أن تكون درجة النجاح رقمًا صحيحًا.',
        'question_count.required' => 'يجب إدخال عدد الأسئلة العشوائية.',
        'question_count.integer' => 'يجب أن يكون عدد الأسئلة العشوائية رقمًا صحيحًا.',
    ];


    public function addForm()
    {
            $this->validate();

            if ($this->isEditMode && $this->formId) {
                // تعديل النموذج الحالي
                $form = Form::find($this->formId);
                if ($form) {
                    $form->update([
                        'title' => $this->title,
                        'description' => $this->description,
                        'start_date' => $this->start_date,
                        'end_date' => $this->end_date,
                        'duration' => $this->duration,
                        'attempts' => $this->attempts,
                        'result_pass' => $this->result_pass,
                        'question_count' => $this->question_count,
                    ]);
                }
            } else {
                // إضافة نموذج جديد
                Form::create([
                    'title' => $this->title,
                    'description' => $this->description,
                    'start_date' => $this->start_date,
                    'end_date' => $this->end_date,
                    'duration' => $this->duration,
                    'attempts' => $this->attempts,
                    'result_pass' => $this->result_pass,
                    'question_count' => $this->question_count,
                ]);
            }

            // إعادة ضبط الحقول بعد الإضافة أو التحديث
            $this->resetForm();
    }


    public function toggleActive($formId)
    {
        $is_active = Form::find($formId);
        if ($is_active) {
            $is_active->is_active = !$is_active->is_active; // تغيير القيمة إلى عكسها
            $is_active->save(); // حفظ التغيير
        }
    }


    public function editForm($id)
    {
        $form = Form::find($id);
        if ($form) {
            $this->formId = $form->id;
            $this->title = $form->title;
            $this->description = $form->description;
            $this->start_date = $form->start_date ? \Carbon\Carbon::parse($form->start_date)->format('Y-m-d') : null;
            $this->end_date = $form->end_date ? \Carbon\Carbon::parse($form->end_date)->format('Y-m-d') : null;
            $this->duration = $form->duration;
            $this->attempts = $form->attempts;
            $this->result_pass = $form->result_pass;
            $this->question_count = $form->question_count;
            $this->isEditMode = true;
        }
    }

    public function deleteForm($id)
    {
        $question = Form::find($id);
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
        $this->description = '';
        $this->start_date = '';
        $this->end_date = '';
        $this->duration = '';
        $this->attempts = '';
        $this->result_pass = '';
        $this->question_count = '';
        $this->isEditMode = false;
        $this->formId = null;
    }


    public function render()
    {
        $forms = Form::withCount('questions')->get();
        return view('livewire.forms.forms',compact('forms'));
    }
}
