<?php

namespace App\Livewire\Results;

use App\Models\Form;
use App\Models\User;
use Livewire\Component;

class Results extends Component
{
    public $formsData;

    public function mount()
    {
        // جلب النماذج مع العلاقات المرتبطة وحساب البيانات المطلوبة
        $this->formsData = Form::with(['users', 'exams'])->get()->map(function ($form) {
            $totalUsers = User::count(); // إجمالي الأعضاء
            $participants = $form->exams->count(); // عدد المشاركين
            $notParticipated = $totalUsers - $participants; // الذين لم يشاركوا
            $passed = $form->exams->where('status', 'completed')->count(); // عدد الاجتياز
            $notPassed = $participants - $passed; // الذين لم يجتازوا

            return [
                'id' => $form->id,
                'title' => $form->title,
                'total_users' => $totalUsers,
                'participants' => $participants,
                'not_participated' => $notParticipated,
                'passed' => $passed,
                'not_passed' => $notPassed,
            ];
        });
    }

    public function render()
    {
        return view('livewire.results.results', [
            'formsData' => $this->formsData,
        ]);
    }
}
