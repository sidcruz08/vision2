@extends('layouts.app')

@section('content')
    <h1>Patients</h1>
    
    <a href="{{ route('patients.create') }}" class="btn btn-primary">Add New Patient</a>

    @if(session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
    @endif

    <table class="table mt-3">
        <thead>
            <tr>
                <th>Patient Code</th>
                <th>Name</th>
                <th>Gender</th>
                <th>Birthdate</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($patients as $patient)
                <tr>
                    <td>{{ $patient->patient_code }}</td>
                    <td>{{ $patient->first_name }} {{ $patient->last_name }}</td>
                    <td>{{ $patient->gender }}</td>
                    <td>{{ $patient->birthdate }}</td>
                    <td>
                        <a href="{{ route('patients.edit', $patient) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('patients.destroy', $patient) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
