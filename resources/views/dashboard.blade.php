<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - SportXFest</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <style>
        /* ── Topbar ── */
        .dash-topbar {
            position: sticky; top: 0; z-index: 100;
            height: 64px;
            background: rgba(0,0,0,.45);
            backdrop-filter: blur(14px);
            border-bottom: 1px solid rgba(255,255,255,.1);
            display: flex; align-items: center;
            padding: 0 28px;
            gap: 16px;
        }
        .dash-topbar-brand {
            display: flex; align-items: center; gap: 10px;
            text-decoration: none; flex-shrink: 0;
        }
        .dash-topbar-brand img { height: 32px; }
        .dash-topbar-brand span { color: #fff; font-weight: 700; font-size: 1rem; }
        .dash-topbar-right { margin-left: auto; display: flex; align-items: center; gap: 10px; }
        .dash-user-chip {
            display: flex; align-items: center; gap: 8px;
            background: rgba(255,255,255,.1); border: 1px solid rgba(255,255,255,.15);
            border-radius: 50px; padding: 5px 14px 5px 6px;
            backdrop-filter: blur(6px);
        }
        .dash-avatar-sm {
            width: 30px; height: 30px; border-radius: 50%;
            background: linear-gradient(135deg, #ff7f50, #d633ff);
            display: flex; align-items: center; justify-content: center;
            font-size: .85rem; font-weight: 700; color: #fff; flex-shrink: 0;
        }
        .dash-user-chip span { color: rgba(255,255,255,.85); font-size: .85rem; font-weight: 500; }
        .btn-logout-sm {
            background: rgba(230,57,70,.2); border: 1px solid rgba(230,57,70,.35);
            color: #ff7f7f; border-radius: 8px; padding: 6px 14px;
            font-size: .82rem; font-weight: 600; cursor: pointer; transition: .2s;
            display: inline-flex; align-items: center; gap: 5px;
        }
        .btn-logout-sm:hover { background: rgba(230,57,70,.4); color: #fff; }

        /* ── Welcome ── */
        .welcome-section {
            max-width: 1100px; margin: 0 auto;
            padding: 40px 24px 0;
        }
        .welcome-card {
            background: rgba(255,255,255,.1);
            border: 1px solid rgba(255,255,255,.18);
            border-radius: 20px;
            padding: 28px 32px;
            backdrop-filter: blur(12px);
            display: flex; align-items: center; gap: 20px; flex-wrap: wrap;
            margin-bottom: 36px;
        }
        .welcome-avatar {
            width: 64px; height: 64px; border-radius: 50%;
            background: linear-gradient(135deg, #ff7f50, #d633ff);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.8rem; font-weight: 800; color: #fff; flex-shrink: 0;
        }
        .welcome-text h2 { color: #fff; font-size: 1.4rem; font-weight: 800; margin-bottom: 3px; }
        .welcome-text p  { color: rgba(255,255,255,.65); font-size: .88rem; margin: 0; }
        .welcome-badge {
            margin-left: auto;
            background: rgba(255,255,255,.1); border: 1px solid rgba(255,255,255,.2);
            border-radius: 50px; padding: 6px 16px;
            color: rgba(255,255,255,.75); font-size: .8rem;
            display: flex; align-items: center; gap: 6px;
        }
        .welcome-badge i { color: #ff7f50; }

        /* ── Section label ── */
        .section-lbl {
            font-size: .78rem; font-weight: 700; color: rgba(255,255,255,.5);
            text-transform: uppercase; letter-spacing: .8px;
            margin-bottom: 14px;
        }

        /* ── Menu cards ── */
        .menu-section { max-width: 1100px; margin: 0 auto; padding: 0 24px 36px; }
        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
            gap: 14px;
        }
        .menu-card {
            background: rgba(255,255,255,.1);
            border: 1px solid rgba(255,255,255,.15);
            border-radius: 16px;
            padding: 22px 16px;
            text-align: center;
            text-decoration: none;
            color: #fff;
            transition: .25s;
            backdrop-filter: blur(8px);
            display: flex; flex-direction: column; align-items: center; gap: 10px;
        }
        .menu-card:hover {
            background: rgba(255,255,255,.2);
            border-color: rgba(255,255,255,.3);
            transform: translateY(-5px);
            color: #fff;
        }
        .menu-card .mc-icon {
            width: 48px; height: 48px; border-radius: 14px;
            background: rgba(255,255,255,.15);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.3rem; transition: .25s;
        }
        .menu-card:hover .mc-icon { background: rgba(255,255,255,.25); }
        .menu-card h6 { font-weight: 700; font-size: .9rem; margin: 0; }
        .menu-card small { color: rgba(255,255,255,.55); font-size: .75rem; }
        .menu-card.admin-card { background: rgba(230,57,70,.15); border-color: rgba(230,57,70,.25); }
        .menu-card.admin-card:hover { background: rgba(230,57,70,.25); border-color: rgba(230,57,70,.4); }

        /* ── Riwayat ── */
        .history-section { max-width: 1100px; margin: 0 auto; padding: 0 24px 60px; }
        .history-card {
            background: rgba(255,255,255,.1);
            border: 1px solid rgba(255,255,255,.15);
            border-radius: 18px;
            overflow: hidden;
            backdrop-filter: blur(10px);
        }
        .history-card-header {
            padding: 18px 22px; border-bottom: 1px solid rgba(255,255,255,.1);
            display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;
        }
        .history-card-header h5 { color: #fff; font-weight: 700; font-size: 1rem; margin: 0; }
        .btn-see-all {
            color: rgba(255,255,255,.6); font-size: .82rem; text-decoration: none;
            display: flex; align-items: center; gap: 4px; transition: .2s;
        }
        .btn-see-all:hover { color: #fff; }

        /* Tabel */
        .reg-table { width: 100%; border-collapse: collapse; }
        .reg-table th {
            background: rgba(0,0,0,.25); color: rgba(255,255,255,.55);
            font-size: .72rem; font-weight: 700; text-transform: uppercase;
            letter-spacing: .5px; padding: 12px 20px; text-align: left;
        }
        .reg-table td {
            padding: 14px 20px; color: rgba(255,255,255,.85);
            font-size: .88rem; border-top: 1px solid rgba(255,255,255,.07);
        }
        .reg-table tr:hover td { background: rgba(255,255,255,.05); }
        .reg-table .td-bold { font-weight: 600; color: #fff; }
        .status-chip {
            padding: 3px 10px; border-radius: 999px;
            font-size: .72rem; font-weight: 700;
        }
        .status-chip.pending  { background: #fef3c7; color: #92400e; }
        .status-chip.approved { background: #d1fae5; color: #065f46; }
        .status-chip.rejected { background: #fee2e2; color: #991b1b; }
        .empty-row td { text-align: center; padding: 48px 20px; color: rgba(255,255,255,.4); }

        @media (max-width: 600px) {
            .welcome-card { padding: 22px 18px; }
            .menu-grid { grid-template-columns: repeat(3, 1fr); }
        }
    </style>
</head>
<body>

{{-- Topbar --}}
<header class="dash-topbar">
    <a href="{{ route('home') }}" class="dash-topbar-brand">
        <img src="{{ asset('images/LOGO.png') }}" alt="SportXFest">
        <span>SportXFest</span>
    </a>
    <div class="dash-topbar-right">
        <div class="dash-user-chip">
            <div class="dash-avatar-sm">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
            <span>{{ Auth::user()->name }}</span>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn-logout-sm">
                <i class="bi bi-box-arrow-right"></i> Keluar
            </button>
        </form>
    </div>
</header>

{{-- Welcome --}}
<div class="welcome-section">
    @if(session('success'))
        <div class="alert alert-success rounded-3 mb-3 d-flex align-items-center gap-2">
            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
        </div>
    @endif

    <div class="welcome-card">
        <div class="welcome-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
        <div class="welcome-text">
            <h2>Halo, {{ Auth::user()->name }}! 👋</h2>
            <p>{{ Auth::user()->email }} &nbsp;·&nbsp; {{ Auth::user()->isAdmin() ? 'Administrator' : 'User' }}</p>
        </div>
        <div class="welcome-badge">
            <i class="bi bi-calendar-check-fill"></i>
            {{ now()->translatedFormat('d M Y') }}
        </div>
    </div>
</div>

{{-- Menu --}}
<div class="menu-section">
    <div class="section-lbl">Navigasi Cepat</div>
    <div class="menu-grid">
        <a href="{{ route('home') }}" class="menu-card">
            <div class="mc-icon"><i class="bi bi-house-fill"></i></div>
            <h6>Home</h6>
            <small>Halaman utama</small>
        </a>
        <a href="{{ route('events.public') }}" class="menu-card">
            <div class="mc-icon"><i class="bi bi-calendar-event-fill"></i></div>
            <h6>Event</h6>
            <small>Semua lomba</small>
        </a>
        <a href="{{ route('daftar') }}" class="menu-card">
            <div class="mc-icon"><i class="bi bi-person-plus-fill"></i></div>
            <h6>Daftar</h6>
            <small>Ikut lomba</small>
        </a>
        <a href="{{ route('profile') }}" class="menu-card">
            <div class="mc-icon"><i class="bi bi-people-fill"></i></div>
            <h6>Profil Tim</h6>
            <small>Kenali kami</small>
        </a>
        <a href="{{ route('dokumentasi') }}" class="menu-card">
            <div class="mc-icon"><i class="bi bi-book-fill"></i></div>
            <h6>Dokumentasi</h6>
            <small>Panduan sistem</small>
        </a>
        <a href="{{ route('contact') }}" class="menu-card">
            <div class="mc-icon"><i class="bi bi-telephone-fill"></i></div>
            <h6>Contact</h6>
            <small>Hubungi kami</small>
        </a>
        @if(Auth::user()->isAdmin())
        <a href="{{ route('admin.dashboard') }}" class="menu-card admin-card">
            <div class="mc-icon"><i class="bi bi-speedometer2"></i></div>
            <h6>Admin</h6>
            <small>Kelola sistem</small>
        </a>
        @endif
    </div>
</div>

{{-- Riwayat Pendaftaran --}}
@php
    $myRegistrations = \App\Models\Registration::with('event')
        ->where('user_id', Auth::id())
        ->latest()->take(5)->get();
@endphp

<div class="history-section">
    <div class="section-lbl">Aktivitas Terkini</div>
    <div class="history-card">
        <div class="history-card-header">
            <h5><i class="bi bi-clock-history me-2"></i>Pendaftaran Terakhir</h5>
            <a href="{{ route('daftar') }}" class="btn-see-all">Lihat semua <i class="bi bi-arrow-right"></i></a>
        </div>
        <div class="table-responsive">
            <table class="reg-table">
                <thead>
                    <tr>
                        <th>Event</th>
                        <th>Tanggal Event</th>
                        <th>Status</th>
                        <th>Didaftarkan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($myRegistrations as $reg)
                    <tr>
                        <td class="td-bold">{{ $reg->event->title ?? '-' }}</td>
                        <td>{{ $reg->event->date?->format('d M Y') ?? '-' }}</td>
                        <td>
                            <span class="status-chip {{ $reg->status }}">
                                @if($reg->status === 'approved') Disetujui
                                @elseif($reg->status === 'rejected') Ditolak
                                @else Menunggu
                                @endif
                            </span>
                        </td>
                        <td>{{ $reg->created_at->format('d M Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center" style="padding:48px 20px;color:rgba(255,255,255,.4);">
                            <i class="bi bi-calendar-x" style="font-size:2rem;display:block;margin-bottom:10px;"></i>
                            Belum ada pendaftaran. <a href="{{ route('events.public') }}" style="color:#ff7f50;">Lihat event →</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
