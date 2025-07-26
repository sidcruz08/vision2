<div class="form-group">
    <label for="patient_code">Patient Code</label>
    <input type="text" name="patient_code" class="form-control" value="{{ old('patient_code', $patient->patient_code ?? '') }}" required>
</div>

<div class="form-group">
    <label for="first_name">First Name</label>
    <input type="text" name="first_name" class="form-control" value="{{ old('first_name', $patient->first_name ?? '') }}" required>
</div>

<div class="form-group">
    <label for="last_name">Last Name</label>
    <input type="text" name="last_name" class="form-control" value="{{ old('last_name', $patient->last_name ?? '') }}" required>
</div>

<div class="form-group">
    <label for="middle_name">Middle Name</label>
    <input type="text" name="middle_name" class="form-control" value="{{ old('middle_name', $patient->middle_name ?? '') }}">
</div>

<div class="form-group">
    <label for="birthdate">Birthdate</label>
    <input type="date" name="birthdate" class="form-control" value="{{ old('birthdate', $patient->birthdate ?? '') }}" required>
</div>

<div class="form-group">
    <label for="gender">Gender</label>
    <select name="gender" class="form-control" required>
        <option value="">Select</option>
        @foreach(['Male', 'Female', 'Other'] as $gender)
            <option value="{{ $gender }}" {{ (old('gender', $patient->gender ?? '') == $gender) ? 'selected' : '' }}>{{ $gender }}</option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label for="phone">Phone</label>
    <input type="text" name="phone" class="form-control" value="{{ old('phone', $patient->phone ?? '') }}">
</div>

<div class="form-group">
    <label for="email">Email</label>
    <input type="email" name="email" class="form-control" value="{{ old('email', $patient->email ?? '') }}">
</div>

<div class="form-group">
    <label for="address">Address</label>
    <textarea name="address" class="form-control">{{ old('address', $patient->address ?? '') }}</textarea>
</div>

<button type="submit" class="btn btn-primary">{{ isset($patient) ? 'Update' : 'Create' }} Patient</button>
