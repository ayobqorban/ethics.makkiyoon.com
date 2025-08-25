<?php

use App\Http\Controllers\CertificateController;
use App\Http\Controllers\CheckCertificateController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\exampsController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\GfFormController;
use App\Http\Controllers\GfOptionsController;
use App\Http\Controllers\GfQuestionsController;
use App\Http\Controllers\ResultController;
use App\Livewire\Options\Index;
use Illuminate\Support\Facades\Response;


Route::get('/', function () {
    // التحقق من تسجيل الدخول
    if (Auth::check()) {
        return redirect('/employeeforms'); // إذا كان المستخدم مسجلاً، يتم عرض الصفحة الرئيسية
    } else {
        return redirect('/login'); // إذا لم يكن مسجلاً، يتم توجيهه إلى صفحة تسجيل الدخول
    }
});

Route::middleware('auth')->group(function(){

// Routes لإدارة الأسئلة
// Route::resource('questions/{type?}', QuestionController::class);
Route::get('questions',[QuestionController::class,'index'])->name('questions.index');
Route::get('question/{id}',[QuestionController::class,'show'])->name('questions.show');

// Routes لإدارة النماذج
// Route::resource('forms', FormController::class);
Route::get('forms',[FormController::class,'index'])->name('forms.index');
Route::get('form/{id}',[FormController::class,'show'])->name('forms.show');


Route::get('examps',[exampsController::class,'examps_index'])->name('all.examps.index');
Route::get('examps/{id}',[exampsController::class,'examps_page'])->name('examps.page');

Route::get('employeeforms',[FormController::class,'employee_forms_index'])->name('employee.forms.index');

Route::get('employeeforms/{id}',[FormController::class,'employee_forms_info'])->name('employee.forms.info');



// Routes لإدارة الاختبار
Route::get('exams/{id}',[ExamController::class,'show'])->name('exams.show');

// Routes لإدارة النتائج
Route::get('results',[ResultController::class,'index'])->name('result.index');
Route::get('result/{id}',[ResultController::class,'show'])->name('result.show');
Route::get('result/{id}/show',[ResultController::class,'result_show'])->name('result.exam');




// Routes لإدارة الاختبارات
Route::get('users/{userId}/exam/start', [ExamController::class, 'startExam'])->name('exam.start');
Route::post('exam/{examId}/submit', [ExamController::class, 'submitExam'])->name('exam.submit');



// النماذج العامة
Route::get('/gf_form',[GfFormController::class,'index'])->name('gf_forms.index');
Route::get('/gf_form/{id}',[GfFormController::class,'show'])->name('gf_forms.show');
Route::get('/gf_form/{gf_form_id}/insert',[GfFormController::class,'insert_form'])->name('gf_forms.insert');

Route::get('/gf_form/{id}/result',[GfFormController::class,'result_form'])->name('gf_forms.result');

Route::get('/gf_question',[GfQuestionsController::class,'index'])->name('gf_questions.index');
Route::get('/gf_options/{id}',[GfOptionsController::class,'index'])->name('gf_options.index');

// إدارة الشهادات
Route::get('/certificate',[CertificateController::class,'index'])->name('certificate.index');
});

Route::get('/verification/{code?}',[CheckCertificateController::class,'check']);
