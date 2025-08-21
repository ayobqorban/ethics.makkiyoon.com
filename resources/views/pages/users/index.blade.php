@extends('layouts.main')
@section('content')
@livewire('users.index',['type'=>$type])
@endsection
