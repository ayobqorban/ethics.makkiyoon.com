<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Form;
use App\Models\GfForm;
use App\Models\CountExampSuccess;
use Illuminate\Http\Request;

class exampsController extends Controller
{
    public function __construct()
    {
        // التأكد من تسجيل الدخول لجميع وظائف هذا الـ Controller
        $this->middleware('auth');
    }

    public function examps_index()
    {
        $allexamps = Certificate::all();
        return view('pages.exams.all_exam',[
            'allexamps'=>$allexamps
        ]);
    }

    public function examps_page($id)
    {
        $userId = auth()->id(); // تأكد من وجود المستخدم

        if (!$userId) {
            return redirect()->route('login')->with('error', 'يجب تسجيل الدخول أولاً');
        }

        // جلب الـ forms المرتبطة بالشهادة من خلال جدول count_examp_success
        $forms = Form::whereHas('countExampSuccess', function($query) use ($id) {
            $query->where('cr_certificates_id', $id)
                  ->where('form_type', 'form');
        })->with(['exams' => function($query) use ($userId) {
            $query->where('user_id', $userId) // ربط بالمستخدم الحالي فقط
                  ->latest(); // ترتيب حسب الأحدث
        }])->get();

        // جلب النماذج العامة المرتبطة بالشهادة
        $gfForms = GfForm::whereHas('countExampSuccess', function($query) use ($id) {
            $query->where('cr_certificates_id', $id)
                  ->where('form_type', 'gf_form');
        })->get();

        // التحقق من اجتياز جميع الاختبارات في الشهادة للمستخدم الحالي فقط
        $allExamsPassed = $this->checkAllExamsPassed($forms, $userId);

        return view('pages.forms.employee_forms_index',[
            'forms' => $forms,
            'gfForms' => $gfForms,
            'selected_id' => $id,
            'allExamsPassed' => $allExamsPassed
        ]);
    }

    /**
     * التحقق من اجتياز جميع الاختبارات في الشهادة
     */
    private function checkAllExamsPassed($forms, $userId)
    {
        // إذا لم توجد اختبارات، اعتبر أن جميع الاختبارات مجتازة
        if ($forms->isEmpty()) {
            return true;
        }

        foreach ($forms as $form) {
            // التحقق من وجود اختبار مكتمل للمستخدم الحالي
            $hasPassedExam = $form->exams()
                ->where('user_id', $userId)
                ->where('status', 'completed')
                ->exists();

            // إذا لم يجتز أي اختبار من الاختبارات، عائد false
            if (!$hasPassedExam) {
                return false;
            }
        }

        // إذا اجتاز جميع الاختبارات
        return true;
    }
}


