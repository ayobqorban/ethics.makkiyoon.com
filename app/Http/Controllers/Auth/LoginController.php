<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    public function login(){
        return view('auth.login');
    }




    public function check_phone(Request $request) {
        // تحقق مخصص مع عرض رسالة خطأ
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|numeric|exists:users,mobile',
        ], [
            'mobile.required' => 'رقم الجوال مطلوب.',
            'mobile.numeric' => 'يجب أن يحتوي رقم الجوال على أرقام فقط.',
            'mobile.exists' => 'عذرًا، هذا الرقم غير مسجل لدينا.',
        ]);

        // فحص التحقق
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'فشل التحقق من الرقم، يرجى المحاولة مرة أخرى.');
        }

        try {
            // توليد كود OTP
            $otp = random_int(1000, 9999);
            session(['otp' => $otp, 'mobile' => $request->mobile]);

            // إرسال الرسالة عبر WhatsApp
            $msg = "رمز التحقق لدخول بوابة ميثاق مكيون الأخلاقي هو: $otp";
            send_whatsapp($request->mobile, $msg);

            return redirect()->route('otp_form')
                ->with('success', 'تم إرسال رمز التحقق بنجاح. يرجى التحقق من الرسائل.');
        } catch (\Exception $e) {
            // في حالة حدوث مشكلة غير متوقعة
            return redirect()->back()
                ->with('error', 'حدث خطأ أثناء معالجة طلبك، يرجى المحاولة لاحقًا.');
        }
    }


public function otp_form() {
    if (!session('mobile')) {
        return redirect()->route('login')->withErrors('يرجى إعادة محاولة لتسجيل الدخول');
    }
    return view('auth.otp');
}


    public function otp_check(Request $request){
        $request->validate([
            'otp' => 'required|numeric',
        ]);

        if ($request->otp == session('otp')) {
            // تسجيل الدخول بناءً على رقم الجوال
            $user = User::where('mobile', session('mobile'))->first();
            Auth::login($user);

            // تنظيف الجلسة
            session()->forget(['otp', 'mobile']);
            if(Auth::user()->is_admin){
                return redirect('/');
            }
            return redirect('/');
        } else {
            return back()->withErrors(['otp' => 'خطأ في كود التحقق.']);
        }
    }
}
