<?php

namespace App\Livewire\GfForms;

use App\Models\GfOption;
use Livewire\Component;

class Options extends Component
{
    public $questionId;
    public $title;
    public $type;
    public $options;
    public $isEditMode = false;
    public $optionId;

    public function mount($id)
    {
        $this->questionId = $id;
        $this->loadOptions();
    }

    public function loadOptions()
    {
        $this->options = GfOption::where('question_id', $this->questionId)->get();
    }

    public function addOption()
    {
        $this->validate([
            'title' => 'required|string|max:255',
        ]);

        GfOption::create([
            'question_id' => $this->questionId,
            'title' => $this->title,
         ]);

        session()->flash('success', 'تم إضافة الخيار بنجاح!');
        $this->resetForm();
        $this->loadOptions();
    }

    public function editOption($id)
    {
        $option = GfOption::findOrFail($id);
        $this->optionId = $option->id;
        $this->title = $option->title;
         $this->isEditMode = true;
    }

    public function updateOption()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:radios,textaria',
        ]);

        $option = GfOption::findOrFail($this->optionId);
        $option->update([
            'title' => $this->title,
            'type' => $this->type,
        ]);

        session()->flash('success', 'تم تحديث الخيار بنجاح!');
        $this->resetForm();
        $this->loadOptions();
    }

    public function deleteOption($id)
    {
        $option = GfOption::findOrFail($id);
        $option->delete();

        session()->flash('success', 'تم حذف الخيار بنجاح!');
        $this->loadOptions();
    }

    public function resetForm()
    {
        $this->title = '';
        $this->type = '';
        $this->isEditMode = false;
        $this->optionId = null;
    }

    public function render()
    {
        return view('livewire.gf-forms.options');
    }
}
