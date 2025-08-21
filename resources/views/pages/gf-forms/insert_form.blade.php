@extends('layouts.main')
@section('content')
 @livewire('GfForms.InsertForm',['gfFormId'=>$gfFormId,'examId'=>$examId])
@endsection
