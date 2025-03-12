<form action="{{ route('physician.releasings.sendEmail', $releasing->id) }}" method="POST" class="d-inline">
    @csrf
    <button type="submit" class="btn btn-secondary">Send Email</button>
</form>
