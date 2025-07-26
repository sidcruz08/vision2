@extends('layouts.app')

@section('content')
    <h1>Edit Patient</h1>
    
    <form method="POST" action="{{ route('patients.update', $patient) }}">
        @csrf
        @method('PUT')
        @include('patients.form')
    </form>
@endsection
