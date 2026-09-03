@extends('layouts.app')

@section('title', 'Kelola User')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-body">
        <h5>Halaman Manajemen User</h5>
        <p class="text-muted">Di sini admin dapat menambah, mengubah, dan menghapus data user.</p>
        
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addUserModal"><i class="bi bi-plus"></i> Tambah User</button>
        
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Lengkap</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id_user }}</td>
                        <td>{{ $user->nama_lengkap }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ ucfirst($user->role) }}</td>
                        <td>{!! $user->status_aktif ? '<span class="badge bg-success">Aktif</span>' : '<span class="badge bg-danger">Nonaktif</span>' !!}</td>
                        <td>
                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editUserModal{{ $user->id_user }}">Edit</button>
                            <form action="{{ route('admin.user.destroy', $user->id_user) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')">Hapus</button>
                            </form>
                        </td>
                    </tr>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editUserModal{{ $user->id_user }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit User</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('admin.user.update', $user->id_user) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label>Nama Lengkap</label>
                                            <input type="text" name="nama_lengkap" class="form-control" value="{{ $user->nama_lengkap }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label>Email</label>
                                            <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label>Password (Kosongkan jika tidak diubah)</label>
                                            <div class="input-group">
                                                <input type="password" name="password" id="editPassword{{ $user->id_user }}" class="form-control">
                                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('editPassword{{ $user->id_user }}')">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label>Role</label>
                                            <select name="role" class="form-select" required>
                                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                                <option value="petugas" {{ $user->role == 'petugas' ? 'selected' : '' }}>Petugas</option>
                                                <option value="owner" {{ $user->role == 'owner' ? 'selected' : '' }}>Owner</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label>Status Aktif</label>
                                            <select name="status_aktif" class="form-select" required>
                                                <option value="1" {{ $user->status_aktif == 1 ? 'selected' : '' }}>Aktif</option>
                                                <option value="0" {{ $user->status_aktif == 0 ? 'selected' : '' }}>Nonaktif</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.user.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Password</label>
                        <div class="input-group">
                            <input type="password" name="password" id="addPassword" class="form-control" required>
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('addPassword')">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label>Role</label>
                        <select name="role" class="form-select" required>
                            <option value="admin">Admin</option>
                            <option value="petugas">Petugas</option>
                            <option value="owner">Owner</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Status Aktif</label>
                        <select name="status_aktif" class="form-select" required>
                            <option value="1">Aktif</option>
                            <option value="0">Nonaktif</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const icon = input.nextElementSibling.querySelector('i');
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
    }
}
</script>
@endsection
