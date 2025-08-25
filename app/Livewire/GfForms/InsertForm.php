<?php

namespace App\Livewire\GfForms;

use App\Models\Certificate;
use App\Models\Exam;
use App\Models\Form;
use App\Models\GfForm;
use App\Models\GfFormHasQuestion;
use App\Models\GfQuestion;
use App\Models\GfQuestions;
use App\Models\GfSubmission;
use App\Models\Submission;
use App\Models\User;
use App\Models\UserCertificate;
use Livewire\Component;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Mpdf\Mpdf;
use Illuminate\Support\Facades\Storage;

class InsertForm extends Component
{
    public $questions; // تخزين الأسئلة
    public $answers = []; // تخزين الإجابات
    public $user_id;
    public $gfFormId;
    public $examId;
    public $formId;
    public $exam;
    public $user;
    public $afterSend = false;
    public $cr_fileName;
    public $downloadCertifiacte;


    public function mount($gfFormId)
    {
        // التأكد من أن المستخدم مسجل دخول
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'يجب تسجيل الدخول أولاً');
        }

        $this->user_id = auth()->user()->id;
        $this->user = User::find($this->user_id);

        // التحقق من إمكانية الوصول للنموذج (اجتياز جميع الاختبارات)
        if (!$this->canAccessForm($gfFormId)) {
            session()->flash('error', 'يجب اجتياز جميع الاختبارات المطلوبة قبل تعبئة هذا النموذج');
            return redirect()->route('examps.page', $this->getCertificateId($gfFormId));
        }

        $this->cr_fileName =  random_int(1000000000, 9999999999);
        $this->gfFormId = $gfFormId;


        // التأكد من أن الاختبار خاص بالمستخدم الحالي
        if ($this->exam && $this->exam->user_id !== $this->user_id) {
            session()->flash('error', 'غير مسموح بالوصول لهذا الاختبار');
            return redirect()->back();
        }

        // $this->downloadCertifiacte = $this->exam->certificated_name;
        // $this->formId = $this->exam->form_id;

        // if ($this->exam->gf_form == 'complete') {
        //     $this->afterSend = true;
        // } else {
        //     $this->afterSend = false;
        // }

        // جلب الأسئلة من قاعدة البيانات مع الخيارات المرتبطة بها
        $this->questions = GfQuestions::with('options')->get();
    }

    public function saveUserCertificate($certificateId)
    {
        // التحقق من عدم وجود شهادة مكتملة مسبقاً لنفس المستخدم والشهادة
        $existingCertificate = UserCertificate::where('user_id', $this->user_id)
            ->where('certificate_id', $certificateId)
            ->first();

        if (!$existingCertificate) {
            UserCertificate::create([
                'user_id' => $this->user_id,
                'certificate_id' => $certificateId,
                'certificate_filename' => $this->cr_fileName . '.pdf',
                'status' => 'completed',
                'completed_at' => now()
            ]);
        } else {
            // تحديث الشهادة الموجودة
            $existingCertificate->update([
                'certificate_filename' => $this->cr_fileName . '.pdf',
                'status' => 'completed',
                'completed_at' => now()
            ]);
        }
    }
    public function submitForm()
    {

        // جلب جميع الأسئلة المرتبطة بالنموذج الحالي
        $questions = GfFormHasQuestion::where('form_id', $this->gfFormId)->pluck('id')->toArray();

        $this->validate([
            'answers' => 'required|array',
        ]);

        if (count(array_keys($this->answers)) != count($questions)) {
            session()->flash('error', 'يرجى الإجابة على جميع الأسئلة قبل إرسال النموذج.');
            return;
        } else {
            // تخزين الإجابات في قاعدة البيانات
            foreach ($this->answers as $questionId => $answer) {
                GfSubmission::create([
                    'question_id' => $questionId,
                    'user_id' => $this->user_id,
                    'certificate_id' => $this->getCertificateId($this->gfFormId),
                    'answer' => is_array($answer) ? json_encode($answer) : $answer, // إذا كانت الإجابة نص أو اختيار
                ]);
            }

            $this->createQrCode();

            $certificateId = $this->getCertificateId($this->gfFormId);
            // اصدار الشهادة
            $this->mPdfCertificate($certificateId, $this->user->name);

            // حفظ بيانات الشهادة في جدول user_certificates
            $this->saveUserCertificate($certificateId);

            $this->afterSend = true;

            // إعادة التوجيه إلى صفحة الشهادة
            return redirect()->route('examps.page', $certificateId)->with('success', 'تم إتمام النموذج العام بنجاح! يمكنك الآن تحميل الشهادة.');
        }

    }




    public function createQrCode()
    {
        // تحديد مسار الحفظ
        $uploadDirectory = public_path('storage/uploads/qr/');

        // التأكد من وجود المجلد، وإن لم يكن موجودًا يتم إنشاؤه
        if (!is_dir($uploadDirectory)) {
            mkdir($uploadDirectory, 0755, true);
        }

        // إنشاء اسم الملف
        $fileName = $this->cr_fileName . '.svg';
        $outputFile = $uploadDirectory . $fileName;

        // إنشاء وحفظ QR Code بصيغة SVG
        QrCode::format('svg')
            ->size(200) // تحديد الحجم (اختياري)
            ->generate('https://ethics.makkiyoon.com/verification/'.$this->cr_fileName, $outputFile);

        // إرجاع المسار أو رسالة التأكيد
        return "QR Code تم إنشاؤه وحفظه بنجاح في: " . $outputFile;
    }




    protected function mPdfCertificate($certificate_id, $fullname)
    {


        // استرجاع الشهادة من قاعدة البيانات
        $certificate = Certificate::find($certificate_id);
        if (!$certificate) {
            session()->flash('error', 'الشهادة غير موجودة.');
            return;
        }

        try {
            // إعداد اسم ومسار ملف PDF
            $filePath = 'uploads/certificates/' . $this->cr_fileName . '.pdf';

            // تحديد مسار مجلد الخطوط الخاص بك
            $fontDir = public_path('storage/fonts/cairo');

            // تحديد معلومات الخطوط
            $fontData = [
                'cairo' => [
                    'R' => 'Cairo-Medium.ttf',
                    'B' => 'Cairo-Bold.ttf',
                    'useOTL' => 0xFF,
                    'useKashida' => 75,
                ]
            ];


            // إعداد مكتبة mPDF
            $mpdf = new \Mpdf\Mpdf([
                'format' => 'A4', // A4
                'orientation' => 'L', // تعيين الصفحة لتكون بالعرض
                'default_font' => 'cairo', // تحديد الخط الافتراضي
                'fontDir' => $fontDir, // تحديد مسار مجلد الخطوط
                'fontdata' => $fontData // تحديد معلومات الخطوط
            ]);

            // رابط صورة الخلفية (من قاعدة البيانات)
            $backgroundImage = public_path('storage/' . $certificate->img); // فرضًا أن عمود `img` يحتوي على مسار الخلفية
            $qrCodeInCertificate = public_path('storage/uploads/qr/'.$this->cr_fileName.'.svg');
            $html = "
            <html>
            <head>
                <style>
                    html, body {
                        height: 100%;
                        margin: 0;
                        padding: 0;
                    }
                    body {
                        font-family: 'Cairo', sans-serif;
                        text-align: center;
                        direction: rtl;
                        background-image: url('{$backgroundImage}');
                        background-size: cover;
                        background-repeat: no-repeat;
                        background-position: center center;
                    }
                    .name {
                        position: absolute;
                        width: 100%;
                        text-align: center;
                        top: 380px;
                        right:0px;
                        font-size: 35px; /* حجم الخط */
                        font-weight: bold;
                        color: #004d00; /* لون أخضر غامق */
                    }
                    .date {
                        position: absolute;
                        bottom: 60px; /* المسافة من الأسفل */
                        left: 49%;
                        transform: translateX(-50%);
                        font-size: 18px; /* حجم الخط */
                        color: #555;
                    }
                    .number {
                        position: absolute;
                        bottom: 80px; /* المسافة من الأسفل */
                        right: 100px;
                        transform: translateX(-50%);
                        font-size: 22px; /* حجم الخط */
                        font-weight: bold;
                        color: #317951;
                    }
                     .qr-code {
                        position: absolute;
                        bottom: 0px; /* المسافة من الأسفل */
                        right: 90px;
                            width: 90px; /* حجم QR Code */
                            height: 90px;
                        }
                        .qrdiv{
                         position: absolute;
                         bottom: 140px;
                         right: 105px;
                        }
                </style>
            </head>
            <body>
                <div class='name'>{$fullname}</div>
                <div class='qrdiv'><img class='qr-code' src='{$qrCodeInCertificate}' alt='QR Code'></div>
                <div class='number'>" . $this->cr_fileName . "</div>
                <div class='date'>" . date('Y-m-d') . "</div>
            </body>
            </html>
            ";

            // كتابة المحتوى إلى ملف PDF
            $mpdf->WriteHTML($html);

            // حفظ PDF في المجلد المطلوب
            Storage::disk('public')->put($filePath, $mpdf->Output('', 'S'));

            // إعداد جلسة النجاح
            session()->flash('success', 'تم إنشاء ملف PDF بنجاح!');
            session()->flash('pdf_path', asset('storage/' . $filePath));
        } catch (\Exception $e) {
            session()->flash('error', 'حدث خطأ أثناء إنشاء ملف PDF: ' . $e->getMessage());
        }
    }


    /**
     * التحقق من إمكانية الوصول للنموذج
     */
    private function canAccessForm($gfFormId)
    {
        $gfForm = GfForm::find($gfFormId);
        if (!$gfForm) {
            return false;
        }

        $countSuccess = \App\Models\CountExampSuccess::where('forms_id', $gfFormId)
            ->where('form_type', 'gf_form')
            ->first();

        if (!$countSuccess) {
            return true;
        }

        $certificateId = $countSuccess->cr_certificates_id;

        $forms = Form::whereHas('countExampSuccess', function($query) use ($certificateId) {
            $query->where('cr_certificates_id', $certificateId)
                  ->where('form_type', 'form');
        })->get();

        if ($forms->isEmpty()) {
            return true;
        }

        foreach ($forms as $form) {
            $hasPassedExam = $form->exams()
                ->where('user_id', $this->user_id)
                ->where('status', 'completed')
                ->exists();

            if (!$hasPassedExam) {
                return false;
            }
        }

        return true;
    }

    /**
     * الحصول على معرف الشهادة
     */
    private function getCertificateId($gfFormId)
    {
        $countSuccess = \App\Models\CountExampSuccess::where('forms_id', $gfFormId)
            ->where('form_type', 'gf_form')
            ->first();

        return $countSuccess ? $countSuccess->cr_certificates_id : null;
    }

    public function render()
    {
        // $downlaodCr = $this->exam->certificated_name;
        $fg_form = GfForm::find($this->gfFormId);
        return view('livewire.gf-forms.insert-form', compact('fg_form'));
    }
}
