<!-- Modal Delete Airport -->
<div class="modal fade" id="deleteAirportModal{{ $airport->id }}" tabindex="-1" aria-labelledby="deleteAirportModalLabel{{ $airport->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="modal-header d-flex align-items-center">
                <h5 class="modal-title" id="deleteAirportModalLabel{{ $airport->id }}">Delete Airport</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('airport.destroy', $airport->id) }}" method="POST">
                @csrf
                @method('DELETE')

                <div class="modal-body">
                    <p>
                        Are you sure want to delete
                        <strong>{{ $airport->name }}</strong>
                        ({{ $airport->code }})?
                    </p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn bg-danger-subtle text-danger" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>

        </div>
    </div>
</div>
<!-- End Modal Delete Airport -->