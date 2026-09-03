@extends('layouts.app')

@section('title', 'Area Parkir')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-body">
        <h5>Manajemen Area Parkir</h5>
        <p class="text-muted">Kelola kapasitas dan status setiap area parkir.</p>
        
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addAreaModal"><i class="bi bi-plus"></i> Tambah Area</button>
        
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Area</th>
                        <th>Kapasitas</th>
                        <th>Terisi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($areas as $area)
                    <tr>
                        <td>{{ $area->id_area }}</td>
                        <td>{{ $area->nama_area }}</td>
                        <td>
                            <span class="{{ ($area->kapasitas - $area->kendaraans_count) <= 0 ? 'text-danger fw-bold' : 'text-success fw-bold' }}">
                                {{ max(0, $area->kapasitas - $area->kendaraans_count) }}
                            </span>
                        </td>
                        <td>
                            <span class="fw-bold">{{ $area->kendaraans_count }}</span>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editAreaModal{{ $area->id_area }}">Edit</button>
                            <form action="{{ route('admin.area.destroy', $area->id_area) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')">Hapus</button>
                            </form>
                        </td>
                    </tr>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editAreaModal{{ $area->id_area }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Area</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('admin.area.update', $area->id_area) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label>Nama Area</label>
                                            <input type="text" name="nama_area" class="form-control" value="{{ $area->nama_area }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label>Kapasitas Total</label>
                                            <input type="number" name="kapasitas" class="form-control" value="{{ $area->kapasitas }}" required>
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
<div class="modal fade" id="addAreaModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Area</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.area.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Nama Area</label>
                        <input type="text" name="nama_area" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Kapasitas</label>
                        <input type="number" name="kapasitas" class="form-control" required>
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
@endsection
