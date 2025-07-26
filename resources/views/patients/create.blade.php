@extends('layouts.app')

@section('content')
    <h1>Create Patient</h1>
    
    <form method="POST" action="{{ route('patients.store') }}">
        @csrf
        @include('patients.form')
    </form>
@endsection
