<form method="POST" action="{{ route('claim-items.documents.store', $claimItem->id) }}" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="documents">Upload Documents</label>
        <input type="file" name="documents[]" class="form-control" multiple required>
    </div>
    <button type="submit" class="btn btn-success">Upload</button>
</form>
@endsection