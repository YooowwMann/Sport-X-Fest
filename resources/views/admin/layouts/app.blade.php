<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') — SportX Fest</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }
        body { display: flex; min-height: 100vh; background: #f0f2f5; }

        /* ── Sidebar ── */
        .sidebar {
            width: 250px; min-height: 100vh;
            background: linear-gradient(180deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            display: flex; flex-direction: column;
            position: fixed; top: 0; left: 0; bottom: 0;
            z-index: 100; transition: width .3s;
        }
        .sidebar-brand {
            padding: 20px 20px 16px; border-bottom: 1px solid rgba(255,255,255,.1);
            text-align: center;
        }
        .sidebar-brand .brand-logo {
            width: 100px; height: 50px; object-fit: contain;
            border-radius: 8px;
            margin-bottom: 8px;
            display: block; margin-left: auto; margin-right: auto;
        }
        .sidebar-brand h2 { color: #fff; font-size: 1.1rem; font-weight: 700; letter-spacing: .5px; }
        .sidebar-brand span { color: rgba(255,255,255,.4); font-size: .72rem; }
        .sidebar-nav { flex: 1; padding: 16px 0; overflow-y: auto; }
        .nav-section { padding: 8px 20px 4px; color: rgba(255,255,255,.3); font-size: .65rem; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; }
        .nav-item { display: flex; align-items: center; gap: 12px; padding: 12px 20px; color: rgba(255,255,255,.7); text-decoration: none; font-size: .875rem; transition: all .2s; border-left: 3px solid transparent; }
        .nav-item:hover, .nav-item.active { background: rgba(233,69,96,.15); color: #fff; border-left-color: #e94560; }
        .nav-item i { width: 18px; text-align: center; }
        .sidebar-footer { padding: 16px 20px; border-top: 1px solid rgba(255,255,255,.1); }
        .admin-info { display: flex; align-items: center; gap: 10px; margin-bottom: 12px; }
        .admin-avatar { width: 36px; height: 36px; background: #e94560; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 700; font-size: .9rem; }
        .admin-name { color: #fff; font-size: .875rem; font-weight: 600; }
        .admin-role { color: rgba(255,255,255,.4); font-size: .75rem; }

        /* ── Main Content ── */
        .main { margin-left: 250px; flex: 1; display: flex; flex-direction: column; min-height: 100vh; }
        .topbar { background: #fff; padding: 16px 28px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 4px rgba(0,0,0,.06); position: sticky; top: 0; z-index: 50; }
        .topbar-title { font-size: 1.25rem; font-weight: 700; color: #1a1a2e; }
        .topbar-right { display: flex; align-items: center; gap: 12px; }
        .content { padding: 28px; flex: 1; }

        /* ── Cards ── */
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; margin-bottom: 28px; }
        .stat-card { background: #fff; border-radius: 12px; padding: 24px; display: flex; align-items: center; gap: 16px; box-shadow: 0 2px 8px rgba(0,0,0,.06); }
        .stat-icon { width: 56px; height: 56px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; color: #fff; flex-shrink: 0; }
        .stat-icon.blue   { background: linear-gradient(135deg, #4e54c8, #8f94fb); }
        .stat-icon.green  { background: linear-gradient(135deg, #11998e, #38ef7d); }
        .stat-icon.orange { background: linear-gradient(135deg, #f7971e, #ffd200); }
        .stat-icon.red    { background: linear-gradient(135deg, #e94560, #f72585); }
        .stat-value { font-size: 1.8rem; font-weight: 700; color: #1a1a2e; line-height: 1; }
        .stat-label { color: #6b7280; font-size: .8rem; margin-top: 4px; }

        /* ── Table ── */
        .card { background: #fff; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,.06); overflow: hidden; margin-bottom: 24px; }
        .card-header { padding: 20px 24px; border-bottom: 1px solid #f3f4f6; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; }
        .card-title { font-weight: 700; color: #1a1a2e; font-size: 1rem; }
        .card-body { padding: 0; }
        table { width: 100%; border-collapse: collapse; }
        thead th { background: #f8fafc; padding: 12px 16px; font-size: .75rem; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: .5px; text-align: left; }
        tbody td { padding: 14px 16px; border-top: 1px solid #f3f4f6; font-size: .875rem; color: #374151; vertical-align: middle; }
        tbody tr:hover { background: #fafafa; }

        /* ── Badge ── */
        .badge { display: inline-flex; align-items: center; padding: 3px 10px; border-radius: 20px; font-size: .72rem; font-weight: 600; }
        .badge-admin    { background: #fef3c7; color: #92400e; }
        .badge-user     { background: #dbeafe; color: #1e40af; }
        .badge-active   { background: #d1fae5; color: #065f46; }
        .badge-inactive { background: #fee2e2; color: #991b1b; }
        .badge-open     { background: #d1fae5; color: #065f46; }
        .badge-closed   { background: #fee2e2; color: #991b1b; }
        .badge-pending  { background: #fef3c7; color: #92400e; }
        .badge-approved { background: #d1fae5; color: #065f46; }
        .badge-rejected { background: #fee2e2; color: #991b1b; }

        /* ── Buttons ── */
        .btn { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: 8px; font-size: .875rem; font-weight: 500; cursor: pointer; border: none; text-decoration: none; transition: all .2s; }
        .btn-primary  { background: #e94560; color: #fff; }
        .btn-primary:hover  { background: #c73652; }
        .btn-success  { background: #10b981; color: #fff; }
        .btn-success:hover  { background: #059669; }
        .btn-warning  { background: #f59e0b; color: #fff; }
        .btn-warning:hover  { background: #d97706; }
        .btn-danger   { background: #ef4444; color: #fff; }
        .btn-danger:hover   { background: #dc2626; }
        .btn-secondary { background: #f3f4f6; color: #374151; }
        .btn-secondary:hover { background: #e5e7eb; }
        .btn-sm { padding: 5px 10px; font-size: .8rem; }

        /* ── Form ── */
        .form-group { margin-bottom: 18px; }
        .form-label { display: block; margin-bottom: 6px; font-size: .875rem; font-weight: 500; color: #374151; }
        .form-control { width: 100%; padding: 10px 14px; border: 1px solid #d1d5db; border-radius: 8px; font-size: .875rem; color: #374151; outline: none; transition: border-color .2s; }
        .form-control:focus { border-color: #e94560; box-shadow: 0 0 0 3px rgba(233,69,96,.1); }
        .form-control.is-invalid { border-color: #ef4444; }
        .invalid-feedback { color: #ef4444; font-size: .8rem; margin-top: 4px; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }

        /* ── Alert ── */
        .alert { padding: 12px 16px; border-radius: 8px; font-size: .875rem; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; }
        .alert-success { background: #d1fae5; color: #065f46; border-left: 4px solid #10b981; }
        .alert-error   { background: #fee2e2; color: #991b1b; border-left: 4px solid #ef4444; }
        .alert-warning { background: #fef3c7; color: #92400e; border-left: 4px solid #f59e0b; }

        /* ── Search bar ── */
        .filter-bar { display: flex; gap: 10px; flex-wrap: wrap; align-items: center; }
        .filter-bar .form-control { width: auto; flex: 1; min-width: 180px; }
        .filter-bar select.form-control { width: auto; }

        /* ── Pagination ── */
        .pagination-wrapper { display: flex; justify-content: space-between; align-items: center; padding: 14px 24px; background: #f8fafc; border-top: 1px solid #f3f4f6; font-size: .8rem; color: #6b7280; flex-wrap: wrap; gap: 10px; }
        .pagination-wrapper nav { display: flex; }
        .pagination-wrapper .pagination { display: flex; gap: 4px; list-style: none; }
        .pagination-wrapper .page-item .page-link { padding: 6px 12px; border: 1px solid #e5e7eb; border-radius: 6px; color: #374151; text-decoration: none; font-size: .8rem; }
        .pagination-wrapper .page-item.active .page-link { background: #e94560; color: #fff; border-color: #e94560; }
        .pagination-wrapper .page-item.disabled .page-link { opacity: .4; pointer-events: none; }

        /* ── Image preview ── */
        #imagePreview { margin-top: 10px; max-width: 200px; border-radius: 8px; display: none; }

        /* ── Logout btn ── */
        .btn-logout { background: rgba(233,69,96,.15); color: #e94560; border: none; cursor: pointer; border-radius: 8px; padding: 10px 16px; width: 100%; font-size: .875rem; font-weight: 500; display: flex; align-items: center; gap: 8px; justify-content: center; transition: background .2s; }
        .btn-logout:hover { background: rgba(233,69,96,.25); }

        /* ── Chart container ── */
        .charts-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 24px; }
        .chart-card { background: #fff; border-radius: 12px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,.06); }
        .chart-title { font-weight: 700; color: #1a1a2e; margin-bottom: 16px; font-size: .95rem; }

        /* ── Responsive ── */
        @media (max-width: 768px) {
            .sidebar { width: 0; overflow: hidden; }
            .main { margin-left: 0; }
            .charts-grid { grid-template-columns: 1fr; }
            .form-row { grid-template-columns: 1fr; }
        }
    </style>
    @stack('styles')
</head>
<body>

{{-- ── Sidebar ────────────────── --}}
<aside class="sidebar">
    <div class="sidebar-brand">
        <img src="{{ asset('images/LOGO.png') }}" alt="SportX Fest Logo" class="brand-logo">
        <!-- <h2>SportX Fest</h2> -->
        <span>Admin Panel</span>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section">Main</div>
        <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>

        <div class="nav-section">Management</div>
        <a href="{{ route('admin.users.index') }}" class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <i class="fas fa-users"></i> Users
        </a>
        <a href="{{ route('admin.events.index') }}" class="nav-item {{ request()->routeIs('admin.events.*') ? 'active' : '' }}">
            <i class="fas fa-calendar-alt"></i> Events
        </a>
        <a href="{{ route('admin.registrations.index') }}" class="nav-item {{ request()->routeIs('admin.registrations.*') ? 'active' : '' }}">
            <i class="fas fa-clipboard-list"></i> Registrations
        </a>

        <div class="nav-section">System</div>
        <a href="{{ route('admin.logs.index') }}" class="nav-item {{ request()->routeIs('admin.logs.*') ? 'active' : '' }}">
            <i class="fas fa-history"></i> Activity Log
        </a>
    </nav>

    <div class="sidebar-footer">
        <div class="admin-info">
            <div class="admin-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
            <div>
                <div class="admin-name">{{ Auth::user()->name }}</div>
                <div class="admin-role">Administrator</div>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn-logout">
                <i class="fas fa-sign-out-alt"></i> Logout
            </button>
        </form>
    </div>
</aside>

{{-- ── Main Content ────────────────── --}}
<div class="main">
    <div class="topbar">
        <div class="topbar-title">@yield('page-title', 'Dashboard')</div>
        <div class="topbar-right">
            <span style="font-size:.8rem;color:#6b7280;">
                <i class="fas fa-clock"></i> {{ now()->format('d M Y, H:i') }}
            </span>
        </div>
    </div>

    <div class="content">
        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
        @endif
        @if(session('warning'))
            <div class="alert alert-warning"><i class="fas fa-exclamation-triangle"></i> {{ session('warning') }}</div>
        @endif

        @yield('content')
    </div>
</div>

<script>
// Auto-hide alerts
setTimeout(() => {
    document.querySelectorAll('.alert').forEach(el => {
        el.style.transition = 'opacity .5s';
        el.style.opacity = '0';
        setTimeout(() => el.remove(), 500);
    });
}, 4000);

// SweetAlert confirm delete
function confirmDelete(formId, name) {
    Swal.fire({
        title: 'Hapus ' + name + '?',
        text: 'Data yang dihapus tidak bisa dikembalikan!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e94560',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(formId).submit();
        }
    });
}
</script>

@stack('scripts')
</body>
</html>
