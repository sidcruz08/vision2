<div class="mb-3">
    <label for="visit_id" class="form-label">Visit</label>
    <select name="visit_id" class="form-select" required>
        <option value="">Select Visit</option>
        @foreach($visits as $visit)
            <option value="{{ $visit->id }}"
                {{ old('visit_id', $diagnosis->visit_id ?? '') == $visit->id ? 'selected' : '' }}>
                {{ $visit->patient->first_name }} {{ $visit->patient->last_name }} - {{ $visit->visit_date }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label for="diagnosis_code" class="form-label">Diagnosis Code</label>
    <input type="text" name="diagnosis_code" class="form-control"
           value="{{ old('diagnosis_code', $diagnosis->diagnosis_code ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="description" class="form-label">Description</label>
    <textarea name="description" class="form-control">{{ old('description', $diagnosis->description ?? '') }}</textarea>
</div>

<button type="submit" class="btn btn-primary">{{ isset($diagnosis) ? 'Update' : 'Create' }} Diagnosis</button>
