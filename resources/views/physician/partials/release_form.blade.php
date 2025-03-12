<form action="{{ route('physician.releasings.release', $releasing->id) }}" method="POST">
    @csrf
    <div class="form-check">
        <input type="checkbox" class="form-check-input" name="released_via_email" value="1" {{ $releasing->released_via_email ? 'checked' : '' }}>
        <label class="form-check-label">Released via Email</label>
    </div>
    <div class="form-check">
        <input type="checkbox" class="form-check-input" name="released_physical_copy" value="1" {{ $releasing->released_physical_copy ? 'checked' : '' }}>
        <label class="form-check-label">Released as Physical Copy</label>
    </div>
    <div class="form-group">
        <label for="released_at">Released At</label>
        <input type="datetime-local" class="form-control" name="released_at" value="{{ old('released_at', $releasing->released_at ? \Carbon\Carbon::parse($releasing->released_at)->format('Y-m-d\TH:i') : '') }}" required>
    </div>
    <button type="submit" class="btn btn-primary">Save</button>
</form>
