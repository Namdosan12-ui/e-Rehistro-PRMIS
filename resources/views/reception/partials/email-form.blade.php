<form method="POST" action="{{ route('reception.releasings.sendEmail', $releasing->id) }}" class="d-inline">
    @csrf
    <button type="submit" class="btn btn-primary">
        <i class="fas fa-envelope"></i> Send Email
    </button>
</form>
