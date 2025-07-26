@extends('layouts.app')

@section('content')
<h2>Edit Claim</h2>
<form action="{{ route('claims.update', $claim->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <label>Visit ID:</label>
    <input type="number" name="visit_id" value="{{ $claim->visit_id }}" required><br>

    <label>Patient ID:</label>
    <input type="number" name="patient_id" value="{{ $claim->patient_id }}" required><br>

    <label>Claim Number:</label>
    <input type="text" name="claim_number" value="{{ $claim->claim_number }}" required><br>

    <label>Claim Date:</label>
    <input type="date" name="claim_date" value="{{ $claim->claim_date }}" required><br>

    <label>Claim Amount:</label>
    <input type="number" step="0.01" name="claim_amount" value="{{ $claim->claim_amount }}" required><br>

    <label>Status:</label>
    <select name="status" required>
        <option {{ $claim->status == 'Pending' ? 'selected' : '' }}>Pending</option>
        <option {{ $claim->status == 'Approved' ? 'selected' : '' }}>Approved</option>
        <option {{ $claim->status == 'Rejected' ? 'selected' : '' }}>Rejected</option>
        <option {{ $claim->status == 'Partially Approved' ? 'selected' : '' }}>Partially Approved</option>
        <option {{ $claim->status == 'Paid' ? 'selected' : '' }}>Paid</option>
    </select><br>

    <label>Remarks:</label>
    <textarea name="remarks">{{ $claim->remarks }}</textarea><br>

    <label>Upload Additional Documents:</label>
    <input type="file" name="documents[]" multiple><br>

    <button type="submit">Update</button>
</form>
@endsection