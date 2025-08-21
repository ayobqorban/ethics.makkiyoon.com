<?php

namespace App\Http\Controllers;

use App\Models\Template;
use Illuminate\Http\Request;
use \Mpdf\Mpdf;

class PdfController extends Controller
{
    public function pdf(
        $name,
        $background,
        $certificateId,
        $template_id,
        $line_01,
        $line_02,
        $line_03
        )
    {
        $data = Template::findOrFail($template_id);
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

        // تهيئة الـ mPDF مع استخدام الخط الجديد
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'orientation' => 'L', // تعيين الصفحة لتكون بالعرض
            'default_font' => 'kufi',
            'margin_left' => 0, // تعيين الهوامش لتكون صفر
            'margin_right' => 0,
            'margin_top' => 0,
            'margin_bottom' => 0,
            'language' => 'arabic', // تحديد اللغة كالعربية
            'direction' => 'rtl', // تحديد الاتجاه إلى اليمين (من اليمين إلى اليسار)
            'fontDir' => $fontDir, // تحديد مسار مجلد الخطوط
            'fontdata' => $fontData // تحديد معلومات الخطوط
        ]);



        // إعداد النص باللغة العربية
        $background = public_path('storage/'.$background);
        $qrcode_path = public_path('storage/qrcode/'.$certificateId.'.svg');
        // إضافة HTML مع تعيين خلفية الصفحة وعرض الصفحة بالكامل
        $font_size_name = $data['font_size_name'];
        $margin_top_name = $data['margin_top_name'];
        $color_name = $data['color_name'];
        $margin_left_qrcode = $data['margin_left_qrcode'];
        $margin_top_qrcode = $data['margin_top_qrcode'];
        $lins = $data['lins'];



        $html = view('pdf.certificate_pdf', compact(
            'name',
            'background',
            'certificateId',
            'qrcode_path',
            'font_size_name',
            'margin_top_name',
            'color_name',
            'margin_left_qrcode',
            'margin_top_qrcode',
            'lins',
            'line_01',
            'line_02',
            'line_03',
             ))->render();

        // إضافة الـ HTML إلى الـ mPDF
        $mpdf->WriteHTML($html);



        // إنشاء ملف PDF
        $pdfPath = public_path("storage/certificates/$certificateId.pdf");

        // حفظ ملف PDF في المسار المحدد
        $mpdf->Output($pdfPath, 'F');

        // إعادة توجيه المستخدم برابط الملف
        return $pdfPath;
    }


    // خاص لمعاينة قالب الشهادة
    public function pdf_option(
        $background,
        $font_size_name,
        $margin_top_name,
        $color_name,
        $margin_left_qrcode,
        $margin_top_qrcode,
        $lins
        )
    {


        // تحديد مسار مجلد الخطوط الخاص بك
        $fontDir = public_path('storage/certificates/cairo');

        // تحديد معلومات الخطوط
        $fontData = [
            'cairo' => [
                'R' => 'Cairo-Medium.ttf',
                'B' => 'Cairo-Bold.ttf',
                'useOTL' => 0xFF,
                'useKashida' => 75,
            ]
        ];

        // تهيئة الـ mPDF مع استخدام الخط الجديد
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'orientation' => 'L', // تعيين الصفحة لتكون بالعرض
            'default_font' => 'kufi',
            'margin_left' => 0, // تعيين الهوامش لتكون صفر
            'margin_right' => 0,
            'margin_top' => 0,
            'margin_bottom' => 0,
            'language' => 'arabic', // تحديد اللغة كالعربية
            'direction' => 'rtl', // تحديد الاتجاه إلى اليمين (من اليمين إلى اليسار)
            'fontDir' => $fontDir, // تحديد مسار مجلد الخطوط
            'fontdata' => $fontData // تحديد معلومات الخطوط
        ]);

        // إعداد النص باللغة العربية
        $background = public_path('storage/'.$background);
        $qrcode_path = public_path('storage/qrcode/check_option/1012846941.svg');
        // إضافة HTML مع تعيين خلفية الصفحة وعرض الصفحة بالكامل
        $html = view('pdf.check_template_certificate_pdf', compact(
            'background',
            'qrcode_path',
            'font_size_name',
            'margin_top_name',
            'color_name',
            'margin_left_qrcode',
            'margin_top_qrcode',
            'lins'
            ))->render();

        // إضافة الـ HTML إلى الـ mPDF
        $mpdf->WriteHTML($html);

        // إنشاء ملف PDF
        $name = 'test-'.random_int(1000000000, 9999999999).'.pdf';

        return $mpdf->Output($name, 'I');
    }
}
