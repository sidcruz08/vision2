@extends('layouts.app')

@section('content')
<h2>Claims List</h2>
<a href="{{ route('claims.create') }}" class="btn btn-primary">Add New Claim</a>
<table class="table mt-3">
    <thead>
        <tr>
            <th>ID</th>
            <th>Patient</th>
            <th>Claim Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($claims as $claim)
            <tr>
                <td>{{ $claim->id }}</td>
                <td>{{ $claim->patient->name }}</td>
                <td>{{ $claim->claim_date }}</td>
                <td>
                    <a href="{{ route('claims.show', $claim) }}" class="btn btn-info btn-sm">View</a>
                    <a href="{{ route('claims.edit', $claim) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('claims.destroy', $claim) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Delete claim?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection