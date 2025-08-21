@extends('layouts.main')
@section('content')

    @if($errors->any())
    @foreach ($errors->all() as $error)
        <div class="alert alert-danger">{{$error}}</div>
    @endforeach
    @endif
    @if(session('success'))
<div class="alert alert-success">{{session('success')}}</div>
@endif
    <div class="card mb-4">
        <h5 class="card-header">تعديل الحساب</h5>
        <form class="card-body" action="/users/{{$user->id}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="row g-3">
                <!-- الاسم الثلاثي -->
                <div class="col-md-3">
                    <label class="form-label" for="name">الاسم الثلاثي</label>
                    <input type="text" name="name" value="{{$user->name}}" class="form-control" id="name" required>
                </div>
                <!-- رقم الجوال -->
                <div class="col-md-3">
                    <label class="form-label" for="mobile">رقم الجوال</label>
                    <input type="text" value="{{$user->mobile}}" name="mobile" class="form-control" id="mobile" required>
                    <small id="mobile_counter" class="text-muted">0/14</small>
                </div>
                <!-- رقم الهوية -->
                <div class="col-md-3">
                    <label class="form-label" for="national_id">البريد الالكتروني</label>
                    <input type="mail" value="{{$user->mail}}" name="mail" class="form-control"  required>
                 </div>
                @if(auth()->user()->role === 'admin')
                <div class="col-md-3">
                    <label class="form-label" for="multicol-last-mobile">الصلاحية</label>
                    <select name="role" class="form-control" id="">
                        <option value="member" selected>عضو الجمعية</option>
                        <option value="admin">المدير العام</option>
                    </select>
                </div>
                @endif
                <div class="col-md-12">
                    <label class="form-label" for="image">الصورة</label>
                    <input type="file" name="image" class="form-control" id="image">
                </div>
            </div>

            <div class="pt-4">
                <input type="submit" value="تحديث الحساب" class="btn btn-primary me-sm-3 me-1" id="submit-btn" disabled>
            </div>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            // تفعيل الزر بناءً على صحة البيانات
            function toggleSubmitButton() {
                var name = $('#name').val().trim();
                 var mobile = $('#mobile').val();

                var isValidName = name !== '';
                 var isValidMobile = mobile.length >= 10 && mobile.length <= 14;

                if (isValidName && isValidMobile) {
                    $('#submit-btn').prop('disabled', false);
                } else {
                    $('#submit-btn').prop('disabled', true);
                }
            }

            // التحقق من إدخال الأرقام فقط
            $('#mobile').on('input', function() {
                var value = $(this).val().replace(/\D/g, ''); // إزالة أي شيء غير الأرقام
                $(this).val(value);

             if ($(this).attr('id') === 'mobile') {
                    $('#mobile_counter').text(value.length + '/14');
                    if (value.length > 14) {
                        $(this).val(value.substring(0, 14)); // قطع الأرقام الزائدة
                    }
                }

                toggleSubmitButton(); // تحديث حالة الزر
            });

            // التحقق من صحة الاسم
            $('#name').on('input', function() {
                toggleSubmitButton(); // تحديث حالة الزر
            });

            // منع إرسال النموذج إذا كانت الشروط غير محققة
            $('form').on('submit', function(e) {
                var mobile = $('#mobile').val();

                if ( mobile.length < 10 || mobile.length > 14) {
                    alert('تأكد أن رقم الجوال بين 10 و 14 رقمًا.');
                    e.preventDefault(); // منع إرسال النموذج
                }
            });

            // تحديث عدادات النصوص عند تحميل الصفحة

            $('#mobile_counter').text($('#mobile').val().length + '/14');

            // التحقق من صحة المدخلات عند تحميل الصفحة
            toggleSubmitButton();
        });
    </script>
@endsection
