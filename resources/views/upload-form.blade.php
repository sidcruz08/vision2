<form action="{{ route('ocr.process') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <label for="pdf">Upload a scanned PDF:</label>
    <input type="file" name="pdf" accept="application/pdf" required>
    <button type="submit">Process</button>
</form>
