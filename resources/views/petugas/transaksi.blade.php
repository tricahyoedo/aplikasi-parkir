@extends('layouts.app')

@section('title', 'Transaksi Parkir')

@section('content')

{{-- Alert Notifikasi --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
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

<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <h5>Pencatatan Transaksi Parkir</h5>
        <p class="text-muted">Catat kendaraan yang masuk dan keluar secara real-time.</p>
        <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#modalMasuk">
            <i class="bi bi-box-arrow-in-right"></i> Kendaraan Masuk
        </button>
    </div>
</div>

{{-- Tabel Kendaraan Aktif (Sedang Parkir) --}}
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <h6 class="fw-bold text-success"><i class="bi bi-car-front-fill me-1"></i> Kendaraan Sedang Parkir ({{ $transaksiAktif->count() }})</h6>
        <div class="table-responsive mt-2">
            <table class="table table-bordered table-striped align-middle">
                <thead>
                    <tr>
                        <th>Plat Nomor</th>
                        <th>Area Parkir</th>
                        <th>Waktu Masuk</th>
                        <th>Durasi</th>
                        <th>Tarif</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksiAktif as $t)
                    @php
                        $masuk = \Carbon\Carbon::parse($t->waktu_masuk);
                        $now = now();
                        $durasiJam = min(24, max(1, ceil($masuk->diffInMinutes($now) / 60)));
                    @endphp
                    <tr>
                        <td><strong>{{ $t->kendaraan->plat_nomor ?? '-' }}</strong><br><small class="text-muted">{{ $t->kendaraan->merk ?? '' }}</small></td>
                        <td>{{ $t->areaParkir->nama_area ?? '-' }}</td>
                        <td>{{ $masuk->format('H:i, d/m/Y') }}</td>
                        <td>{{ $durasiJam }} jam</td>
                        <td>Rp {{ number_format($t->tarif->tarif_per_jam ?? 0, 0, ',', '.') }}</td>
                        <td>
                            <form action="{{ route('petugas.transaksi.keluar', $t->id_parkir) }}" method="POST" class="d-inline" onsubmit="return confirm('Proses kendaraan keluar?')">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="bi bi-box-arrow-right"></i> Keluar
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-3">Tidak ada kendaraan yang sedang parkir.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Tabel Riwayat Hari Ini --}}
<div class="card shadow-sm border-0">
    <div class="card-body">
        <h6 class="fw-bold text-secondary"><i class="bi bi-clock-history me-1"></i> Riwayat Transaksi Hari Ini ({{ $riwayat->count() }})</h6>
        <div class="table-responsive mt-2">
            <table class="table table-bordered table-striped align-middle">
                <thead>
                    <tr>
                        <th>Plat Nomor</th>
                        <th>Area</th>
                        <th>Masuk</th>
                        <th>Keluar</th>
                        <th>Durasi</th>
                        <th>Total Biaya</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayat as $r)
                    <tr>
                        <td><strong>{{ $r->kendaraan->plat_nomor ?? '-' }}</strong></td>
                        <td>{{ $r->areaParkir->nama_area ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($r->waktu_masuk)->format('H:i') }}</td>
                        <td>{{ \Carbon\Carbon::parse($r->waktu_keluar)->format('H:i') }}</td>
                        <td>{{ $r->durasi_jam }} jam</td>
                        <td class="fw-bold text-success">Rp {{ number_format($r->biaya_total ?? 0, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-3">Belum ada transaksi selesai hari ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modal Kendaraan Masuk --}}
<div class="modal fade" id="modalMasuk" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title"><i class="bi bi-box-arrow-in-right me-1"></i> Catat Kendaraan Masuk</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('petugas.transaksi.masuk') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kendaraan (Plat Nomor)</label>
                        <select name="id_kendaraan" class="form-select" required>
                            <option value="" disabled selected>Pilih Kendaraan</option>
                            @foreach($kendaraans as $k)
                                <option value="{{ $k->id_kendaraan }}">{{ $k->plat_nomor }} - {{ $k->merk }} ({{ $k->jenis_kendaraan }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Area Parkir</label>
                        <select name="id_area" class="form-select" required>
                            <option value="" disabled selected>Pilih Area Parkir</option>
                            @foreach($areas as $a)
                                <option value="{{ $a->id_area }}" {{ $a->terisi >= $a->kapasitas ? 'disabled' : '' }}>
                                    {{ $a->nama_area }} ({{ $a->terisi }}/{{ $a->kapasitas }} terisi)
                                    {{ $a->terisi >= $a->kapasitas ? '- PENUH' : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tarif</label>
                        <select name="id_tarif" class="form-select" required>
                            <option value="" disabled selected>Pilih Tarif</option>
                            @foreach($tarifs as $tarif)
                                <option value="{{ $tarif->id_tarif }}">{{ ucfirst($tarif->jenis_kendaraan) }} - Rp {{ number_format($tarif->tarif_per_jam, 0, ',', '.') }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success"><i class="bi bi-check-circle"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
