<!-- Modal -->
@foreach($users as $user)
@include('admin.users.modal', ['user' => $user])



<div class="modal fade" id="globalDeleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h5 class="modal-title">Delete User </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="add-contact-box">
                    <div class="add-contact-content">
                        <form action="{{ route('userDestroy', $user->id) }}" method="POST" id="addContactModalTitle">
                            <div class="row">
                                <p>Apakah kamu yakin ingin menghapus user <strong>{{ $user->name }}</strong>?</p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <form action="{{ route('userDestroy', $user->id) }}" method="POST">
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