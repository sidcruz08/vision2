@extends('layouts.app')
@section('content')
    <h1>Create Visit</h1>
    <form method="POST" action="{{ route('visits.store') }}">
        @csrf
        @include('visits.form')
    </form>
@endsection