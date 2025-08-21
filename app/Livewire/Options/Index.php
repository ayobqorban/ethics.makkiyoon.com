<?php

namespace App\Livewire\Options;

use App\Models\Option;
use App\Models\Question;
use Livewire\Component;

class Index extends Component
{
    public $title;
    public $point;
    public $optionId; // لتحديد السؤال الذي سيتم تعديله
    public $isEditMode = false; // للتحقق من حالة التعديل
    public $questionId;
    public $options;
    public $type;

    public function addOptions()
    {
        // dd($this->title);
        $this->validate([
            'title' => 'required|string|max:255',
            'point' => 'required|integer|min:0',
            'type' => 'nullable',
        ]);

        if ($this->isEditMode && $this->optionId) {
            // تعديل الخيار الحالي
            $option = Option::find($this->optionId);
            if ($option) {
                $option->title = $this->title;
                $option->save();
            }
        } else {
            // إضافة خيار جديد
            Option::create([
                'title' => $this->title,
                'points' => $this->point,
                'type' => $this->type,
                'question_id' => $this->questionId,
            ]);
        }

        // إعادة ضبط الحقول بعد الإضافة أو التحديث
        $this->resetForm();
    }

    public function toggleCorrect($id)
    {
        $currentOption = Option::find($id);

        if ($currentOption) {
            // Set all options of the same question to false
            Option::where('question_id', $this->questionId)
                ->update(['is_correct' => false]);

            // Set the current option to true
            $currentOption->is_correct = true;
            $currentOption->save();
        }
    }



    public function editOption($id)
    {
        $option = Option::find($id);
        if ($option) {
            $this->title = $option->title;
            $this->point = $option->points;
            $this->optionId = $option->id;
            $this->isEditMode = true; // وضع التعديل
        }
    }



    public function deleteOption($id)
{
    $option = Option::find($id);
    // dd($option);
    if ($option) {
        $option->delete();
    }
}

    public function resetForm()
    {
        $this->title = '';
        $this->point = '1';
        $this->optionId = null;
        $this->isEditMode = false;
    }


    public function mount($id){
        $this->questionId = $id;
    }

    public function getQuestion(){
        return Question::find($this->questionId);
    }
    public function render()
    {
        $question = $this->getQuestion();
        $this->options = Option::where('question_id',$this->questionId)->get();
        return view('livewire.options.index',[
            'options'=>$this->options,
            'question'=>$question,
        ]);

    }
}
