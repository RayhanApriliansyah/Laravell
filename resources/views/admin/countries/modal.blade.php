<!-- Modal Delete untuk setiap Country -->
@foreach($countries as $country)
<div class="modal fade" id="deleteCountryModal{{ $country->id }}" tabindex="-1" aria-labelledby="deleteCountryModalLabel{{ $country->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h5 class="modal-title" id="deleteCountryModalLabel{{ $country->id }}">Delete User </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="add-contact-box">
                    <div class="add-contact-content">
                        <form action="{{ route('countries.destroy', $country->id) }}" method="POST" id="addContactModalTitle">
                            <div class="row">
                                <p>Apakah kamu yakin ingin menghapus user <strong>{{ $country->country_name }}</strong>?</p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <form action="{{ route('countries.destroy', $country->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-footer">
                    <div class="d-flex gap-6 m-0">
                        <button id="btn-edit" class="btn btn-success">Delete</button>
                        <button class="btn bg-danger-subtle text-danger" data-bs-dismiss="modal"> Cancel</button>

                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach