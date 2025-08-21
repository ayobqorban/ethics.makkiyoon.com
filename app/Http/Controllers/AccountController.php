<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function user_list($type)
    {
          return view('pages.users.index',compact('type'));
    }

    // public function index($type)
    // {
    //     $member = $type == 'members' ? 0 : 1;
    //     $users = User::where('is_admin', $member)->get();
    //     return view('users.index', compact(['users'], 'member'));
    // }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // التحقق من البيانات
        $data = $request->validate([
            'name' => 'required',
            'mail' => 'required',
            'mobile' => 'required|unique:users,mobile',
            'password' => 'nullable',
            'role' => 'required',
            'image' => 'nullable|mimes:jpeg,jpg,png',
        ], [
            'name.required' => 'يجب كتابة الاسم الثلاثي',
            'national_id.required' => 'يجب إدخال رقم الهوية',
            'mobile.unique' => 'هذا الجوال موجود بالفعل',
            'national_id.unique' => 'رقم الهوية هذا مسجل بالفعل', // رسالة الخطأ عند التكرار
            'image.mimes' => 'يجب أن تكون صيغة الصورة jpeg,jpg,png',
        ]);

        // إذا كان حقل كلمة المرور موجودًا، يتم تشفيرها
        if ($request->has('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // رفع الصورة إذا كانت موجودة
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('users');
            $data['image'] = $path;
        }

        // إنشاء مستخدم جديد
        if ($data) {
            User::create($data);
            return redirect()->back()->with('success', 'تم إضافة الحساب بنجاح');
        } else {
            return redirect()->back()->with(['error' => 'حدث خطأ أثناء إضافة الحساب.']);
        }


        // إعادة التوجيه مع رسالة النجاح
    }




    /**
     * Show the form for editing the specified resource.
     */

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('users.show', compact('user'));
    }

    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = request()->validate([
            'name' => 'required',
            'role' => 'required',
            'mail' => 'required',
            'mobile' => 'nullable|unique:users,mobile,' . $id,
            'password' => 'nullable|min:6',
            'image' => 'nullable|mimes:jpeg,jpg,png',
        ], [
            'name.required' => 'يجب كتابة الاسم الثلاثي',
            'national_id.required' => 'يجب إدخال رقم الهوية',
            'national_id.unique' => 'رقم الهوية مسجل بالفعل',
            'mobile.unique' => 'هذا الجوال موجود بالفعل',
            'password.min' => 'يجب أن تكون كلمة المرور أكثر من 6 أحرف',
            'image.mimes' => 'يجب أن تكون صيغة الصورة jpeg أو jpg أو png',
        ]);

        if (request()->has('password') && !empty(request('password'))) {
            $data['password'] = Hash::make(request('password'));
        } else {
            unset($data['password']);  // لا تقم بتحديث الرقم السري إذا كان الحقل فارغًا
        }

        if (request()->hasFile('image')) {
            $path = request('image')->store('users');
            $data['image'] = $path;
        }

        User::findOrFail($id)->update($data);
        return redirect()->back()->with('success', 'تم تحديث الحساب بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        if ($user->votes()->exists()) {
            return redirect()->back()->with('error', 'لا يمكن حذف المستخدم لأنه لديه مشاركات مرتبطة.');
        }
        $user->delete();
        return redirect()->back()->with('success', 'تم حذف المستخدم بنجاح.');
    }
}
