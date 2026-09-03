@extends('layouts.app')

@section('title', 'Log Aktifitas')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-body">
        <h5>Riwayat Log Aktifitas</h5>
        <p class="text-muted">Memantau seluruh aktifitas login, logout, dan aksi penting lainnya di aplikasi.</p>
        
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Waktu</th>
                        <th>User</th>
                        <th>Role</th>
                        <th>Aktivitas</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($logs as $log)
                    <tr>
                        <td>{{ $log->waktu_aktivitas }}</td>
                        <td>{{ $log->user->nama_lengkap ?? 'Unknown' }}</td>
                        <td>{{ ucfirst($log->user->role ?? '') }}</td>
                        <td>{{ $log->aktivitas }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
