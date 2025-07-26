@extends('layouts.app')

@section('content')
    <h1>Treatment Details</h1>
    <p><strong>Patient:</strong> {{ $treatment->diagnosis->visit->patient->full_name }}</p>
    <p><strong>Diagnosis:</strong> {{ $treatment->diagnosis->diagnosis_code }}</p>
    <p><strong>Type:</strong> {{ $treatment->treatment_type }}</p>
    <p><strong>Notes:</strong> {{ $treatment->notes }}</p>
    <a href="{{ route('treatments.index') }}">Back to list</a>
@endsection
