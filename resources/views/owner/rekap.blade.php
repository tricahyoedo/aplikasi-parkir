@extends('layouts.app')

@section('title', 'Rekap Transaksi')

@section('content')
<div class="card shadow-sm mb-2" style="margin-bottom: 10px;">
    <div class="card-header bg-gradient" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); color: white; border: none; padding: 10px 15px;">
        <h5 style="font-size: 0.9rem; margin: 0;">
            <i class="bi bi-file-earmark-bar-graph-fill me-2"></i>Laporan dan Rekap Transaksi
        </h5>
    </div>
    <div style="padding: 12px; background-color: #f8fafb;">
        <p class="text-muted" style="font-size: 0.8rem; margin: 0 0 10px 0;">Tampilkan laporan pendapatan dan histori transaksi parkir secara lengkap.</p>
        
        <form action="{{ route('owner.rekap.index') }}" method="GET" style="display: flex; gap: 8px; flex-wrap: wrap; align-items: flex-end;">
            <div style="flex: 1; min-width: 150px;">
                <label style="font-size: 0.75rem; display: block; margin-bottom: 4px; font-weight: 600;">Dari Tanggal</label>
                <input type="date" name="start_date" class="form-control" style="font-size: 0.8rem; padding: 6px 8px;" value="{{ request('start_date') }}" required>
            </div>
            <div style="flex: 1; min-width: 150px;">
                <label style="font-size: 0.75rem; display: block; margin-bottom: 4px; font-weight: 600;">Sampai Tanggal</label>
                <input type="date" name="end_date" class="form-control" style="font-size: 0.8rem; padding: 6px 8px;" value="{{ request('end_date') }}" required>
            </div>
            <button type="submit" class="btn btn-primary btn-sm" style="font-size: 0.75rem; padding: 6px 12px;">
                <i class="bi bi-search me-1"></i>Tampilkan
            </button>
            <a href="{{ route('owner.rekap.index') }}" class="btn btn-secondary btn-sm" style="font-size: 0.75rem; padding: 6px 12px;">
                <i class="bi bi-calendar-check me-1"></i>Bulan Ini
            </a>
            <button type="button" class="btn btn-outline-success btn-sm" onclick="window.print()" style="font-size: 0.75rem; padding: 6px 12px;">
                <i class="bi bi-printer me-1"></i>Cetak
            </button>
        </form>
    </div>
</div>

<div class="card" style="margin-bottom: 0; display: flex; flex-direction: column; height: calc(100vh - 220px);">
    <div class="card-header bg-light" style="border-bottom: 2px solid #e0e6ed; flex-shrink: 0; padding: 10px 15px;">
        @if(request('start_date') && request('end_date'))
            <h6 style="font-size: 0.9rem; margin: 0;">
                <i class="bi bi-calendar3 me-2"></i> 
                Rekap: <strong>{{ \Carbon\Carbon::parse(request('start_date'))->format('d M Y') }} - {{ \Carbon\Carbon::parse(request('end_date'))->format('d M Y') }}</strong>
            </h6>
        @else
            <h6 style="font-size: 0.9rem; margin: 0;">
                <i class="bi bi-calendar-check me-2"></i>Rekap Bulan Ini <strong>({{ now()->translatedFormat('F Y') }})</strong>
            </h6>
        @endif
    </div>
    <div class="card-body p-0" style="overflow-y: auto; flex: 1;">
        <div class="table-responsive" style="margin: 0;">
            <table class="table" style="margin-bottom: 0; font-size: 0.8rem;">
                <thead style="position: sticky; top: 0; background-color: #f8fafb; z-index: 10;">
                    <tr>
                        <th style="padding: 8px 6px; font-size: 0.75rem;">Plat Nomor</th>
                        <th style="padding: 8px 6px; font-size: 0.75rem;">Area Parkir</th>
                        <th style="padding: 8px 6px; font-size: 0.75rem;">Waktu Masuk</th>
                        <th style="padding: 8px 6px; font-size: 0.75rem;">Waktu Keluar</th>
                        <th style="padding: 8px 6px; font-size: 0.75rem; text-align: right;">Biaya</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksis as $t)
                    <tr style="border-bottom: 1px solid #e8ecf1;">
                        <td style="padding: 6px;"><strong style="font-size: 0.8rem;">{{ $t->kendaraan->plat_nomor ?? '-' }}</strong></td>
                        <td style="padding: 6px; font-size: 0.8rem;">{{ $t->areaParkir->nama_area ?? '-' }}</td>
                        <td style="padding: 6px; font-size: 0.8rem;">{{ \Carbon\Carbon::parse($t->waktu_masuk)->format('d/m/Y H:i') }}</td>
                        <td style="padding: 6px; font-size: 0.8rem;">{{ \Carbon\Carbon::parse($t->waktu_keluar)->format('d/m/Y H:i') }}</td>
                        <td style="padding: 6px; font-size: 0.8rem; text-align: right;">Rp {{ number_format($t->biaya_total ?? 0, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-2" style="padding: 12px 6px; font-size: 0.8rem;">Belum ada transaksi parkir pada rentang waktu ini.</td>
                    </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr style="background-color: #e8f5e9; font-weight: bold; border-top: 2px solid #1e3c72;">
                        <td colspan="4" class="text-end" style="padding: 8px 6px; font-size: 0.8rem; text-transform: uppercase;">Total Pendapatan:</td>
                        <td style="padding: 8px 6px; font-size: 0.9rem; text-align: right; color: #00b894;">Rp {{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection
