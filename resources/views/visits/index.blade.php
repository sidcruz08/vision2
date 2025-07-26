@extends('layouts.app')
@section('content')
    <h1>Visits</h1>
    <a href="{{ route('visits.create') }}" class="btn btn-primary mb-3">Add New Visit</a>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Patient</th>
                <th>Date</th>
                <th>Type</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($visits as $visit)
            <tr>
                <td>{{ $visit->patient->first_name }} {{ $visit->patient->last_name }}</td>
                <td>{{ $visit->visit_date }}</td>
                <td>{{ $visit->visit_type }}</td>
                <td>{{ $visit->status }}</td>
                <td>
                    <a href="{{ route('visits.show', $visit) }}" class="btn btn-info btn-sm">View</a>
                    <a href="{{ route('visits.edit', $visit) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('visits.destroy', $visit) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this visit?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection
