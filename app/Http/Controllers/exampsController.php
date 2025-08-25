<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Form;
use App\Models\GfForm;
use App\Models\CountExampSuccess;
use Illuminate\Http\Request;

class exampsController extends Controller
{
    public function examps_index()
    {
        $allexamps = Certificate::all();
        return view('pages.exams.all_exam',[
            'allexamps'=>$allexamps
        ]);
    }

    public function examps_page($id)
    {
        // جلب الـ forms المرتبطة بالشهادة من خلال جدول count_examp_success
        $forms = Form::whereHas('countExampSuccess', function($query) use ($id) {
            $query->where('cr_certificates_id', $id)
                  ->where('form_type', 'form');
        })->with(['exams' => function($query) {
            $query->where('user_id', auth()->id())
                  ->latest(); // ترتيب حسب الأحدث
        }])->get();

        // جلب النماذج العامة المرتبطة بالشهادة
        $gfForms = GfForm::whereHas('countExampSuccess', function($query) use ($id) {
            $query->where('cr_certificates_id', $id)
                  ->where('form_type', 'gf_form');
        })->get();

        return view('pages.forms.employee_forms_index',[
            'forms' => $forms,
            'gfForms' => $gfForms,
            'selected_id' => $id
        ]);
    }
}


