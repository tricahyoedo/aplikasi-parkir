@extends('layouts.app')

@section('title', 'Kelola User')

@section('content')
<div class="card" style="margin-bottom: 0; height: 100%; display: flex; flex-direction: column;">
    <div class="card-header bg-gradient" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); color: white; border: none; padding: 12px 18px; flex-shrink: 0;">
        <h5 style="font-size: 1rem; margin: 0;">
            <i class="bi bi-people-fill me-2"></i>Halaman Manajemen User
        </h5>
    </div>
    <div style="flex: 1; display: flex; flex-direction: column; overflow: hidden; padding: 12px 18px;">
        <div style="flex-shrink: 0;">
            <p style="font-size: 0.9rem; color: #666; margin: 0 0 10px 0;">Di sini admin dapat menambah, mengubah, dan menghapus data user.</p>
            
            @if(session('success'))
                <div class="alert alert-success border-left-4 mb-2" style="font-size: 0.9rem; padding: 10px 14px;">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                </div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger border-left-4 mb-2" style="font-size: 0.9rem; padding: 10px 14px;">
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <button class="btn btn-primary btn-sm mb-3" data-bs-toggle="modal" data-bs-target="#addUserModal" style="font-size: 0.85rem; padding: 6px 14px;">
                <i class="bi bi-plus-circle me-1"></i>Tambah User
            </button>
        </div>
        
        <div style="flex: 1; overflow-y: auto; margin-right: -8px; padding-right: 8px;">
            <table class="table" style="font-size: 0.9rem; margin-bottom: 0;">
                <thead style="position: sticky; top: 0; background-color: #f8fafb; z-index: 10;">
                    <tr>
                        <th style="padding: 10px 8px; font-size: 0.85rem; font-weight: 600;">ID</th>
                        <th style="padding: 10px 8px; font-size: 0.85rem; font-weight: 600;">Nama Lengkap</th>
                        <th style="padding: 10px 8px; font-size: 0.85rem; font-weight: 600;">Email</th>
                        <th style="padding: 10px 8px; font-size: 0.85rem; font-weight: 600;">Role</th>
                        <th style="padding: 10px 8px; font-size: 0.85rem; font-weight: 600;">Status</th>
                        <th style="padding: 10px 8px; font-size: 0.85rem; font-weight: 600;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr style="border-bottom: 1px solid #e8ecf1;">
                        <td style="padding: 8px; font-size: 0.9rem;">{{ $user->id_user }}</td>
                        <td style="padding: 8px; font-size: 0.9rem;">{{ $user->nama_lengkap }}</td>
                        <td style="padding: 8px; font-size: 0.9rem;">{{ $user->email }}</td>
                        <td style="padding: 8px;"><span class="badge bg-primary" style="font-size: 0.8rem;">{{ ucfirst($user->role) }}</span></td>
                        <td style="padding: 8px;">{!! $user->status_aktif ? '<span class="badge bg-success" style="font-size: 0.8rem;"><i class="bi bi-check-circle me-1"></i>Aktif</span>' : '<span class="badge bg-danger" style="font-size: 0.8rem;"><i class="bi bi-x-circle me-1"></i>Nonaktif</span>' !!}</td>
                        <td style="padding: 6px;">
                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editUserModal{{ $user->id_user }}" style="font-size: 0.7rem; padding: 3px 8px;">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <form action="{{ route('admin.user.destroy', $user->id_user) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin hapus?')" style="font-size: 0.7rem; padding: 3px 8px;">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editUserModal{{ $user->id_user }}" tabindex="-1">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-header" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); color: white; border: none; padding: 10px 15px;">
                                    <h5 class="modal-title" style="font-size: 0.9rem;">Edit User</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('admin.user.update', $user->id_user) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body" style="padding: 12px;">
                                        <div class="mb-2">
                                            <label style="font-size: 0.8rem;">Nama Lengkap</label>
                                            <input type="text" name="nama_lengkap" class="form-control" style="font-size: 0.8rem; padding: 6px 10px;" value="{{ $user->nama_lengkap }}" required>
                                        </div>
                                        <div class="mb-2">
                                            <label style="font-size: 0.8rem;">Email</label>
                                            <input type="email" name="email" class="form-control" style="font-size: 0.8rem; padding: 6px 10px;" value="{{ $user->email }}" required>
                                        </div>
                                        <div class="mb-2">
                                            <label style="font-size: 0.8rem;">Password (Kosongkan jika tidak diubah)</label>
                                            <div class="input-group input-group-sm">
                                                <input type="password" name="password" id="editPassword{{ $user->id_user }}" class="form-control" style="font-size: 0.8rem; padding: 6px 10px;">
                                                <button class="btn btn-outline-secondary btn-sm" type="button" onclick="togglePassword('editPassword{{ $user->id_user }}')" style="font-size: 0.8rem;">
                                                    <i class="bi bi-eye" style="font-size: 0.7rem;"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="mb-2">
                                            <label style="font-size: 0.8rem;">Role</label>
                                            <select name="role" class="form-select" style="font-size: 0.8rem; padding: 6px 10px;" required>
                                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                                <option value="petugas" {{ $user->role == 'petugas' ? 'selected' : '' }}>Petugas</option>
                                                <option value="owner" {{ $user->role == 'owner' ? 'selected' : '' }}>Owner</option>
                                            </select>
                                        </div>
                                        <div class="mb-2">
                                            <label style="font-size: 0.8rem;">Status Aktif</label>
                                            <select name="status_aktif" class="form-select" style="font-size: 0.8rem; padding: 6px 10px;" required>
                                                <option value="1" {{ $user->status_aktif == 1 ? 'selected' : '' }}>Aktif</option>
                                                <option value="0" {{ $user->status_aktif == 0 ? 'selected' : '' }}>Nonaktif</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer" style="padding: 10px; border-top: 1px solid #e0e6ed;">
                                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal" style="font-size: 0.75rem;">Batal</button>
                                        <button type="submit" class="btn btn-primary btn-sm" style="font-size: 0.75rem;">Simpan</button>
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
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); color: white; border: none; padding: 10px 15px;">
                <h5 class="modal-title" style="font-size: 0.9rem;">Tambah User</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.user.store') }}" method="POST">
                @csrf
                <div class="modal-body" style="padding: 12px;">
                    <div class="mb-2">
                        <label style="font-size: 0.8rem;">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" class="form-control" style="font-size: 0.8rem; padding: 6px 10px;" required>
                    </div>
                    <div class="mb-2">
                        <label style="font-size: 0.8rem;">Email</label>
                        <input type="email" name="email" class="form-control" style="font-size: 0.8rem; padding: 6px 10px;" required>
                    </div>
                    <div class="mb-2">
                        <label style="font-size: 0.8rem;">Password</label>
                        <div class="input-group input-group-sm">
                            <input type="password" name="password" id="addPassword" class="form-control" style="font-size: 0.8rem; padding: 6px 10px;" required>
                            <button class="btn btn-outline-secondary btn-sm" type="button" onclick="togglePassword('addPassword')" style="font-size: 0.8rem;">
                                <i class="bi bi-eye" style="font-size: 0.7rem;"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mb-2">
                        <label style="font-size: 0.8rem;">Role</label>
                        <select name="role" class="form-select" style="font-size: 0.8rem; padding: 6px 10px;" required>
                            <option value="admin">Admin</option>
                            <option value="petugas">Petugas</option>
                            <option value="owner">Owner</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label style="font-size: 0.8rem;">Status Aktif</label>
                        <select name="status_aktif" class="form-select" style="font-size: 0.8rem; padding: 6px 10px;" required>
                            <option value="1">Aktif</option>
                            <option value="0">Nonaktif</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer" style="padding: 10px; border-top: 1px solid #e0e6ed;">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal" style="font-size: 0.75rem;">Batal</button>
                    <button type="submit" class="btn btn-primary btn-sm" style="font-size: 0.75rem;">Simpan</button>
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
