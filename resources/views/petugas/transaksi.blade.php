@extends('layouts.app')

@section('title', 'Transaksi Parkir')

@section('content')

{{-- Alert Notifikasi --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-left-4 mb-2" role="alert" style="font-size: 0.8rem; padding: 8px 12px;">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" style="font-size: 0.7rem;"></button>
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show border-left-4 mb-2" role="alert" style="font-size: 0.8rem; padding: 8px 12px;">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" style="font-size: 0.7rem;"></button>
    </div>
@endif
@if($errors->any())
    <div class="alert alert-danger border-left-4 mb-2" style="font-size: 0.8rem; padding: 8px 12px;">
        <ul style="margin: 0; padding-left: 20px;">
            @foreach($errors->all() as $error)
                <li style="font-size: 0.75rem;">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card shadow-sm mb-2" style="display: flex; flex-direction: column; height: calc(50vh - 60px); margin-bottom: 10px !important;">
    <div class="card-header bg-gradient" style="background: linear-gradient(135deg, #00b894 0%, #00a676 100%); color: white; border: none; padding: 10px 15px; flex-shrink: 0;">
        <h5 style="font-size: 0.9rem; margin: 0;">
            <i class="bi bi-receipt-fill me-2"></i>Pencatatan Transaksi Parkir
        </h5>
    </div>
    <div style="padding: 10px 15px; flex-shrink: 0;">
        <p class="text-muted" style="font-size: 0.8rem; margin: 0 0 8px 0;">Catat kendaraan yang masuk dan keluar secara real-time.</p>
        <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalMasuk" style="font-size: 0.75rem; padding: 5px 12px;">
            <i class="bi bi-box-arrow-in-right me-1"></i>Masuk
        </button>
    </div>

    {{-- Tabel Kendaraan Aktif (Sedang Parkir) --}}
    <div style="flex: 1; overflow-y: auto; padding: 0 12px;">
        <h6 style="font-size: 0.8rem; color: #00b894; font-weight: bold; margin: 10px 0 8px 0;">
            <i class="bi bi-car-front-fill me-1"></i>Kendaraan Sedang Parkir <span class="badge bg-success" style="font-size: 0.65rem;">{{ $transaksiAktif->count() }}</span>
        </h6>
        <div class="table-responsive" style="margin: 0;">
            <table class="table" style="font-size: 0.75rem; margin-bottom: 0;">
                <thead style="position: sticky; top: 0; background-color: #f8fafb; z-index: 10;">
                    <tr>
                        <th style="padding: 6px 4px; font-size: 0.7rem;">Plat</th>
                        <th style="padding: 6px 4px; font-size: 0.7rem;">Area</th>
                        <th style="padding: 6px 4px; font-size: 0.7rem;">Masuk</th>
                        <th style="padding: 6px 4px; font-size: 0.7rem;">Durasi</th>
                        <th style="padding: 6px 4px; font-size: 0.7rem;">Tarif</th>
                        <th style="padding: 6px 4px; font-size: 0.7rem;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksiAktif as $t)
                    @php
                        $masuk = \Carbon\Carbon::parse($t->waktu_masuk);
                        $now = now();
                        $durasiJam = min(24, max(1, ceil($masuk->diffInMinutes($now) / 60)));
                    @endphp
                    <tr style="border-bottom: 1px solid #e8ecf1;">
                        <td style="padding: 4px;"><strong style="font-size: 0.75rem;">{{ $t->kendaraan->plat_nomor ?? '-' }}</strong></td>
                        <td style="padding: 4px;"><span class="badge bg-primary" style="font-size: 0.6rem;">{{ $t->areaParkir->nama_area ?? '-' }}</span></td>
                        <td style="padding: 4px; font-size: 0.75rem;">{{ $masuk->format('H:i') }}</td>
                        <td style="padding: 4px;"><span class="badge bg-warning" style="font-size: 0.6rem;">{{ $durasiJam }}j</span></td>
                        <td style="padding: 4px; font-size: 0.75rem;"><span class="text-success fw-bold">Rp {{ number_format($t->tarif->tarif_per_jam ?? 0, 0, ',', '.') }}</span></td>
                        <td style="padding: 4px;">
                            <form action="{{ route('petugas.transaksi.keluar', $t->id_parkir) }}" method="POST" class="d-inline" onsubmit="return confirm('Proses keluar?')">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-danger" style="font-size: 0.7rem; padding: 3px 6px;">
                                    <i class="bi bi-box-arrow-right"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-2" style="font-size: 0.8rem;">
                            Tidak ada kendaraan parkir.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Tabel Riwayat Hari Ini --}}
<div class="card shadow-sm" style="margin-bottom: 0; display: flex; flex-direction: column; height: calc(50vh - 60px);">
    <div class="card-header bg-light" style="border-bottom: 2px solid #e0e6ed; flex-shrink: 0; padding: 10px 15px;">
        <h6 style="font-size: 0.9rem; margin: 0;">
            <i class="bi bi-clock-history text-secondary me-1"></i><strong>Riwayat Hari Ini</strong> <span class="badge bg-secondary" style="font-size: 0.65rem;">{{ $riwayat->count() }}</span>
        </h6>
    </div>
    <div style="flex: 1; overflow-y: auto;">
        <div class="table-responsive" style="margin: 0;">
            <table class="table" style="font-size: 0.75rem; margin-bottom: 0;">
                <thead style="position: sticky; top: 0; background-color: #f8fafb; z-index: 10;">
                    <tr>
                        <th style="padding: 6px 4px; font-size: 0.7rem;">Plat</th>
                        <th style="padding: 6px 4px; font-size: 0.7rem;">Area</th>
                        <th style="padding: 6px 4px; font-size: 0.7rem;">Masuk</th>
                        <th style="padding: 6px 4px; font-size: 0.7rem;">Keluar</th>
                        <th style="padding: 6px 4px; font-size: 0.7rem;">Durasi</th>
                        <th style="padding: 6px 4px; font-size: 0.7rem;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayat as $r)
                    <tr style="border-bottom: 1px solid #e8ecf1;">
                        <td style="padding: 4px;"><strong style="font-size: 0.75rem;">{{ $r->kendaraan->plat_nomor ?? '-' }}</strong></td>
                        <td style="padding: 4px;"><span class="badge bg-info" style="font-size: 0.6rem;">{{ $r->areaParkir->nama_area ?? '-' }}</span></td>
                        <td style="padding: 4px; font-size: 0.75rem;">{{ \Carbon\Carbon::parse($r->waktu_masuk)->format('H:i') }}</td>
                        <td style="padding: 4px; font-size: 0.75rem;">{{ \Carbon\Carbon::parse($r->waktu_keluar)->format('H:i') }}</td>
                        <td style="padding: 4px;"><span class="badge bg-secondary" style="font-size: 0.6rem;">{{ $r->durasi_jam }}j</span></td>
                        <td style="padding: 4px; font-size: 0.75rem;"><span class="fw-bold text-success">Rp {{ number_format($r->biaya_total ?? 0, 0, ',', '.') }}</span></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-2" style="padding: 10px 4px; font-size: 0.75rem;">
                            Belum ada transaksi selesai.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modal Kendaraan Masuk --}}
<div class="modal fade" id="modalMasuk" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header bg-gradient" style="background: linear-gradient(135deg, #00b894 0%, #00a676 100%); color: white; border: none; padding: 10px 15px;">
                <h5 class="modal-title" style="font-size: 0.9rem; margin: 0;"><i class="bi bi-box-arrow-in-right me-2"></i>Kendaraan Masuk</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('petugas.transaksi.masuk') }}" method="POST">
                @csrf
                <div class="modal-body" style="padding: 12px;">
                    <div class="mb-2">
                        <label style="font-size: 0.75rem; font-weight: 600;">Kendaraan</label>
                        <select name="id_kendaraan" class="form-select" style="font-size: 0.8rem; padding: 6px 10px;" required>
                            <option value="" disabled selected>Pilih Kendaraan</option>
                            @foreach($kendaraans as $k)
                                <option value="{{ $k->id_kendaraan }}">{{ $k->plat_nomor }} - {{ $k->merk }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-2">
                        <label style="font-size: 0.75rem; font-weight: 600;">Area Parkir</label>
                        <select name="id_area" class="form-select" style="font-size: 0.8rem; padding: 6px 10px;" required>
                            <option value="" disabled selected>Pilih Area</option>
                            @foreach($areas as $a)
                                <option value="{{ $a->id_area }}" {{ $a->terisi >= $a->kapasitas ? 'disabled' : '' }}>
                                    {{ $a->nama_area }} ({{ $a->terisi }}/{{ $a->kapasitas }})
                                    {{ $a->terisi >= $a->kapasitas ? '- PENUH' : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-2">
                        <label style="font-size: 0.75rem; font-weight: 600;">Tarif</label>
                        <select name="id_tarif" class="form-select" style="font-size: 0.8rem; padding: 6px 10px;" required>
                            <option value="" disabled selected>Pilih Tarif</option>
                            @foreach($tarifs as $tarif)
                                <option value="{{ $tarif->id_tarif }}">{{ ucfirst($tarif->jenis_kendaraan) }} - Rp {{ number_format($tarif->tarif_per_jam, 0, ',', '.') }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer" style="padding: 10px; border-top: 1px solid #e0e6ed;">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal" style="font-size: 0.75rem;">Batal</button>
                    <button type="submit" class="btn btn-success btn-sm" style="font-size: 0.75rem;"><i class="bi bi-check-circle me-1"></i>Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
