<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Form;
use Illuminate\Http\Request;

class FormController extends Controller
{
    public function __construct()
    {
        // التأكد من تسجيل الدخول لجميع وظائف هذا الـ Controller
        $this->middleware('auth');
    }

    public function index()
    {
        return view('pages.forms.index');
    }

    public function employee_forms_info($formId)
    {
        $user_id = auth()->user()->id;
        $exams = Exam::with('form')->where('user_id',$user_id)->where('form_id',$formId)->get();

        return view('pages.forms.employee_info',['formId'=>$formId,'exams'=>$exams]);
    }

    public function general_form_info($formId)
    {
        $form = Form::find($formId);
        return view('pages.forms.general_form_info',compact('form'));
    }

    public function employee_forms_index()
    {
        return view('pages.forms.employee_forms_index');
    }

    public function show($id)
    {
        $form = Form::find($id);
        return view('pages.forms.show',compact('form'));
    }

    public function generealFormQuestions($question_id){
        return view('pages.general-form.generalFormQuestions',['question_id'=>$question_id]);
    }



}
