
<!-- @extends('layouts.app')

@section('content')
<h2>Create Claim</h2>
<form action="{{ route('claims.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="number" name="visit_id" required value="{{$patient->id}}" hidden><br>
    <input type="number" name="patient_id" required value="{{$patient->patient_id}}" hidden><br>
    <input type="text" name="claim_number" required placeholder="Claim Number">
    <input type="date" name="claim_date" required>
    <input type="number" name="claim_amount" step="0.01" required placeholder="Amount">
    <select name="status" required>
        <option value="Pending">Pending</option>
        <option value="Approved">Approved</option>
        <option value="Rejected">Rejected</option>
        <option value="Partially Approved">Partially Approved</option>
        <option value="Paid">Paid</option>
    </select>
    <input type="file" name="documents[]" multiple required>
    <button type="submit">Submit</button>
</form>
@endsection --> 
<!DOCTYPE html>
<html>
<head>
    <title>Submit Claim</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    
@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
        @if(session('claim_id'))
            <p>Claim ID: {{ session('claim_id') }}</p>
        @endif
    </div>
@endif
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Submit HD Claim</h1>
        
        <form action="{{ route('claims.store') }}" method="POST" enctype="multipart/form-data" class="max-w-md">
            @csrf
            
            <div class="mb-4">
                <label for="patient_id" class="block mb-2">Patient ID</label>
                <input type="text" name="patient_id" id="patient_id" required
                       class="w-full px-3 py-2 border rounded">
            </div>
            
            <div class="mb-4">
                <label class="block mb-2">Documents (Exactly 2 pages total)</label>
                <input type="file" name="documents[]" multiple
                       class="w-full px-3 py-2 border rounded"
                       accept=".pdf,.jpg,.png">
                @error('documents')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
                Submit Claim
            </button>
        </form>
    </div>
</body>
</html>