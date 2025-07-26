{{-- index.blade.php --}}
@extends('layouts.app')
@section('content')
<h2>All Treatments</h2>
<a href="{{ route('treatments.create') }}" class="btn btn-success mb-2">Add New Treatment</a>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Diagnosis Code</th>
            <th>Patient</th>
            <th>Treatment Type</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($treatments as $treatment)
        <tr>
            <td>{{ $treatment->diagnosis->diagnosis_code }}</td>
            <td>{{ $treatment->diagnosis->visit->patient->name ?? 'Unknown' }}</td>
            <td>{{ $treatment->treatment_type }}</td>
            <td>
                <a href="{{ route('treatments.show', $treatment) }}" class="btn btn-info btn-sm">View</a>
                <a href="{{ route('treatments.edit', $treatment) }}" class="btn btn-primary btn-sm">Edit</a>
                <form action="{{ route('treatments.destroy', $treatment) }}" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button type="submit" onclick="return confirm('Delete this treatment?')" class="btn btn-danger btn-sm">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
