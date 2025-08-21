<?php

namespace App\Livewire\Results;

use App\Models\Exam;
use App\Models\User;
use Livewire\Component;

class Show extends Component
{
    public function alldata(){
        return Exam::with('user')
        ->withCount([
            'questions as correct_answers_count'=>function($query){
                $query->where('option_value',1);
            },
            'questions as incorrect_answers_count'=>function($query){
                $query->where('option_value',0);
            },
            'questions as no_aswers_count'=>function($query){
                $query->where('option_value',null);
            }
        ])
        ->get();
    }

    public function usersNotInExam(){
        return User::whereDoesntHave('exams')->get();
    }
    public function render()
    {
         $exams = $this->alldata();
         $noExam = $this->usersNotInExam();
        //  dd($exams);
          return view('livewire.results.show',['exams'=>$exams,'noExam'=>$noExam]);
    }
}
