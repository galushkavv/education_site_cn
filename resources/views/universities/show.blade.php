@extends('layout')

@section('content')

    <h2 class="mb-4">{{ $university->name }}</h2>
    <p class="mb-3">{!! $university->article !!}</p>

@endsection
