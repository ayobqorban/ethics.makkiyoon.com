<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    $request->validate([
        'mobile' => 'required|numeric|exists:users,mobile',
    ]);

    $otp = random_int(1000, 9999); // توليد كود OTP أكثر أمانا
    session(['otp' => $otp, 'mobile' => $request->mobile]);
    $msg ="رمز التحقق لدخول بوابة ميثاق مكيون الأخلاقي هو: $otp";
    send_whatsapp($request->mobile,$msg);
    return redirect()->route('otp_form');
}

public function otp_form() {
    if (!session('mobile')) {
        return redirect()->route('login')->withErrors('يرجى إعادة محاولة لتسجيل الدخول');
    }
    return view('auth.otp');
}


    public function otp_check(Request $request){
        dd('test');
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
                return redirect()->route('votes.index');
            }
            return redirect()->route('member.home');
        } else {
            return back()->withErrors(['otp' => 'خطأ في كود التحقق.']);
        }
    }
}
