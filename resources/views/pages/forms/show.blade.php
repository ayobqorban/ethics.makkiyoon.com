@extends('layouts.main')
@section('content')
@livewire('Forms.ShowForm',['id'=>$form->id])
@endsection
