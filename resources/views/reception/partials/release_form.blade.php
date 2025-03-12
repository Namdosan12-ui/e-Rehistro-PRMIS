<form action="{{ route('reception.releasings.release', $releasing->id) }}" method="POST" class="release-form">
    @csrf
    <div class="form-group">
        <div class="checkbox-group">
            <label class="checkbox-label">
                <input type="checkbox" name="released_via_email" value="1"
                       {{ $releasing->released_via_email ? 'checked' : '' }}>
                Release via Email
            </label>
            <label class="checkbox-label">
                <input type="checkbox" name="released_physical_copy" value="1"
                       {{ $releasing->released_physical_copy ? 'checked' : '' }}>
                Physical Copy
            </label>
        </div>
        <div class="date-group mt-2">
            <label for="released_at">Release Date:</label>
            <input type="date" name="released_at" id="released_at"
                   value="{{ $releasing->released_at ? \Carbon\Carbon::parse($releasing->released_at)->format('Y-m-d') : date('Y-m-d') }}"
                   class="form-control" required>
        </div>
    </div>
    <button type="submit" class="btn btn-primary mt-2">Save Release Details</button>
</form>
