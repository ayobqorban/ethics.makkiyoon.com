<?php

namespace App\Livewire\Users;
use Illuminate\Validation\Rule;

use App\Models\User;
use Livewire\Component;

class Index extends Component
{
    public $name;
    public $mail;
    public $mobile;
    public $isEditMode = false;
    public $formId;
    public $is_admin;
    public $check_role;

    public function mount($type){

        $this->is_admin = $type == 'admin'? '1':'0';
        $this->check_role = $type;

    }

        // قواعد التحقق
        protected $rules = [
            'name' => 'required|string|min:5',
            'mail' => 'required|string|email|unique:users,mail',
            'mobile' => 'required|string|min:5|unique:users,mobile',
        ];

         // رسائل التحقق المخصصة
         protected $messages = [
            'name.required' => 'يرجى إدخال الاسم',
            'mail.required' => 'يرجى إدخال البريد الإلكتروني',
            'mail.email' => 'يجب أن يكون البريد الإلكتروني صالحاً',
            'mail.unique' => 'هذا البريد الإلكتروني مسجل بالفعل',
            'mobile.required' => 'يرجى إدخال رقم الجوال',
            'mobile.unique' => 'رقم الجوال هذا مسجل بالفعل',
        ];


        public function addForm()
        {
            // تحديث قواعد التحقق لحالة التعديل
            $this->rules['mail'] = [
                'required',
                'string',
                'email',
                Rule::unique('users', 'mail')->ignore($this->formId),
            ];
            $this->rules['mobile'] = [
                'required',
                'string',
                'min:5',
                Rule::unique('users', 'mobile')->ignore($this->formId),
            ];

            // تحقق من البيانات
            $this->validate();

            if ($this->isEditMode && $this->formId) {
                // تعديل النموذج الحالي
                $form = User::find($this->formId);
                if ($form) {
                    $form->update([
                        'name' => $this->name,
                        'mail' => $this->mail,
                        'mobile' => $this->mobile,
                        'is_admin' => $this->is_admin,
                    ]);
                }
            } else {
                // إضافة نموذج جديد
                User::create([
                    'name' => $this->name,
                    'mail' => $this->mail,
                    'mobile' => $this->mobile,
                    'is_admin' => $this->is_admin,
                ]);
            }

            // إعادة ضبط الحقول بعد الإضافة أو التحديث
            $this->resetForm();
        }



    public function editForm($id)
    {
        $form = User::find($id);
        if ($form) {
            $this->formId = $form->id;
            $this->name = $form->name;
            $this->mail = $form->mail;
            $this->mobile = $form->mobile;
            $this->isEditMode = true;
        }
    }

    public function deleteForm($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
        }
    }

    public function toggleFixed($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->is_admin = !$user->is_admin; // تغيير القيمة إلى عكسها
            $user->role = $user->role == 'admin' ? 'member':'admin'; // تغيير القيمة إلى عكسها
            $user->save(); // حفظ التغيير
        }
    }

    public function resetForm()
    {
        $this->name = '';
        $this->mail = '';
        $this->mobile = '';
        $this->isEditMode = false;
        $this->formId = null;
    }


    public function render()
    {
        $users = User::where('role',$this->check_role)->get();

        return view('livewire.users.index',compact('users'));
    }
}
