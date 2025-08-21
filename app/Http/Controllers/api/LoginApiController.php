<?php
namespace App\Http\Controllers\api;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\Otp;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginApiController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */

    /**
     * Create a new controller instance.
     *
     * @return void
     */


     public function checkidnational(Request $request) {
        // التحقق من صحة المدخلات
        $validatedData = $request->validate([
            'idnational' => 'required|exists:users,national_id',
        ]);

        // البحث عن المستخدم بناءً على رقم الهوية
        $user = User::where('national_id', $validatedData['idnational'])->firstOrFail();

        // توليد رمز OTP
        $otp = random_int(1000, 9999);

        // تخزين رمز OTP في قاعدة البيانات
        Otp::create([
            'user_id' => $user->id,  // الحصول على معرف المستخدم من جدول users
            'mobile' => $user->mobile,
            'otp_code' => $otp,
            'expires_at' => now()->addMinutes(10), // صلاحية الكود لمدة 10 دقائق
        ]);

        // إرسال OTP عبر WhatsApp
        $msg = "رمز التحقق لدخول بوابة ميثاق مكيون الأخلاقي هو: $otp";

        try {
            send_whatsapp($user->mobile, $msg);
        } catch (\Exception $e) {
            // التعامل مع أي خطأ يحدث أثناء إرسال الرسالة
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء إرسال رمز التحقق عبر WhatsApp',
                'error' => $e->getMessage(),
            ], 500);
        }

        // رد النجاح
        return response()->json([
            'success' => true,
            'message' => 'تم إرسال رمز التحقق عبر WhatsApp بنجاح',
        ], 200);
    }






public function otp_check(Request $request)
{
    // التحقق من صحة البيانات المدخلة
    $request->validate([
        'otp_code' => 'required|numeric|digits:4',
    ]);

    // البحث عن السجل المطابق لرمز OTP فقط
    $otpRecord = Otp::where('otp_code', $request->otp_code)
                    ->where('expires_at', '>=', now()) // التحقق من عدم انتهاء صلاحية الرمز
                    ->first();

    if (!$otpRecord) {
        return response()->json(['error' => 'رمز التحقق غير صحيح أو منتهي الصلاحية'], 401);
    }

    // إذا كان الرمز صحيحًا، يتم جلب المستخدم المرتبط
    $user = User::find($otpRecord->user_id);

    if (!$user) {
            return response()->json(['error' => 'المستخدم غير موجود'], 404);
        }

        // إنشاء توكن JWT للمستخدم
        $token = JWTAuth::fromUser($user);

    // حذف سجل OTP بعد الاستخدام
    $otpRecord->delete();

    // إعادة التوكن في الاستجابة
    return response()->json([
        'access_token' => $token,
        'token_type' => 'bearer',
        'expires_in' => config('jwt.ttl') * 60,
        'user' => $user, // يمكنك إرجاع معلومات المستخدم هنا إذا أردت
    ],200);
}
}
