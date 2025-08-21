<?php

namespace App\Livewire\GfForms;

use App\Models\GfForm;
use App\Models\GfQuestion;
use App\Models\GfQuestions;
use Livewire\Component;

class Show extends Component
{
    public $formId;
    public $formQuestions = []; // الأسئلة المرتبطة بالنموذج
    public $availableQuestions = []; // الأسئلة المتاحة غير المرتبطة بالنموذج
    public $selectedQuestions = []; // الأسئلة المختارة للإضافة
    public $isModalOpen = false; // حالة النافذة المنبثقة

    public function mount($id)
    {
        $this->formId = $id;
        $this->loadFormQuestions();
        $this->loadAvailableQuestions();
    }

    /**
     * تحميل الأسئلة المرتبطة بالنموذج
     */
    public function loadFormQuestions()
    {
        $form = GfForm::findOrFail($this->formId);
        $this->formQuestions = $form->questions; // تحويل الكائن إلى مصفوفة
    }

    /**
     * تحميل الأسئلة المتاحة التي لم تتم إضافتها للنموذج
     */
    public function loadAvailableQuestions()
    {
        $this->availableQuestions = GfQuestions::whereNotIn('id', collect($this->formQuestions)->pluck('id')->toArray())->get();
    }

    /**
     * فتح النافذة المنبثقة لإضافة الأسئلة
     */
    public function openModal()
    {
        $this->isModalOpen = true;
        $this->loadAvailableQuestions();
    }

    /**
     * إغلاق النافذة المنبثقة
     */
    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->selectedQuestions = [];
    }

    /**
     * تحديد أو إلغاء تحديد جميع الأسئلة المتاحة
     */
    public function toggleSelectAll()
    {
        $questionsCollection = collect($this->availableQuestions);

        if (count($this->selectedQuestions) === $questionsCollection->count()) {
            $this->selectedQuestions = [];
        } else {
            $this->selectedQuestions = $questionsCollection->pluck('id')->toArray();
        }
    }

    /**
     * إضافة الأسئلة المختارة إلى النموذج
     */
    public function addQuestionsToForm()
    {
        $form = GfForm::findOrFail($this->formId);

        $form->questions()->attach($this->selectedQuestions);

        session()->flash('success', 'تمت إضافة الأسئلة بنجاح!');

        $this->closeModal();
        $this->loadFormQuestions();
    }

    /**
     * إزالة سؤال مرتبط بالنموذج
     */
    public function removeQuestion($questionId)
    {
        $form = GfForm::findOrFail($this->formId);

        $form->questions()->detach($questionId);

        session()->flash('success', 'تم حذف السؤال بنجاح!');
        $this->loadFormQuestions();
    }

    /**
     * عرض المكون
     */
    public function render()
    {
        return view('livewire.gf-forms.show');
    }
}
