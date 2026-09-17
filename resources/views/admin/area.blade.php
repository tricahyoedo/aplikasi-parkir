@extends('layouts.app')

@section('title', 'Area Parkir')

@section('content')
<div class="card" style="margin-bottom: 0; height: 100%; display: flex; flex-direction: column;">
    <div class="card-header bg-gradient" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); color: white; border: none; padding: 13px 18px; flex-shrink: 0;">
        <h5 style="font-size: 1.05rem; margin: 0;">
            <i class="bi bi-map-fill me-2"></i>Manajemen Area Parkir
        </h5>
    </div>
    <div style="flex: 1; display: flex; flex-direction: column; overflow: hidden; padding: 13px 18px;">
        <div style="flex-shrink: 0;">
            <p style="font-size: 0.95rem; color: #666; margin: 0 0 10px 0;">Kelola kapasitas dan status setiap area parkir.</p>
            @if(session('success'))
                <div class="alert alert-success border-left-4 mb-2" style="font-size: 0.8rem; padding: 8px 12px;">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                </div>
            @endif

            <button class="btn btn-primary btn-sm mb-3" data-bs-toggle="modal" data-bs-target="#addAreaModal" style="font-size: 0.9rem; padding: 6px 14px;">
                <i class="bi bi-plus-circle me-1"></i>Tambah Area
            </button>
        </div>
        
        <div style="flex: 1; overflow-y: auto; margin-right: -8px; padding-right: 8px;">
            <table class="table" style="font-size: 0.95rem; margin-bottom: 0;">
                <thead style="position: sticky; top: 0; background-color: #f8fafb; z-index: 10;">
                    <tr>
                        <th style="padding: 10px 8px; font-size: 0.9rem; font-weight: 600;">ID</th>
                        <th style="padding: 10px 8px; font-size: 0.9rem; font-weight: 600;">Nama Area</th>
                        <th style="padding: 10px 8px; font-size: 0.9rem; font-weight: 600;">Kapasitas</th>
                        <th style="padding: 10px 8px; font-size: 0.9rem; font-weight: 600;">Terisi</th>
                        <th style="padding: 10px 8px; font-size: 0.9rem; font-weight: 600;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($areas as $area)
                    <tr style="border-bottom: 1px solid #e8ecf1;">
                        <td style="padding: 6px;"><span class="badge bg-secondary">{{ $area->id_area }}</span></td>
                        <td style="padding: 6px;"><strong>{{ $area->nama_area }}</strong></td>
                        <td style="padding: 6px;">
                            <span class="{{ ($area->kapasitas - $area->kendaraans_count) <= 0 ? 'text-danger fw-bold' : 'text-success fw-bold' }}"
                                style="font-size: 0.8rem;">{{ max(0, $area->kapasitas - $area->kendaraans_count) }} / {{ $area->kapasitas }}</span>
                        </td>
                        <td style="padding: 6px;">
                            <div class="progress" style="height: 14px;">
                                <div class="progress-bar" style="width: {{ ($area->kendaraans_count / $area->kapasitas) * 100 }}%; background: linear-gradient(90deg, #1e3c72, #2a5298); font-size: 0.7rem; line-height: 14px;">{{ $area->kendaraans_count }}</div>
                            </div>
                        </td>
                        <td style="padding: 6px;">
                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editAreaModal{{ $area->id_area }}" style="font-size: 0.7rem; padding: 3px 8px;">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <form action="{{ route('admin.area.destroy', $area->id_area) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin hapus?')" style="font-size: 0.7rem; padding: 3px 8px;">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editAreaModal{{ $area->id_area }}" tabindex="-1">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-header" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); color: white; border: none; padding: 10px 15px;">
                                    <h5 class="modal-title" style="font-size: 0.9rem;">Edit Area</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('admin.area.update', $area->id_area) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body" style="padding: 12px;">
                                        <div class="mb-2">
                                            <label style="font-size: 0.8rem;">Nama Area</label>
                                            <input type="text" name="nama_area" class="form-control" style="font-size: 0.8rem; padding: 6px 10px;" value="{{ $area->nama_area }}" required>
                                        </div>
                                        <div class="mb-2">
                                            <label style="font-size: 0.8rem;">Kapasitas Total</label>
                                            <input type="number" name="kapasitas" class="form-control" style="font-size: 0.8rem; padding: 6px 10px;" value="{{ $area->kapasitas }}" required>
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
<div class="modal fade" id="addAreaModal" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); color: white; border: none; padding: 10px 15px;">
                <h5 class="modal-title" style="font-size: 0.9rem;">Tambah Area</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.area.store') }}" method="POST">
                @csrf
                <div class="modal-body" style="padding: 12px;">
                    <div class="mb-2">
                        <label style="font-size: 0.8rem;">Nama Area</label>
                        <input type="text" name="nama_area" class="form-control" style="font-size: 0.8rem; padding: 6px 10px;" required>
                    </div>
                    <div class="mb-2">
                        <label style="font-size: 0.8rem;">Kapasitas</label>
                        <input type="number" name="kapasitas" class="form-control" style="font-size: 0.8rem; padding: 6px 10px;" required>
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
