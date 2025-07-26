{{-- resources/views/treatments/form.blade.php --}}
@csrf
<div class="form-group">
    <label for="diagnosis_id">Diagnosis</label>
    <select name="diagnosis_id" class="form-control" required>
        @foreach($diagnoses as $diagnosis)
            <option value="{{ $diagnosis->id }}" {{ old('diagnosis_id', $treatment->diagnosis_id ?? '') == $diagnosis->id ? 'selected' : '' }}>
                {{ $diagnosis->diagnosis_code }} - {{ $diagnosis->visit->patient->name ?? 'Unknown' }}
            </option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label for="treatment_type">Treatment Type</label>
    <input type="text" name="treatment_type" class="form-control" value="{{ old('treatment_type', $treatment->treatment_type ?? '') }}" required>
</div>

<div class="form-group">
    <label for="notes">Notes</label>
    <textarea name="notes" class="form-control">{{ old('notes', $treatment->notes ?? '') }}</textarea>
</div>

<button type="submit" class="btn btn-primary">Save</button>