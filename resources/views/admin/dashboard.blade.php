@extends('admin.layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard Overview')

@section('content')

{{-- Stats Cards --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon blue"><i class="fas fa-users"></i></div>
        <div>
            <div class="stat-value">{{ $stats['total_users'] }}</div>
            <div class="stat-label">Total Users</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green"><i class="fas fa-calendar-alt"></i></div>
        <div>
            <div class="stat-value">{{ $stats['total_events'] }}</div>
            <div class="stat-label">Total Events</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon orange"><i class="fas fa-clipboard-list"></i></div>
        <div>
            <div class="stat-value">{{ $stats['total_registrations'] }}</div>
            <div class="stat-label">Total Registrasi</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon red"><i class="fas fa-fire"></i></div>
        <div>
            <div class="stat-value">{{ $stats['active_events'] }}</div>
            <div class="stat-label">Event Aktif</div>
        </div>
    </div>
</div>

{{-- Charts --}}
<div class="charts-grid">
    <div class="chart-card">
        <div class="chart-title"><i class="fas fa-chart-bar"></i> Registrasi per Event</div>
        <canvas id="chartEvents" height="180"></canvas>
    </div>
    <div class="chart-card">
        <div class="chart-title"><i class="fas fa-chart-line"></i> Registrasi per Bulan ({{ now()->year }})</div>
        <canvas id="chartMonthly" height="180"></canvas>
    </div>
</div>

{{-- Recent Activity Log --}}
<div class="card">
    <div class="card-header">
        <span class="card-title"><i class="fas fa-history"></i> Aktivitas Terbaru</span>
        <a href="{{ route('admin.logs.index') }}" class="btn btn-secondary btn-sm">Lihat Semua</a>
    </div>
    <div class="card-body">
        <table>
            <thead>
                <tr>
                    <th>Waktu</th>
                    <th>User</th>
                    <th>Aksi</th>
                    <th>Deskripsi</th>
                    <th>IP</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentLogs as $log)
                <tr>
                    <td style="white-space:nowrap;color:#6b7280;font-size:.8rem;">{{ $log->created_at->format('d M, H:i') }}</td>
                    <td>{{ $log->user->name ?? 'System' }}</td>
                    <td><span class="badge badge-user">{{ $log->action }}</span></td>
                    <td>{{ $log->description }}</td>
                    <td style="color:#6b7280;font-size:.8rem;">{{ $log->ip_address }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align:center;color:#9ca3af;padding:24px;">Belum ada aktivitas.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('scripts')
<script>
// Chart: Registrasi per Event
const eventLabels = @json($chartEvents->pluck('title'));
const eventData   = @json($chartEvents->pluck('registrations_count'));

new Chart(document.getElementById('chartEvents'), {
    type: 'bar',
    data: {
        labels: eventLabels,
        datasets: [{
            label: 'Registrasi',
            data: eventData,
            backgroundColor: 'rgba(233,69,96,.7)',
            borderColor: '#e94560',
            borderWidth: 2,
            borderRadius: 6,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
    }
});

// Chart: Registrasi per Bulan
const months     = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
const monthlyData = @json($monthlyChart);

new Chart(document.getElementById('chartMonthly'), {
    type: 'line',
    data: {
        labels: months,
        datasets: [{
            label: 'Registrasi',
            data: monthlyData,
            borderColor: '#4e54c8',
            backgroundColor: 'rgba(78,84,200,.1)',
            borderWidth: 2,
            fill: true,
            tension: .4,
            pointBackgroundColor: '#4e54c8',
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
    }
});
</script>
@endpush
