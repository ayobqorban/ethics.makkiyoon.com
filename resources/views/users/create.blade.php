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
        <h5 class="card-header">إضافة حساب</h5>
        <form class="card-body" action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label" for="multicol-last-name">الاسم الثلاثي</label>
                    <input type="text" name="name" class="form-control" id="name" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label" for="multicol-last-national_id">البريد الالكتروني</label>
                    <input type="mail" name="mail" class="form-control"  required>
                </div>
                <div class="col-md-3">
                    <label class="form-label" for="multicol-last-mobile">رقم الجوال</label>
                    <input type="text" name="mobile" class="form-control" id="mobile" required>
                    <small id="mobile_counter" class="text-muted">0/14</small>
                </div>
                @if(auth()->user()->role === 'admin')
                <div class="col-md-3">
                    <label class="form-label" for="multicol-last-mobile">الصلاحية</label>
                    <select name="role" class="form-control" id="">
                        <option value="member" selected>موظف</option>
                        <option value="admin">الإدارة</option>
                    </select>
                </div>
                @endif
                <div class="col-md-12">
                    <label class="form-label" for="multicol-last-image">الصورة</label>
                    <input type="file" name="image" class="form-control">
                </div>
            </div>

            <div class="pt-4">
                <input type="submit" value="إضافة الحساب" class="btn btn-primary me-sm-3 me-1" id="submit-btn" disabled>
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

                if (isValidName  && isValidMobile) {
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
        });
    </script>
@endsection
