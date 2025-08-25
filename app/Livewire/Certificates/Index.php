<?php

namespace App\Livewire\Certificates;

use App\Models\Certificate;
use App\Models\Form;
use App\Models\GfForm;
use App\Models\CountExampSuccess;
use Livewire\Component;
use Livewire\WithFileUploads;

use Mpdf\Mpdf;
use Illuminate\Support\Facades\Storage;

class Index extends Component
{
    use WithFileUploads;

    public $certificates; // قائمة الشهادات
    public $forms; // قائمة الاختبارات/النماذج
    public $gfForms; // قائمة النماذج العامة
    public $certificateId;
    public $name;
    public $img;
    public $selectedForms = []; // الاختبارات المحددة
    public $selectedGfForms = []; // النماذج العامة المحددة
    public $isEditMode = false;

    public function mount()
    {
        $this->loadCertificates();
        $this->loadForms();
        $this->loadGfForms();
    }

    public function loadCertificates()
    {
        $this->certificates = Certificate::all();
    }

    public function loadForms()
    {
        $this->forms = Form::where('is_active', 1)->get();
    }

    public function loadGfForms()
    {
        $this->gfForms = GfForm::all();
    }

    // public function createQrCodeWithPdf($text)
    // {
    //     // 1. إنشاء رمز QR بصيغة SVG
    //     $qrCode = QrCode::format('svg')->size(200)->generate($text);

    //     // 2. إعداد اسم ملف PDF
    //     $fileName = 'certificate_' . time() . '.pdf';
    //     $filePath = 'uploads/certificates/' . $fileName;

    //     // 3. إنشاء ملف PDF باستخدام mPDF
    //     $mpdf = new Mpdf();

    //     // 4. تحديد خلفية الصورة
    //     $backgroundImage = asset('storage/uploads/templates/background.jpg'); // ضع مسار الخلفية هنا

    //     // 5. إنشاء محتوى HTML للـ PDF
    //     $html = "
    //         <html>
    //             <head>
    //                 <style>
    //                     body {
    //                         font-family: sans-serif;
    //                         background-image: url('{$backgroundImage}');
    //                         background-size: cover;
    //                         background-position: center;
    //                         background-repeat: no-repeat;
    //                     }
    //                     .qr-container {
    //                         text-align: center;
    //                         margin-top: 50%;
    //                     }
    //                 </style>
    //             </head>
    //             <body>
    //                 <div class='qr-container'>
    //                     {$qrCode}
    //                 </div>
    //             </body>
    //         </html>
    //     ";

    //     // 6. كتابة المحتوى في ملف PDF
    //     $mpdf->WriteHTML($html);

    //     // 7. حفظ الملف في storage
    //     Storage::disk('public')->put($filePath, $mpdf->Output('', 'S'));

    //     // 8. إرسال رسالة نجاح
    //     session()->flash('success', 'تم إنشاء رمز QR وملف PDF بنجاح!');
    //     session()->flash('pdf_path', asset('storage/' . $filePath));
    // }



    public function createSimplePdf($certificate_id)
    {
        // استرجاع الشهادة من قاعدة البيانات
        $certificate = Certificate::find($certificate_id);

        if (!$certificate) {
            session()->flash('error', 'الشهادة غير موجودة.');
            return;
        }

        try {
            // إعداد اسم ومسار ملف PDF
            $fileName = 'certificate_' . time() . '.pdf';
            $filePath = 'uploads/certificates/' . $fileName;

            // إعداد
            $mpdf = new Mpdf([
                'format' => 'A4', // A4
                'orientation' => 'L', // تعيين الصفحة لتكون بالعرض
                'default_font' => 'dejavusans', // خط يدعم العربية
            ]);

            // رابط صورة الخلفية (من قاعدة البيانات)
            $backgroundImage = public_path('storage/' . $certificate->img); // فرضًا أن عمود `img` يحتوي على مسار الخلفية
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
                        font-family: DejaVuSans, Arial, sans-serif;
                        text-align: center;
                        direction: rtl;
                        background-image: url('{$backgroundImage}');
                        background-size: contain;
                        background-repeat: no-repeat;
                        background-position: center center;
                    }
                    h1 {
                        color: #333;
                        margin-top: 200px; /* لضبط موضع النص */
                    }
                    p {
                        color: #555;
                        margin-top: 20px;
                    }
                </style>
            </head>
            <body>
                <h1 >{$certificate->name}</h1>
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





    public function addCertificate()
    {
        $this->validate([
            'name' => 'required|string|max:200',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4048',
            'selectedForms' => 'array', // تأكد من أن selectedForms هو مصفوفة
        ]);

        // رفع الصورة إلى المسار المحدد
        $imgPath = $this->img ? $this->img->store('uploads/templates', 'public') : null;

        $certificate = Certificate::create([
            'name' => $this->name,
            'img' => $imgPath,
        ]);

        // حفظ الاختبارات المرتبطة في جدول count_examp_success
        if (!empty($this->selectedForms)) {
            foreach ($this->selectedForms as $formId) {
                CountExampSuccess::create([
                    'cr_certificates_id' => $certificate->id,
                    'forms_id' => $formId,
                    'users_id' => auth()->id(), // المستخدم الحالي
                    'form_type' => 'form', // نوع النموذج: اختبار
                ]);
            }
        }

        // حفظ النماذج العامة المرتبطة
        if (!empty($this->selectedGfForms)) {
            foreach ($this->selectedGfForms as $gfFormId) {
                CountExampSuccess::create([
                    'cr_certificates_id' => $certificate->id,
                    'forms_id' => $gfFormId,
                    'users_id' => auth()->id(),
                    'form_type' => 'gf_form', // نوع النموذج: نموذج عام
                ]);
            }
        }

        session()->flash('success', 'تم إضافة الشهادة بنجاح!');
        $this->resetForm();
        $this->loadCertificates();
    }

    public function updateCertificate()
    {
        $this->validate([
            'name' => 'required|string|max:200',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'selectedForms' => 'array',
        ]);

        $certificate = Certificate::findOrFail($this->certificateId);

        if ($this->img) {
            // رفع الصورة الجديدة إلى المسار المحدد
            $imgPath = $this->img->store('uploads/templates', 'public');
            $certificate->update([
                'name' => $this->name,
                'img' => $imgPath,
            ]);
        } else {
            $certificate->update([
                'name' => $this->name,
            ]);
        }

        // حذف الاختبارات المرتبطة السابقة
        CountExampSuccess::where('cr_certificates_id', $this->certificateId)->delete();

        // حفظ الاختبارات المرتبطة الجديدة
        if (!empty($this->selectedForms)) {
            foreach ($this->selectedForms as $formId) {
                CountExampSuccess::create([
                    'cr_certificates_id' => $this->certificateId,
                    'forms_id' => $formId,
                    'users_id' => auth()->id(),
                    'form_type' => 'form',
                ]);
            }
        }

        // حفظ النماذج العامة المرتبطة الجديدة
        if (!empty($this->selectedGfForms)) {
            foreach ($this->selectedGfForms as $gfFormId) {
                CountExampSuccess::create([
                    'cr_certificates_id' => $this->certificateId,
                    'forms_id' => $gfFormId,
                    'users_id' => auth()->id(),
                    'form_type' => 'gf_form',
                ]);
            }
        }

        session()->flash('success', 'تم تحديث الشهادة بنجاح!');
        $this->resetForm();
        $this->loadCertificates();
    }


    public function editCertificate($id)
    {
        $certificate = Certificate::findOrFail($id);
        $this->certificateId = $certificate->id;
        $this->name = $certificate->name;
        $this->img = null;
        $this->isEditMode = true;

        // تحميل الاختبارات المرتبطة بالشهادة
        $relatedForms = CountExampSuccess::where('cr_certificates_id', $id)
            ->where('form_type', 'form')
            ->pluck('forms_id')->toArray();
        $this->selectedForms = $relatedForms;

        // تحميل النماذج العامة المرتبطة بالشهادة
        $relatedGfForms = CountExampSuccess::where('cr_certificates_id', $id)
            ->where('form_type', 'gf_form')
            ->pluck('forms_id')->toArray();
        $this->selectedGfForms = $relatedGfForms;
    }



    public function deleteCertificate($id)
    {
        $certificate = Certificate::findOrFail($id);

        // حذف الاختبارات المرتبطة بالشهادة
        CountExampSuccess::where('cr_certificates_id', $id)->delete();

        $certificate->delete();

        session()->flash('success', 'تم حذف الشهادة بنجاح!');
        $this->loadCertificates();
    }

    public function resetForm()
    {
        $this->name = '';
        $this->img = null;
        $this->certificateId = null;
        $this->selectedForms = [];
        $this->selectedGfForms = [];
        $this->isEditMode = false;
    }

    public function render()
    {
        return view('livewire.certificates.index');
    }
}
