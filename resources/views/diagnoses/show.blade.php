@extends('layouts.app')
@section('content')
    <h1>Diagnosis Details</h1>
    <ul class="list-group">
        <li class="list-group-item"><strong>Patient:</strong> {{ $diagnosis->visit->patient->first_name }} {{ $diagnosis->visit->patient->last_name }}</li>
        <li class="list-group-item"><strong>Visit Date:</strong> {{ $diagnosis->visit->visit_date }}</li>
        <li class="list-group-item"><strong>Code:</strong> {{ $diagnosis->diagnosis_code }}</li>
        <li class="list-group-item"><strong>Description:</strong> {{ $diagnosis->description }}</li>
    </ul>
    <a href="{{ route('diagnoses.index') }}" class="btn btn-secondary mt-3">Back to Diagnoses</a>
@endsection

// resources/views/diagnoses/form.blade.php
<div class="mb-3">
    <label for="visit_id" class="form-label">Visit</label>
    <select name="visit_id" class="form-select" required>
        <option value="">Select Visit</option>
        @foreach($visits as $visit)
            <option value="{{ $visit->id }}" {{ old('visit_id', $diagnosis->visit_id ?? '') == $visit->id ? 'selected' : '' }}>
                {{ $visit->patient->first_name }} {{ $visit->patient->last_name }} - {{ $visit->visit_date }}
            </option>
        @endforeach
    </select>
</div>
<div class="mb-3">
    <label for="diagnosis_code" class="form-label">Diagnosis Code</label>
    <input type="text" name="diagnosis_code" class="form-control" value="{{ old('diagnosis_code', $diagnosis->diagnosis_code ?? '') }}" required>
</div>
<div class="mb-3">
    <label for="description" class="form-label">Description</label>
    <textarea name="description" class="form-control">{{ old('description', $diagnosis->description ?? '') }}</textarea>
</div>
<button type="submit" class="btn btn-primary">{{ isset($diagnosis) ? 'Update' : 'Create' }} Diagnosis</button>
