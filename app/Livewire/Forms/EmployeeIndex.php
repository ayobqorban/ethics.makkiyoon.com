<?php

namespace App\Livewire\Forms;

use App\Models\Form;
use Livewire\Component;

class EmployeeIndex extends Component
{
    public function render()
    {
        $forms = Form::withCount('questions')->get();
        return view('livewire.forms.employee-index',['forms'=>$forms]);
    }
}
