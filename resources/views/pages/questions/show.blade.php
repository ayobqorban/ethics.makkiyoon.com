@extends('layouts.main')
@section('content')
<h5>السؤال: {{$question->title}}</h5>
@livewire('Options.index', ['id' => $question->id])
@endsection
