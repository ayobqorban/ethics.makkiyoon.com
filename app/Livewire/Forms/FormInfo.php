<?php

namespace App\Livewire\Forms;

use App\Models\Form;
use App\Models\FormQuestion;
use Livewire\Component;

class FormInfo extends Component
{

    public $formId;
    public function mount($id)
    {
        $this->formId = $id;
    }
        // جلب الأسئلة المرتبطة بالنموذج في الصفحة الحالية
        public function getQuestionsCount()
        {
            return FormQuestion::where('form_id',$this->formId)->count();
        }
        // الاسئلة الثابتة
        public function getQuestionsFixed()
        {
            return FormQuestion::with('question')->where('form_id',$this->formId)->where('is_fixed',true)->get();
        }

    public function render()
    {
        $form = Form::find($this->formId);
        $fixed = count($this->getQuestionsFixed());
        return view('livewire.forms.form-info', [
            'form' => $form,
            'fixed' => $fixed,
        ]);
    }

}
