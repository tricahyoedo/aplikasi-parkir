@extends('layouts.app')

@section('title', 'Data Kendaraan')

@section('content')
<div class="card" style="margin-bottom: 0; height: 100%; display: flex; flex-direction: column;">
    <div class="card-header bg-gradient" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); color: white; border: none; padding: 10px 15px; flex-shrink: 0;">
        <h5 style="font-size: 0.9rem; margin: 0;">
            <i class="bi bi-car-front-fill me-2"></i>Manajemen Data Kendaraan
        </h5>
    </div>
    <div style="flex: 1; display: flex; flex-direction: column; overflow: hidden; padding: 10px 15px;">
        <div style="flex-shrink: 0;">
            <p style="font-size: 0.8rem; color: #666; margin: 0 0 8px 0;">Kelola data seluruh kendaraan. Setiap kendaraan baru akan <strong>otomatis masuk ke antrian parkir aktif</strong> di halaman Petugas.</p>
            
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

            <button class="btn btn-primary btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#addKendaraanModal" style="font-size: 0.75rem; padding: 5px 12px;">
                <i class="bi bi-plus-circle me-1"></i>Tambah Kendaraan
            </button>
        </div>
        
        <div style="flex: 1; overflow-y: auto; margin-right: -8px; padding-right: 8px;">
            <table class="table" style="font-size: 0.75rem; margin-bottom: 0;">
                <thead style="position: sticky; top: 0; background-color: #f8fafb; z-index: 10;">
                    <tr>
                        <th style="padding: 6px 4px; font-size: 0.7rem;">Plat</th>
                        <th style="padding: 6px 4px; font-size: 0.7rem;">Jenis</th>
                        <th style="padding: 6px 4px; font-size: 0.7rem;">Merk</th>
                        <th style="padding: 6px 4px; font-size: 0.7rem;">Area</th>
                        <th style="padding: 6px 4px; font-size: 0.7rem;">Pemilik</th>
                        <th style="padding: 6px 4px; font-size: 0.7rem;">Status</th>
                        <th style="padding: 6px 4px; font-size: 0.7rem;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kendaraans as $kendaraan)
                    <tr style="border-bottom: 1px solid #e8ecf1;">
                        <td style="padding: 4px;"><span class="badge bg-primary" style="font-size: 0.65rem;">{{ $kendaraan->plat_nomor }}</span></td>
                        <td style="padding: 4px; font-size: 0.75rem;">{{ $kendaraan->jenis_kendaraan }}</td>
                        <td style="padding: 4px; font-size: 0.75rem;">{{ $kendaraan->merk }}</td>
                        <td style="padding: 4px; font-size: 0.75rem;">{{ $kendaraan->area->nama_area ?? '-' }}</td>
                        <td style="padding: 4px; font-size: 0.75rem;"><strong>{{ $kendaraan->pemilik }}</strong></td>
                        <td style="padding: 4px;">
                            @php
                                $transaksiAktif = \App\Models\Transaksi::where('id_kendaraan', $kendaraan->id_kendaraan)->where('status', 'masuk')->first();
                            @endphp
                            @if($transaksiAktif)
                                <span class="badge bg-success" style="font-size: 0.65rem;">Parkir</span>
                            @else
                                <span class="badge bg-secondary" style="font-size: 0.65rem;">-</span>
                            @endif
                        </td>
                        <td style="padding: 4px;">
                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editKendaraanModal{{ $kendaraan->id_kendaraan }}" style="font-size: 0.7rem; padding: 3px 6px;">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <form action="{{ route('admin.kendaraan.destroy', $kendaraan->id_kendaraan) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin hapus?')" style="font-size: 0.7rem; padding: 3px 6px;">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editKendaraanModal{{ $kendaraan->id_kendaraan }}" tabindex="-1">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-header" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); color: white; border: none; padding: 10px 15px;">
                                    <h5 class="modal-title" style="font-size: 0.9rem;">Edit Kendaraan</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('admin.kendaraan.update', $kendaraan->id_kendaraan) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body" style="padding: 12px;">
                                        <div class="mb-2">
                                            <label style="font-size: 0.75rem;">Plat Nomor</label>
                                            <input type="text" name="plat_nomor" class="form-control" style="font-size: 0.75rem; padding: 6px 10px;" value="{{ $kendaraan->plat_nomor }}" required>
                                        </div>
                                        <div class="mb-2">
                                            <label style="font-size: 0.75rem;">Jenis Kendaraan</label>
                                            <select name="jenis_kendaraan" class="form-select" style="font-size: 0.75rem; padding: 6px 10px;" required>
                                                <option value="Mobil" {{ $kendaraan->jenis_kendaraan == 'Mobil' ? 'selected' : '' }}>Mobil</option>
                                                <option value="Motor" {{ $kendaraan->jenis_kendaraan == 'Motor' ? 'selected' : '' }}>Motor</option>
                                            </select>
                                        </div>
                                        <div class="mb-2">
                                            <label style="font-size: 0.75rem;">Merk Kendaraan</label>
                                            <input type="text" name="merk" class="form-control" style="font-size: 0.75rem; padding: 6px 10px;" value="{{ $kendaraan->merk }}" required>
                                        </div>
                                        <div class="mb-2">
                                            <label style="font-size: 0.75rem;">Pemilik</label>
                                            <input type="text" name="pemilik" class="form-control" style="font-size: 0.75rem; padding: 6px 10px;" value="{{ $kendaraan->pemilik }}" required>
                                        </div>
                                        <div class="mb-2">
                                            <label style="font-size: 0.75rem;">Area Parkir</label>
                                            <select name="id_area" class="form-select" style="font-size: 0.75rem; padding: 6px 10px;" required>
                                                @foreach($areas as $area)
                                                    @php $sisa = $area->kapasitas - $area->kendaraans_count; @endphp
                                                    <option value="{{ $area->id_area }}" {{ $kendaraan->id_area == $area->id_area ? 'selected' : '' }}>
                                                        {{ $area->nama_area }} (Sisa: {{ max(0, $sisa) }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-2">
                                            <label style="font-size: 0.75rem;">Petugas Pencatat</label>
                                            <select name="id_user" class="form-select" style="font-size: 0.75rem; padding: 6px 10px;" required>
                                                @foreach($users as $user)
                                                    <option value="{{ $user->id_user }}" {{ $kendaraan->id_user == $user->id_user ? 'selected' : '' }}>{{ $user->nama_lengkap }}</option>
                                                @endforeach
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
<div class="modal fade" id="addKendaraanModal" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); color: white; border: none; padding: 10px 15px;">
                <h5 class="modal-title" style="font-size: 0.9rem;">Tambah Kendaraan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.kendaraan.store') }}" method="POST">
                @csrf
                <div class="modal-body" style="padding: 12px;">
                    <div class="alert alert-info mb-2" style="font-size: 0.75rem; padding: 8px;">
                        <i class="bi bi-info-circle"></i> Kendaraan akan otomatis masuk ke daftar parkir aktif.
                    </div>
                    <div class="mb-2">
                        <label style="font-size: 0.75rem;">Plat Nomor</label>
                        <input type="text" name="plat_nomor" class="form-control @error('plat_nomor') is-invalid @enderror" style="font-size: 0.75rem; padding: 6px 10px;" value="{{ old('plat_nomor') }}" required>
                        @error('plat_nomor')<div class="invalid-feedback" style="font-size: 0.7rem;">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-2">
                        <label style="font-size: 0.75rem;">Jenis Kendaraan</label>
                        <select name="jenis_kendaraan" class="form-select @error('jenis_kendaraan') is-invalid @enderror" style="font-size: 0.75rem; padding: 6px 10px;" required>
                            <option value="Mobil" {{ old('jenis_kendaraan') == 'Mobil' ? 'selected' : '' }}>Mobil</option>
                            <option value="Motor" {{ old('jenis_kendaraan') == 'Motor' ? 'selected' : '' }}>Motor</option>
                        </select>
                        @error('jenis_kendaraan')<div class="invalid-feedback" style="font-size: 0.7rem;">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-2">
                        <label style="font-size: 0.75rem;">Merk Kendaraan</label>
                        <input type="text" name="merk" class="form-control @error('merk') is-invalid @enderror" style="font-size: 0.75rem; padding: 6px 10px;" value="{{ old('merk') }}" required>
                        @error('merk')<div class="invalid-feedback" style="font-size: 0.7rem;">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-2">
                        <label style="font-size: 0.75rem;">Pemilik</label>
                        <input type="text" name="pemilik" class="form-control @error('pemilik') is-invalid @enderror" style="font-size: 0.75rem; padding: 6px 10px;" value="{{ old('pemilik') }}" required>
                        @error('pemilik')<div class="invalid-feedback" style="font-size: 0.7rem;">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-2">
                        <label style="font-size: 0.75rem;">Area Parkir</label>
                        <select name="id_area" class="form-select @error('id_area') is-invalid @enderror" style="font-size: 0.75rem; padding: 6px 10px;" required>
                            <option value="" disabled selected>Pilih Area</option>
                            @foreach($areas as $area)
                                @php $sisa = $area->kapasitas - $area->kendaraans_count; @endphp
                                <option value="{{ $area->id_area }}" {{ $sisa <= 0 ? 'disabled' : '' }} {{ old('id_area') == $area->id_area ? 'selected' : '' }}>
                                    {{ $area->nama_area }} ({{ max(0, $sisa) }}) {{ $sisa <= 0 ? '- PENUH' : '' }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_area')<div class="invalid-feedback" style="font-size: 0.7rem;">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-2">
                        <label style="font-size: 0.75rem;">Petugas Pencatat</label>
                        <select name="id_user" class="form-select @error('id_user') is-invalid @enderror" style="font-size: 0.75rem; padding: 6px 10px;" required>
                            @foreach($users as $user)
                                <option value="{{ $user->id_user }}" {{ old('id_user') == $user->id_user ? 'selected' : '' }}>{{ $user->nama_lengkap }}</option>
                            @endforeach
                        </select>
                        @error('id_user')<div class="invalid-feedback" style="font-size: 0.7rem;">{{ $message }}</div>@enderror
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
