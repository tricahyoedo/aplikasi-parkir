@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="row g-2 mb-2">
        <div class="col-md-3">
            <a href="{{ route('admin.user.index') }}" class="text-decoration-none">
                <div class="card text-bg-primary" style="margin-bottom: 0; min-height: 100px;">
                    <div class="card-body" style="padding: 15px;">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="card-title" style="margin-bottom: 8px; font-size: 0.8rem;">Total User</p>
                                <p class="card-text" style="font-size: 1.8rem; font-weight: bold; margin: 0;">{{ $totalUser }}</p>
                            </div>
                            <div style="opacity: 0.3; font-size: 2rem;">
                                <i class="bi bi-people"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="{{ route('admin.area.index') }}" class="text-decoration-none">
                <div class="card text-bg-success" style="margin-bottom: 0; min-height: 100px;">
                    <div class="card-body" style="padding: 15px;">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="card-title" style="margin-bottom: 8px; font-size: 0.8rem;">Area Parkir</p>
                                <p class="card-text" style="font-size: 1.8rem; font-weight: bold; margin: 0;">{{ $totalArea }}</p>
                            </div>
                            <div style="opacity: 0.3; font-size: 2rem;">
                                <i class="bi bi-map"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="{{ route('admin.kendaraan.index') }}" class="text-decoration-none">
                <div class="card text-bg-warning" style="margin-bottom: 0; min-height: 100px;">
                    <div class="card-body" style="padding: 15px;">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="card-title" style="margin-bottom: 8px; font-size: 0.8rem;">Total Kendaraan</p>
                                <p class="card-text" style="font-size: 1.8rem; font-weight: bold; margin: 0;">{{ $totalKendaraan }}</p>
                            </div>
                            <div style="opacity: 0.3; font-size: 2rem;">
                                <i class="bi bi-car-front"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="{{ route('admin.log.index') }}" class="text-decoration-none">
                <div class="card text-bg-danger" style="margin-bottom: 0; min-height: 100px;">
                    <div class="card-body" style="padding: 15px;">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="card-title" style="margin-bottom: 8px; font-size: 0.8rem;">Log Aktifitas</p>
                                <p class="card-text" style="font-size: 1.8rem; font-weight: bold; margin: 0;">{{ $totalLog }}</p>
                            </div>
                            <div style="opacity: 0.3; font-size: 2rem;">
                                <i class="bi bi-clock-history"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="card mb-4" style="margin-bottom: 20px;">
        <div class="card-body" style="padding: 12px 15px;">
            <h6 style="font-size: 0.9rem; margin-bottom: 6px; font-weight: 600;">
                <i class="bi bi-info-circle me-2"></i>Selamat Datang di Panel Admin
            </h6>
            <p style="font-size: 0.8rem; color: #666; margin: 0;">
                Kelola data aplikasi: User, Tarif, Area Parkir, Kendaraan, dan pantau Log Aktifitas.
            </p>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="row g-3">
        <!-- Bar Chart -->
        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-header bg-white d-flex justify-content-between align-items-center" style="border-bottom: 1px solid #d1fae5; padding: 15px 20px;">
                    <div>
                        <h6 class="mb-0 fw-bold" style="color: #064e3b; font-size: 1rem;">Aktivitas Parkir</h6>
                        <small class="text-muted" style="font-size: 0.8rem;">Perbandingan kendaraan masuk dan keluar</small>
                    </div>
                    <select class="form-select form-select-sm w-auto">
                        <option>Hari ini</option>
                        <option>Minggu ini</option>
                        <option>Bulan ini</option>
                    </select>
                </div>
                <div class="card-body">
                    <canvas id="aktivitasChart" height="100"></canvas>
                </div>
            </div>
        </div>

        <!-- Progress Bars -->
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header bg-white d-flex justify-content-between align-items-center" style="border-bottom: 1px solid #d1fae5; padding: 15px 20px;">
                    <div>
                        <h6 class="mb-0 fw-bold" style="color: #064e3b; font-size: 1rem;">Status Fasilitas</h6>
                        <small class="text-muted" style="font-size: 0.8rem;">Kondisi lokasi saat ini</small>
                    </div>
                    <i class="bi bi-car-front text-primary"></i>
                </div>
                <div class="card-body">
                    @forelse($areas->take(4) as $index => $area)
                        @php
                            $percentage = $area->kapasitas > 0 ? round(($area->terisi / $area->kapasitas) * 100) : 0;
                            // Determine color based on percentage
                            if ($percentage >= 90) {
                                $color = '#ef4444'; // Red
                                $bgClass = 'bg-danger';
                            } elseif ($percentage >= 70) {
                                $color = '#f59e0b'; // Yellow/Orange
                                $bgClass = 'bg-warning';
                            } elseif ($percentage >= 40) {
                                $color = '#0ea5e9'; // Blue
                                $bgClass = ''; // custom color
                            } else {
                                $color = '#10b981'; // Green
                                $bgClass = 'bg-success';
                            }
                        @endphp
                        <div class="mb-4">
                            <div class="d-flex justify-content-between mb-1">
                                <span style="font-size: 0.85rem; font-weight: 600; color: #374151;">{{ $area->nama_area }}</span>
                                <span style="font-size: 0.85rem; font-weight: bold; color: {{ $color }};">{{ $percentage }}%</span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar {{ $bgClass }}" role="progressbar" style="width: {{ $percentage }}%; {{ $bgClass == '' ? 'background-color: '.$color.';' : '' }}" aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <small class="text-muted" style="font-size: 0.7rem;">{{ $area->terisi }} / {{ $area->kapasitas }} terisi</small>
                        </div>
                    @empty
                        <div class="text-center text-muted py-4">
                            <p class="mb-0">Belum ada data area parkir.</p>
                        </div>
                    @endforelse
                    
                    <div class="text-center mt-4">
                        <a href="{{ route('admin.area.index') }}" class="text-decoration-none" style="font-size: 0.85rem; font-weight: 600; color: #0ea5e9;">Lihat semua fasilitas</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@stack('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('aktivitasChart').getContext('2d');
        const aktivitasChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['06.00', '09.00', '12.00', '15.00', '18.00', '21.00'],
                datasets: [
                    {
                        label: 'Kendaraan Masuk',
                        data: {!! json_encode($chartDataMasuk) !!},
                        backgroundColor: '#0ea5e9', // Blue
                        borderRadius: 4,
                        barPercentage: 0.6,
                        categoryPercentage: 0.8
                    },
                    {
                        label: 'Kendaraan Keluar',
                        data: {!! json_encode($chartDataKeluar) !!},
                        backgroundColor: '#10b981', // Green
                        borderRadius: 4,
                        barPercentage: 0.6,
                        categoryPercentage: 0.8
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        align: 'end',
                        labels: {
                            usePointStyle: true,
                            boxWidth: 8,
                            font: {
                                size: 11
                            }
                        }
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            borderDash: [4, 4],
                            drawBorder: false,
                        },
                        ticks: {
                            stepSize: 1,
                            color: '#9ca3af',
                        }
                    },
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            color: '#9ca3af',
                            font: {
                                size: 11
                            }
                        }
                    }
                },
                interaction: {
                    mode: 'nearest',
                    axis: 'x',
                    intersect: false
                }
            }
        });
    });
</script>