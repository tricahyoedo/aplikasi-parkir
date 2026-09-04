@extends('layouts.app')

@section('title', 'Data Kendaraan')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-body">
        <h5>Manajemen Data Kendaraan</h5>
        <p class="text-muted">Kelola data seluruh kendaraan. Setiap kendaraan baru yang ditambahkan akan <strong>otomatis masuk ke antrian parkir aktif</strong> di halaman Petugas.</p>
        
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

        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addKendaraanModal"><i class="bi bi-plus"></i> Tambah Kendaraan</button>
        
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Plat Nomor</th>
                        <th>Jenis</th>
                        <th>Merk / Tipe</th>
                        <th>Area Parkir</th>
                        <th>Pemilik</th>
                        <th>Status Parkir</th>
                        <th>Dicatat Oleh</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kendaraans as $kendaraan)
                    <tr>
                        <td>{{ $kendaraan->plat_nomor }}</td>
                        <td>{{ $kendaraan->jenis_kendaraan }}</td>
                        <td>{{ $kendaraan->merk }}</td>
                        <td>{{ $kendaraan->area->nama_area ?? 'Belum ditentukan' }}</td>
                        <td>{{ $kendaraan->pemilik }}</td>
                        <td>
                            @php
                                $transaksiAktif = \App\Models\Transaksi::where('id_kendaraan', $kendaraan->id_kendaraan)->where('status', 'masuk')->first();
                            @endphp
                            @if($transaksiAktif)
                                <span class="badge bg-success">🅿️ Sedang Parkir</span>
                                <small class="d-block text-muted">Masuk: {{ $transaksiAktif->waktu_masuk->format('H:i') }}</small>
                            @else
                                <span class="badge bg-secondary">Tidak Aktif</span>
                            @endif
                        </td>
                        <td>{{ $kendaraan->user->nama_lengkap ?? 'Unknown' }}</td>
                        <td>
                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editKendaraanModal{{ $kendaraan->id_kendaraan }}">Edit</button>
                            <form action="{{ route('admin.kendaraan.destroy', $kendaraan->id_kendaraan) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')">Hapus</button>
                            </form>
                        </td>
                    </tr>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editKendaraanModal{{ $kendaraan->id_kendaraan }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Kendaraan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('admin.kendaraan.update', $kendaraan->id_kendaraan) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label>Plat Nomor</label>
                                            <input type="text" name="plat_nomor" class="form-control" value="{{ $kendaraan->plat_nomor }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label>Jenis Kendaraan</label>
                                            <select name="jenis_kendaraan" class="form-select" required>
                                                <option value="Mobil" {{ $kendaraan->jenis_kendaraan == 'Mobil' ? 'selected' : '' }}>Mobil</option>
                                                <option value="Motor" {{ $kendaraan->jenis_kendaraan == 'Motor' ? 'selected' : '' }}>Motor</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label>Merk Kendaraan (Contoh: Vario, CBR, Avanza)</label>
                                            <input type="text" name="merk" class="form-control" value="{{ $kendaraan->merk }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label>Pemilik</label>
                                            <input type="text" name="pemilik" class="form-control" value="{{ $kendaraan->pemilik }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label>Lokasi Area Parkir</label>
                                            <select name="id_area" class="form-select" required>
                                                @foreach($areas as $area)
                                                    @php $sisa = $area->kapasitas - $area->kendaraans_count; @endphp
                                                    <option value="{{ $area->id_area }}" {{ $kendaraan->id_area == $area->id_area ? 'selected' : '' }}>
                                                        {{ $area->nama_area }} (Sisa Slot: {{ max(0, $sisa) }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label>Petugas Pencatat</label>
                                            <select name="id_user" class="form-select" required>
                                                @foreach($users as $user)
                                                    <option value="{{ $user->id_user }}" {{ $kendaraan->id_user == $user->id_user ? 'selected' : '' }}>{{ $user->nama_lengkap }} ({{ $user->role }})</option>
                                                @endforeach
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
<div class="modal fade" id="addKendaraanModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Kendaraan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.kendaraan.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-info py-2 mb-3">
                        <i class="bi bi-info-circle"></i> Kendaraan yang ditambahkan akan <strong>otomatis masuk ke daftar kendaraan parkir aktif</strong> di halaman Petugas.
                    </div>
                    <div class="mb-3">
                        <label>Plat Nomor <small class="text-muted">(harus unik, contoh: B 1234 ABC)</small></label>
                        <input type="text" name="plat_nomor" class="form-control @error('plat_nomor') is-invalid @enderror" value="{{ old('plat_nomor') }}" required>
                        @error('plat_nomor')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label>Jenis Kendaraan</label>
                        <select name="jenis_kendaraan" class="form-select @error('jenis_kendaraan') is-invalid @enderror" required>
                            <option value="Mobil" {{ old('jenis_kendaraan') == 'Mobil' ? 'selected' : '' }}>Mobil</option>
                            <option value="Motor" {{ old('jenis_kendaraan') == 'Motor' ? 'selected' : '' }}>Motor</option>
                        </select>
                        @error('jenis_kendaraan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label>Merk Kendaraan (Contoh: Vario, CBR, Avanza)</label>
                        <input type="text" name="merk" class="form-control @error('merk') is-invalid @enderror" value="{{ old('merk') }}" required>
                        @error('merk')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label>Pemilik</label>
                        <input type="text" name="pemilik" class="form-control @error('pemilik') is-invalid @enderror" value="{{ old('pemilik') }}" required>
                        @error('pemilik')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label>Lokasi Area Parkir</label>
                        <select name="id_area" class="form-select @error('id_area') is-invalid @enderror" required>
                            <option value="" disabled selected>Pilih Area Parkir</option>
                            @foreach($areas as $area)
                                @php $sisa = $area->kapasitas - $area->kendaraans_count; @endphp
                                <option value="{{ $area->id_area }}" {{ $sisa <= 0 ? 'disabled' : '' }} {{ old('id_area') == $area->id_area ? 'selected' : '' }}>
                                    {{ $area->nama_area }} (Sisa Slot: {{ max(0, $sisa) }}) {{ $sisa <= 0 ? '- PENUH' : '' }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_area')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label>Petugas Pencatat</label>
                        <select name="id_user" class="form-select @error('id_user') is-invalid @enderror" required>
                            @foreach($users as $user)
                                <option value="{{ $user->id_user }}" {{ old('id_user') == $user->id_user ? 'selected' : '' }}>{{ $user->nama_lengkap }} ({{ $user->role }})</option>
                            @endforeach
                        </select>
                        @error('id_user')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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
