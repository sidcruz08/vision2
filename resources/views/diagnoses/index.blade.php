@extends('layouts.app')
@section('content')
    <h1>Diagnoses</h1>
    <a href="{{ route('diagnoses.create') }}" class="btn btn-primary mb-3">Add Diagnosis</a>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Patient</th>
                <th>Visit Date</th>
                <th>Code</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($diagnoses as $diag)
            <tr>
                <td>{{ $diag->visit->patient->first_name }} {{ $diag->visit->patient->last_name }}</td>
                <td>{{ $diag->visit->visit_date }}</td>
                <td>{{ $diag->diagnosis_code }}</td>
                <td>{{ $diag->description }}</td>
                <td>
                    <a href="{{ route('diagnoses.show', $diag) }}" class="btn btn-info btn-sm">View</a>
                    <a href="{{ route('diagnoses.edit', $diag) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('diagnoses.destroy', $diag) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this diagnosis?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection