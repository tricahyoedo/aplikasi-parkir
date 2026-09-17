@extends('layouts.app')

@section('title', 'Log Aktifitas')

@section('content')
<div class="card" style="margin-bottom: 0; height: 100%; display: flex; flex-direction: column;">
    <div class="card-header bg-gradient" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); color: white; border: none; padding: 10px 15px; flex-shrink: 0;">
        <h5 style="font-size: 0.9rem; margin: 0;">
            <i class="bi bi-clock-history me-2"></i>Riwayat Log Aktifitas
        </h5>
    </div>
    <div style="flex: 1; display: flex; flex-direction: column; overflow: hidden; padding: 10px 15px;">
        <div style="flex-shrink: 0;">
            <p style="font-size: 0.8rem; color: #666; margin: 0 0 8px 0;">Memantau seluruh aktifitas login, logout, dan aksi penting lainnya di aplikasi.</p>
        </div>
        
        <div style="flex: 1; overflow-y: auto; margin-right: -8px; padding-right: 8px;">
            <table class="table" style="font-size: 0.8rem; margin-bottom: 0;">
                <thead style="position: sticky; top: 0; background-color: #f8fafb; z-index: 10;">
                    <tr>
                        <th style="padding: 8px 6px; font-size: 0.75rem;">Waktu</th>
                        <th style="padding: 8px 6px; font-size: 0.75rem;">User</th>
                        <th style="padding: 8px 6px; font-size: 0.75rem;">Role</th>
                        <th style="padding: 8px 6px; font-size: 0.75rem;">Aktivitas</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($logs as $log)
                    <tr style="border-bottom: 1px solid #e8ecf1;">
                        <td style="padding: 6px;"><span class="text-muted" style="font-size: 0.75rem;">{{ $log->waktu_aktivitas }}</span></td>
                        <td style="padding: 6px;"><strong style="font-size: 0.8rem;">{{ $log->user->nama_lengkap ?? 'Unknown' }}</strong></td>
                        <td style="padding: 6px;"><span class="badge bg-primary" style="font-size: 0.65rem;">{{ ucfirst($log->user->role ?? '') }}</span></td>
                        <td style="padding: 6px;"><span class="text-info" style="font-size: 0.8rem;">{{ $log->aktivitas }}</span></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
