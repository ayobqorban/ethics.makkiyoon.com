@extends('layouts.main')
@section('content')
    @livewire('Results.ResultShow',['id'=>$id])
@endsection
