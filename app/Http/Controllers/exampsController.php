<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Form;
use App\Models\GfForm;
use App\Models\CountExampSuccess;
use App\Models\UserCertificate;
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

        // إضافة معلومات إكمال النماذج العامة لكل نموذج
        foreach ($gfForms as $gfForm) {
            $gfForm->is_completed = UserCertificate::where('user_id', $userId)
                ->where('certificate_id', $id)
                ->where('status', 'completed')
                ->exists();
        }

        // التحقق من اجتياز جميع الاختبارات في الشهادة للمستخدم الحالي فقط
        $allExamsPassed = $this->checkAllExamsPassed($forms, $userId);

        // التحقق من وجود شهادة مكتملة للمستخدم
        $userCertificate = UserCertificate::where('user_id', $userId)
            ->where('certificate_id', $id)
            ->where('status', 'completed')
            ->first();

        return view('pages.forms.employee_forms_index',[
            'forms' => $forms,
            'gfForms' => $gfForms,
            'selected_id' => $id,
            'allExamsPassed' => $allExamsPassed,
            'userCertificate' => $userCertificate
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

    /**
     * تحميل الشهادة
     */
    public function downloadCertificate($filename)
    {
        $userId = auth()->id();

        // التحقق من أن الشهادة تخص المستخدم الحالي
        $userCertificate = UserCertificate::where('user_id', $userId)
            ->where('certificate_filename', $filename)
            ->where('status', 'completed')
            ->first();

        if (!$userCertificate) {
            abort(404, 'الشهادة غير موجودة أو غير مصرح لك بالوصول إليها');
        }

        $filePath = storage_path('app/public/uploads/certificates/' . $filename);

        if (!file_exists($filePath)) {
            abort(404, 'ملف الشهادة غير موجود');
        }

        return response()->download($filePath, $filename);
    }
}


