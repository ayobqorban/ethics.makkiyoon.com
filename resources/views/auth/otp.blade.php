@extends('layouts.main_login')
@section('content')
    <div class="card">
    <div class="card-body">
        <!-- Logo -->
        <div class=" d-flex justify-content-center ">
        <img width="220" class="img-fluid p-2" src="{{asset('/assets/whatsapp_logo.gif')}}" alt="">
        </div>
        <!-- /Logo -->
        @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!--<h4 class="mb-1 text-center">{{session('otp')}}</h4>-->
        <h4 class="mb-1 text-center">التحقق من الكود</h4>
        <p class="mb-1 text-center">تحقق من الكود المرسل إلى الواتساب الخاص بك</p>
        <form id="twoStepsForm" action="{{ route('otp_check') }}" method="POST" class="fv-plugins-bootstrap5 fv-plugins-framework" novalidate="novalidate">
        @csrf
        <div class="mb-4 fv-plugins-icon-container">
            <div dir="ltr" class="auth-input-wrapper d-flex justify-content-center numeral-mask-wrapper">
                <input type="tel" class="form-control auth-input h-px-50 text-center numeral-mask mx-sm-1 mt-2 m-2" maxlength="1" autofocus="" oninput="moveToNext(this, 'otp2')" id="otp1">
                <input type="tel" class="form-control auth-input h-px-50 text-center numeral-mask mx-sm-1 mt-2 m-2" maxlength="1" oninput="moveToNext(this, 'otp3')" id="otp2">
                <input type="tel" class="form-control auth-input h-px-50 text-center numeral-mask mx-sm-1 mt-2 m-2" maxlength="1" oninput="moveToNext(this, 'otp4')" id="otp3">
                <input type="tel" class="form-control auth-input h-px-50 text-center numeral-mask mx-sm-1 mt-2 m-2" maxlength="1" oninput="moveToNext(this, null)" id="otp4">
            </div>
            <!-- Create a hidden field which is combined by 4 fields above -->
            <input type="hidden" name="otp" id="otp">
        <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
        <button class="btn btn-primary d-grid w-100 mb-6">
            تسجيل الدخول
        </button>
        <div class="text-center mt-1">لم يصل إليك الكود حتى الآن؟
            <a href="javascript:void(0);">
            أعد إرسال الكود
            </a>
        </div>
    </form>

    </div>
    </div>
    <script>
        function moveToNext(currentInput, nextInputId) {
            if (currentInput.value.length >= currentInput.maxLength) {
                if (nextInputId) {
                    document.getElementById(nextInputId).focus();
                } else {
                    document.getElementById('otp').value = document.getElementById('otp1').value +
                                                           document.getElementById('otp2').value +
                                                           document.getElementById('otp3').value +
                                                           document.getElementById('otp4').value;
                }
            }
        }

        document.getElementById('twoStepsForm').addEventListener('submit', function() {
            document.getElementById('otp').value = document.getElementById('otp1').value +
                                                   document.getElementById('otp2').value +
                                                   document.getElementById('otp3').value +
                                                   document.getElementById('otp4').value;
        });
    </script>
@endsection
