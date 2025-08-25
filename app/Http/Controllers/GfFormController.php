<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Form;
use App\Models\GfForm;
use App\Models\CountExampSuccess;
use Illuminate\Http\Request;

class GfFormController extends Controller
{
    public function __construct()
    {
        // التأكد من تسجيل الدخول لجميع وظائف هذا الـ Controller
        $this->middleware('auth');
    }

    public function index(){
        return view('pages.gf-forms.form');
    }

    public function show($id){
        $userId = auth()->id();

        if (!$userId) {
            return redirect()->route('login')->with('error', 'يجب تسجيل الدخول أولاً');
        }

        // التحقق من أن المستخدم اجتاز جميع الاختبارات المطلوبة للوصول لهذا النموذج
        if (!$this->canAccessGfForm($id, $userId)) {
            return redirect()->back()->with('error', 'يجب اجتياز جميع الاختبارات المطلوبة قبل الوصول لهذا النموذج');
        }

        return view('pages.gf-forms.show',compact('id'));
    }

    public function insert_form($gfFormId){
        $userId = auth()->id();

        if (!$userId) {
            return redirect()->route('login')->with('error', 'يجب تسجيل الدخول أولاً');
        }

        // التحقق من أن المستخدم اجتاز جميع الاختبارات المطلوبة
        if (!$this->canAccessGfForm($gfFormId, $userId)) {
            return redirect()->back()->with('error', 'يجب اجتياز جميع الاختبارات المطلوبة قبل تعبئة هذا النموذج');
        }

        return view('pages.gf-forms.insert_form',compact('gfFormId'));
    }

    public function result_form($id){
        return view('pages.gf-forms.result_form',compact('id'));
    }

    /**
     * التحقق من إمكانية الوصول للنموذج العام
     */
    private function canAccessGfForm($gfFormId, $userId = null)
    {
        // إذا لم يتم تمرير معرف المستخدم، احصل عليه من الجلسة
        if (!$userId) {
            $userId = auth()->id();
        }

        // تأكد من وجود المستخدم
        if (!$userId) {
            return false;
        }

        // جلب النموذج العام
        $gfForm = GfForm::find($gfFormId);
        if (!$gfForm) {
            return false;
        }

        // جلب الشهادة المرتبطة بهذا النموذج
        $countSuccess = CountExampSuccess::where('forms_id', $gfFormId)
            ->where('form_type', 'gf_form')
            ->first();

        if (!$countSuccess) {
            return true; // إذا لم يكن مرتبط بشهادة، اسمح بالوصول
        }

        $certificateId = $countSuccess->cr_certificates_id;

        // جلب جميع الاختبارات المرتبطة بنفس الشهادة
        $forms = Form::whereHas('countExampSuccess', function($query) use ($certificateId) {
            $query->where('cr_certificates_id', $certificateId)
                  ->where('form_type', 'form');
        })->get();

        // إذا لم توجد اختبارات، اسمح بالوصول
        if ($forms->isEmpty()) {
            return true;
        }

        // التحقق من اجتياز جميع الاختبارات للمستخدم المحدد فقط
        foreach ($forms as $form) {
            $hasPassedExam = $form->exams()
                ->where('user_id', $userId) // ربط بالمستخدم المحدد فقط
                ->where('status', 'completed')
                ->exists();

            if (!$hasPassedExam) {
                return false;
            }
        }

        return true;
    }
}
