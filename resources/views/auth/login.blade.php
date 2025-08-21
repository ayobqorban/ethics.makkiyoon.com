@extends('layouts.main_login')
@section('content')
<div class="card">
<div class="card-body">
    <!-- Logo -->
    <div class=" justify-content-center text-center">
    <img class="img-fluid p-3" width="200" src="{{asset('/assets/makkiyoon_logo.png')}}" alt="">
    <img class="img-fluid p-3" width="500" src="{{asset('/assets/logo_loging.svg')}}" alt="">
    </div>

@if($errors->any())
    <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
    </div>
@endif


    <!-- /Logo -->
    <!--{{session('otp')}}-->
    <form id="formAuthentication" class="mb-3" action="{{ route('check_phone') }}" method="POST">
    @csrf
    <div class="mb-3" style="text-align: right">
        <label   class="form-label">رقم الجوال</label>
        <div class="col-12">
        <div class="input-group input-group-merge">
            <span id="basic-icon-default-phone2" class="input-group-text"><i class="bx bx-mobile"></i></span>
            <input type="text" name="mobile"  class="form-control form-control-lg fs-5" placeholder="96650.." >
        </div>
        </div>
    </div>
    {{-- <div class="mb-3">
        <div class="form-check">
        <input class="form-check-input" type="checkbox" id="remember-me" />
        <label class="form-check-label" for="remember-me"> تذكرني </label>
        </div>
    </div> --}}
    <div class="mb-3">
        <input type="submit"   class="btn btn-primary d-grid w-100"  value="تسجيل الدخول">
    </div>
    </form>
</div>
</div>
@endsection
