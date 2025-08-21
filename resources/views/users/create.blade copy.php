@extends('layouts.main')
@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{session('success')}}</div>
    @endif
    <div class="card mb-4">
        <h5 class="card-header">إضافة حساب</h5>
        <form class="card-body" action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label" for="multicol-last-name">الاسم الثلاثي</label>
                    <input type="text" name="name" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="multicol-last-national_id">رقم الهوية</label>
                    <input type="text"  name="national_id" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="multicol-last-name">رقم الجوال</label>
                    <input type="text" name="mobile" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="multicol-last-name">الصورة</label>
                    <input type="file" name="image" class="form-control">
                </div>
            </div>




            <div class="pt-4">
                <input type="submit" value="إضافة الحساب"  class="btn btn-primary me-sm-3 me-1">
            </div>


        </form>




    </div>

    <script>
        $(document).ready(function() {
            $('input[name="national_id"]').on('input', function() {
                var value = $(this).val();

                // إزالة أي شيء غير الأرقام
                value = value.replace(/\D/g, '');

                // إذا كان الطول أكبر من 10، قم بقطع الباقي
                if (value.length > 10) {
                    value = value.substring(0, 10);
                }

                // تحديث قيمة الحقل
                $(this).val(value);
            });

            // منع إرسال النموذج إذا كان الطول ليس 10
            $('form').on('submit', function(e) {
                var nationalId = $('input[name="national_id"]').val();
                if (nationalId.length !== 10) {
                    alert('يجب أن يحتوي رقم الهوية على 10 أرقام.');
                    e.preventDefault(); // منع إرسال النموذج
                }
            });
        });
        </script>

@endsection
