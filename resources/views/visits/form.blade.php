<div class="mb-3">
    <label for="patient_id" class="form-label">Patient</label>
    <select name="patient_id" class="form-select" required>
        <option value="">Select Patient</option>
        @foreach($patients as $patient)
            <option value="{{ $patient->id }}" {{ (old('patient_id', $visit->patient_id ?? '') == $patient->id) ? 'selected' : '' }}>
                {{ $patient->first_name }} {{ $patient->last_name }}
            </option>
        @endforeach
    </select>
</div>
<div class="mb-3">
    <label for="visit_date" class="form-label">Visit Date</label>
    <input type="date" name="visit_date" class="form-control" value="{{ old('visit_date', $visit->visit_date ?? '') }}" required>
</div>
<div class="mb-3">
    <label for="visit_type" class="form-label">Visit Type</label>
    <select name="visit_type" class="form-select" required>
        @foreach(['Outpatient','Inpatient','Emergency'] as $type)
            <option value="{{ $type }}" {{ old('visit_type', $visit->visit_type ?? '') == $type ? 'selected' : '' }}>{{ $type }}</option>
        @endforeach
    </select>
</div>
<div class="mb-3">
    <label for="reason" class="form-label">Reason</label>
    <textarea name="reason" class="form-control">{{ old('reason', $visit->reason ?? '') }}</textarea>
</div>
<div class="mb-3">
    <label for="doctor_name" class="form-label">Doctor Name</label>
    <input type="text" name="doctor_name" class="form-control" value="{{ old('doctor_name', $visit->doctor_name ?? '') }}">
</div>
<div class="mb-3">
    <label for="status" class="form-label">Status</label>
    <select name="status" class="form-select" required>
        @foreach(['Ongoing','Completed','Cancelled'] as $status)
            <option value="{{ $status }}" {{ old('status', $visit->status ?? '') == $status ? 'selected' : '' }}>{{ $status }}</option>
        @endforeach
    </select>
</div>
<button type="submit" class="btn btn-primary">{{ isset($visit) ? 'Update' : 'Create' }} Visit</button>
