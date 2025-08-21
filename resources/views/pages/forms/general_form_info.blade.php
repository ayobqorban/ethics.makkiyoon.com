@extends('layouts.main')
@section('content')
<div class="card">
    <div class="card-body">
        <h4 class="card-title">{{$form->title}}</h4>
        <p class="card-text">{{$form->description}}</p>
        @livewire('CreateGeneralFormButton',['formId' => $form->id,'الدخول للاستبيان'])
      </div>
</div>
@endsection
