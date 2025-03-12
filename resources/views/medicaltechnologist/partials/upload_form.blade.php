<form action="{{ route('medicaltechnologist.releasings.upload', $releasing->id) }}" method="POST" enctype="multipart/form-data" class="d-inline">
    @csrf
    <div class="input-group">
        <input type="file" name="result_file" class="form-control" required>
        <button type="submit" class="btn btn-primary">Upload</button>
    </div>
</form>
