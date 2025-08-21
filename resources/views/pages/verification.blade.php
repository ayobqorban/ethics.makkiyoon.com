@extends('layouts.main_login')
@section('content')
<div class="card">
<div class="card-body">

    @if($status == 'success')
    <!-- Logo -->
    <div class=" justify-content-center text-center">
    <img class="img-fluid p-3" width="150" src="{{asset('/assets/img/5972778.png')}}" alt="">
    </div>
    <div class="text-center">
        <h4 class="text-success">هذه الشهادة موثوقة ومعتمدة</h4>
        <h4 class="text-primary">اسم المستفيد: {{$name}}</h4>
        <h3 class="text-primary">{{$code}}</h3>
    </div>
    @else
    <!-- Logo -->
    <div class=" justify-content-center text-center">
    <img class="img-fluid p-3" width="150" src="{{asset('/assets/img/7068033.png')}}" alt="">
    </div>
    <div class="text-center">
        <h4 class="text-danger">هذه الشهادة غير مسجلة في سجلاتنا</h4>
        <h5 class="text-danger">This certificate is not registered in our records.</h5>
    </div>
    @endif
</div>
</div>
@endsection
