<?php

namespace App\Livewire\GfForms;

use App\Models\GfForm;
use Livewire\Component;

class Forms extends Component
{
    public $forms;
    public $title;
    public $description;
    public $isEditMode = false;
    public $formId;

    protected $listeners = ['deleteConfirmed'];
    public function mount()
    {
        $this->loadForms();
    }

    public function loadForms()
    {
        $this->forms = GfForm::all();
    }

    public function addForm()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
        ]);

        GfForm::create([
            'title' => $this->title,
            'description' => $this->description,
        ]);

        session()->flash('success', 'تم إضافة النموذج بنجاح!');
        $this->resetForm();
        $this->loadForms();
    }

    public function editForm($id)
    {
        $form = GfForm::findOrFail($id);

        $this->formId = $form->id;
        $this->title = $form->title;
        $this->description = $form->description;
        $this->isEditMode = true;
    }

    public function updateForm()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
        ]);

        $form = GfForm::findOrFail($this->formId);

        $form->update([
            'title' => $this->title,
            'description' => $this->description,
        ]);

        session()->flash('success', 'تم تحديث النموذج بنجاح!');
        $this->resetForm();
        $this->loadForms();
    }



    public function deleteForm($id)
    {
        $form = GfForm::findOrFail($id);
        $form->delete();

        session()->flash('success', 'تم حذف النموذج بنجاح!');
        $this->loadForms();
    }




    public function resetForm()
    {
        $this->title = '';
        $this->description = '';
        $this->isEditMode = false;
        $this->formId = null;
    }


    public function render()
    {
        return view('livewire.gf-forms.forms');
    }
}
