<!-- Modal Delete Airline -->
<div class="modal fade" id="deleteAirlineModal{{ $airline->id }}" tabindex="-1" aria-labelledby="deleteAirlineModalLabel{{ $airline->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="modal-header d-flex align-items-center">
                <h5 class="modal-title">Delete Airline</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('airlines.destroy', $airline->id) }}" method="POST">
                @csrf
                @method('DELETE')

                <div class="modal-body">
                    <p>Apakah kamu yakin ingin menghapus maskapai
                        <strong>{{ $airline->name }}</strong>?
                    </p>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Delete</button>
                    <button type="button" class="btn bg-danger-subtle text-danger" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>

        </div>
    </div>
</div>