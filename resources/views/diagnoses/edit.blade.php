@extends('layouts.app')
@section('content')
    <h1>Edit Diagnosis</h1>
    <form method="POST" action="{{ route('diagnoses.update', $diagnosis) }}">
        @csrf
        @method('PUT')
        @include('diagnoses.form')
    </form>
@endsection