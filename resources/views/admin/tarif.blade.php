@extends('layouts.app')

@section('title', 'Tarif Parkir')

@section('content')
<div class="card" style="margin-bottom: 0; height: 100%; display: flex; flex-direction: column;">
    <div class="card-header bg-gradient" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); color: white; border: none; padding: 10px 15px; flex-shrink: 0;">
        <h5 style="font-size: 0.9rem; margin: 0;">
            <i class="bi bi-tags-fill me-2"></i>Manajemen Tarif Parkir
        </h5>
    </div>
    <div style="flex: 1; display: flex; flex-direction: column; overflow: hidden; padding: 10px 15px;">
        <div style="flex-shrink: 0;">
            <p style="font-size: 0.8rem; color: #666; margin: 0 0 8px 0;">Kelola tarif berdasarkan jenis kendaraan.</p>
            
            @if(session('success'))
                <div class="alert alert-success border-left-4 mb-2" style="font-size: 0.8rem; padding: 8px 12px;">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                </div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger border-left-4 mb-2" style="font-size: 0.8rem; padding: 8px 12px;">
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <button class="btn btn-primary btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#addTarifModal" style="font-size: 0.75rem; padding: 5px 12px;">
                <i class="bi bi-plus-circle me-1"></i>Tambah Tarif
            </button>
        </div>
        
        <div style="flex: 1; overflow-y: auto; margin-right: -8px; padding-right: 8px;">
            <table class="table" style="font-size: 0.8rem; margin-bottom: 0;">
                <thead style="position: sticky; top: 0; background-color: #f8fafb; z-index: 10;">
                    <tr>
                        <th style="padding: 8px 6px; font-size: 0.75rem;">ID</th>
                        <th style="padding: 8px 6px; font-size: 0.75rem;">Jenis Kendaraan</th>
                        <th style="padding: 8px 6px; font-size: 0.75rem;">Tarif per Jam</th>
                        <th style="padding: 8px 6px; font-size: 0.75rem;">Tarif Maksimal</th>
                        <th style="padding: 8px 6px; font-size: 0.75rem;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tarifs as $tarif)
                    <tr style="border-bottom: 1px solid #e8ecf1;">
                        <td style="padding: 6px;"><span class="badge bg-secondary">{{ $tarif->id_tarif }}</span></td>
                        <td style="padding: 6px;"><strong>{{ ucfirst($tarif->jenis_kendaraan) }}</strong></td>
                        <td style="padding: 6px;"><span class="text-primary fw-bold" style="font-size: 0.8rem;">Rp {{ number_format($tarif->tarif_per_jam, 0, ',', '.') }}</span></td>
                        <td style="padding: 6px;"><span class="text-success fw-bold" style="font-size: 0.8rem;">Rp {{ number_format($tarif->tarif_maksimal, 0, ',', '.') }}</span></td>
                        <td style="padding: 6px;">
                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editTarifModal{{ $tarif->id_tarif }}" style="font-size: 0.7rem; padding: 3px 8px;">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <form action="{{ route('admin.tarif.destroy', $tarif->id_tarif) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin hapus?')" style="font-size: 0.7rem; padding: 3px 8px;">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editTarifModal{{ $tarif->id_tarif }}" tabindex="-1">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-header" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); color: white; border: none; padding: 10px 15px;">
                                    <h5 class="modal-title" style="font-size: 0.9rem;">Edit Tarif</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('admin.tarif.update', $tarif->id_tarif) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body" style="padding: 12px;">
                                        <div class="mb-2">
                                            <label style="font-size: 0.8rem;">Jenis Kendaraan</label>
                                            <input type="text" name="jenis_kendaraan" class="form-control" style="font-size: 0.8rem; padding: 6px 10px;" value="{{ $tarif->jenis_kendaraan }}" required>
                                        </div>
                                        <div class="mb-2">
                                            <label style="font-size: 0.8rem;">Tarif per Jam</label>
                                            <input type="number" name="tarif_per_jam" class="form-control" style="font-size: 0.8rem; padding: 6px 10px;" value="{{ $tarif->tarif_per_jam }}" required>
                                        </div>
                                        <div class="mb-2">
                                            <label style="font-size: 0.8rem;">Tarif Maksimal</label>
                                            <input type="number" name="tarif_maksimal" class="form-control" style="font-size: 0.8rem; padding: 6px 10px;" value="{{ $tarif->tarif_maksimal }}" required>
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
<div class="modal fade" id="addTarifModal" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); color: white; border: none; padding: 10px 15px;">
                <h5 class="modal-title" style="font-size: 0.9rem;">Tambah Tarif</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.tarif.store') }}" method="POST">
                @csrf
                <div class="modal-body" style="padding: 12px;">
                    <div class="mb-2">
                        <label style="font-size: 0.8rem;">Jenis Kendaraan</label>
                        <input type="text" name="jenis_kendaraan" class="form-control" style="font-size: 0.8rem; padding: 6px 10px;" required>
                    </div>
                    <div class="mb-2">
                        <label style="font-size: 0.8rem;">Tarif per Jam</label>
                        <input type="number" name="tarif_per_jam" class="form-control" style="font-size: 0.8rem; padding: 6px 10px;" required>
                    </div>
                    <div class="mb-2">
                        <label style="font-size: 0.8rem;">Tarif Maksimal</label>
                        <input type="number" name="tarif_maksimal" class="form-control" style="font-size: 0.8rem; padding: 6px 10px;" required>
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
@endsection
