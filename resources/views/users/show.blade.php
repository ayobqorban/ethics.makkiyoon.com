@extends('layouts.main')
@section('content')
<h5 class="py-1 "><span class="text-muted fw-light"><a href="{{url()->previous()}}">المستخدمين</a> /</span> {{$user->name}}</h5>
    @if(session('success'))
    <div class="alert alert-success alert-dismissible" role="alert">
        {{session('success')}}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif
    @if($user->trash)
     <div class="alert alert-danger d-flex" role="alert">
        <span class="badge badge-center rounded-pill bg-danger border-label-danger p-3 me-2"><i class="bx bx-store fs-6"></i></span>
        <div class="d-flex flex-column ps-1">
          <h6 class="alert-heading d-flex align-items-center mb-1">تنبيه!!</h6>
          <span>هذا الحساب محذوف ولا يمكن استخدامه حتى يتم استرجاعه</span>
        </div>
      </div>
    @endif
    <div class="nav-align-top mb-4">
        <div class="tab-content">
            <div class="tab-pane fade active show" id="navs-justified-home" role="tabpanel">
                <div class="d-flex justify-content-between align-items-start card-widget-1   pb-3 pb-sm-0">
                    <div>
                        <h5 class="mb-1">تفاصيل الحساب</h5>
                    </div>
                    <div>
                        @if(!$user->trash)
                        <span class="badge bg-label-secondary rounded p-1 me-sm-4">
                            <a href="/users/{{$user->id}}/edit"><i class="bx bx-edit "></i></a>
                        </span>
                        @endif

                    </div>
                </div>
                <hr>
                <div class="d-flex flex-wrap">
                    <div class="me-5">
                        <p class="text-nowrap"><i class="bx bx-user bx-sm me-2"></i>الاسم : {{$user->name}}</p>
                        <p class="text-nowrap">
                            <i class="bx bx-mobile-alt bx-sm me-2"></i>الجوال: {{$user->mobile}}</p>
                        <p class="text-nowrap">
                            <i class="bx bx-id-card bx-sm me-2"></i>الهوية: {{$user->national_id}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>






@endsection



