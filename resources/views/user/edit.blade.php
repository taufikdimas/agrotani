@empty($user)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan</h5>
                    Data user yang anda cari tidak ditemukan
                </div>
                <a href="{{ url('/user') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/user/' . $user->id) }}" method="POST" id="form-edit-user">
        @csrf
        @method('PUT')
        <div id="modal-edit-user" class="modal-dialog modal-lg" role="document">
            <input type="hidden" name="id" id="edit_id" value="{{ $user->id }}">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label>Nama</label>
                        <input type="text" name="nama" id="edit_nama" class="form-control" value="{{ $user->nama }}" required>
                        <small id="error-edit_nama" class="error-text form-text text-danger"></small>
                    </div>

                    <div class="form-group mb-3">
                        <label>Username</label>
                        <input type="text" name="username" id="edit_username" class="form-control" value="{{ $user->username }}" required>
                        <small id="error-edit_username" class="error-text form-text text-danger"></small>
                    </div>

                    <div class="form-group mb-3">
                        <label>Password</label>
                        <input type="password" name="password" id="edit_password" class="form-control" placeholder="Kosongkan jika tidak ingin mengubah">
                        <small id="error-edit_password" class="error-text form-text text-danger"></small>
                    </div>

                    <div class="form-group mb-3">
                        <label>Role</label>
                        <select name="role" id="edit_role" class="form-select" required>
                            <option value="Super Admin" {{ $user->role == 'Super Admin' ? 'selected' : '' }}>Super Admin</option>
                            <option value="User" {{ $user->role == 'User' ? 'selected' : '' }}>User</option>
                        </select>
                        <small id="error-edit_role" class="error-text form-text text-danger"></small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
        </div>
    </form>
@endempty