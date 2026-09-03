@extends('layouts.app')

@section('title', 'Tarif Parkir')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-body">
        <h5>Manajemen Tarif Parkir</h5>
        <p class="text-muted">Kelola tarif berdasarkan jenis kendaraan.</p>
        
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

        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addTarifModal"><i class="bi bi-plus"></i> Tambah Tarif</button>
        
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Jenis Kendaraan</th>
                        <th>Tarif per Jam</th>
                        <th>Tarif Maksimal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tarifs as $tarif)
                    <tr>
                        <td>{{ $tarif->id_tarif }}</td>
                        <td>{{ $tarif->jenis_kendaraan }}</td>
                        <td>Rp {{ number_format($tarif->tarif_per_jam, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($tarif->tarif_maksimal, 0, ',', '.') }}</td>
                        <td>
                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editTarifModal{{ $tarif->id_tarif }}">Edit</button>
                            <form action="{{ route('admin.tarif.destroy', $tarif->id_tarif) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')">Hapus</button>
                            </form>
                        </td>
                    </tr>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editTarifModal{{ $tarif->id_tarif }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Tarif</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('admin.tarif.update', $tarif->id_tarif) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label>Jenis Kendaraan</label>
                                            <input type="text" name="jenis_kendaraan" class="form-control" value="{{ $tarif->jenis_kendaraan }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label>Tarif per Jam</label>
                                            <input type="number" name="tarif_per_jam" class="form-control" value="{{ $tarif->tarif_per_jam }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label>Tarif Maksimal</label>
                                            <input type="number" name="tarif_maksimal" class="form-control" value="{{ $tarif->tarif_maksimal }}" required>
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
<div class="modal fade" id="addTarifModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Tarif</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.tarif.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Jenis Kendaraan</label>
                        <input type="text" name="jenis_kendaraan" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Tarif per Jam</label>
                        <input type="number" name="tarif_per_jam" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Tarif Maksimal</label>
                        <input type="number" name="tarif_maksimal" class="form-control" required>
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
