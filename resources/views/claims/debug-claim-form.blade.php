<form method="post" enctype="multipart/form-data">
    @csrf
    <input type="number" name="visit_id" value="1">
    <input type="number" name="patient_id" value="1">
    <input type="text" name="claim_number" value="TEST123">
    <input type="date" name="claim_date" value="{{ date('Y-m-d') }}">
    <input type="number" name="claim_amount" value="100">
    <select name="status">
        <option>Pending</option>
    </select>
    <input type="file" name="documents[]" multiple>
    <button type="submit">Test Submit</button>
</form>