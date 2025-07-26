@extends('layouts.app')
@section('content')
    <h1>Visit Details</h1>
    <ul class="list-group">
        <li class="list-group-item"><strong>Patient:</strong> {{ $visit->patient->first_name }} {{ $visit->patient->last_name }}</li>
        <li class="list-group-item"><strong>Date:</strong> {{ $visit->visit_date }}</li>
        <li class="list-group-item"><strong>Type:</strong> {{ $visit->visit_type }}</li>
        <li class="list-group-item"><strong>Reason:</strong> {{ $visit->reason }}</li>
        <li class="list-group-item"><strong>Doctor:</strong> {{ $visit->doctor_name }}</li>
        <li class="list-group-item"><strong>Status:</strong> {{ $visit->status }}</li>
    </ul>
    <a href="{{ route('visits.index') }}" class="btn btn-secondary mt-3">Back to Visits</a>
@endsection