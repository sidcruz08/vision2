@extends('layouts.app')
@section('content')
    <h1>Create Diagnosis</h1>
    <form method="POST" action="{{ route('diagnoses.store') }}">
        @csrf
        @include('diagnoses.form')
    </form>
@endsection