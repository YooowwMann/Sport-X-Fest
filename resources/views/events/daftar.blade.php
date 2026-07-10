@extends('layouts.public')

@section('title', 'Pendaftaran Event - SportXFest')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
<style>
.page-hero {
    text-align: center;
    padding: 80px 20px 50px;
}
.page-hero .tag {
    display: inline-flex; align-items: center; gap: 6px;
    background: rgba(255,255,255,.15); border: 1px solid rgba(255,255,255,.28);
    color: #fff; padding: 4px 14px; border-radius: 999px;
    font-size: .75rem; font-weight: 600; letter-spacing: .5px;
    text-transform: uppercase; margin-bottom: 14px;
}
.page-hero h1 { font-size: clamp(1.9rem,4vw,2.8rem); font-weight: 800; color: #fff; margin-bottom: 10px; text-shadow: 0 2px 10px rgba(0,0,0,.2); }
.page-hero p  { color: rgba(255,255,255,.7); font-size: .95rem; }

/* Layout dua kolom */
.daftar-layout {
    display: grid;
    grid-template-columns: 380px 1fr;
    gap: 28px;
    max-width: 1100px;
    margin: 0 auto;
    padding: 0 20px 80px;
    align-items: start;
}

/* Panel kiri — form */
.form-panel {
    background: rgba(255,255,255,.97);
    border-radius: 20px;
    padding: 32px 28px;
    box-shadow: 0 10px 40px rgba(0,0,0,.18);
    position: sticky;
    top: 88px;
}
.form-panel h3 {
    font-size: 1.15rem; font-weight: 700; color: #111827; margin-bottom: 4px;
}
.form-panel .subtitle { font-size: .85rem; color: #6b7280; margin-bottom: 24px; }
.form-panel .form-label { color: #374151; font-weight: 600; font-size: .88rem; }
.form-panel .form-select {
    border: 1.5px solid #e5e7eb; border-radius: 10px; color: #111827;
    background: #f9fafb; padding: 11px 14px; font-size: .9rem;
}
.form-panel .form-select:focus {
    border-color: #e63946; box-shadow: 0 0 0 3px rgba(230,57,70,.12); background: #fff; color: #111827;
}
.btn-daftar {
    width: 100%;
    background: linear-gradient(135deg,#e63946,#d633ff);
    color: #fff; font-weight: 700; padding: 13px;
    border-radius: 12px; border: none; font-size: 1rem;
    transition: .25s; display: flex; align-items: center; justify-content: center; gap: 8px;
}
.btn-daftar:hover { opacity: .9; transform: translateY(-1px); }
.info-note {
    display: flex; align-items: flex-start; gap: 10px;
    background: #eff6ff; border: 1px solid #bfdbfe;
    border-radius: 10px; padding: 12px 14px; margin-top: 16px;
}
.info-note i { color: #3b82f6; flex-shrink: 0; margin-top: 2px; }
.info-note span { font-size: .8rem; color: #1e40af; line-height: 1.6; }

/* Panel kanan — riwayat */
.history-panel {}
.history-panel h3 {
    font-size: 1.15rem; font-weight: 700; color: #fff; margin-bottom: 6px;
}
.history-panel .subtitle { font-size: .85rem; color: rgba(255,255,255,.6); margin-bottom: 20px; }

/* Riwayat cards */
.reg-card {
    background: rgba(255,255,255,.12);
    border: 1px solid rgba(255,255,255,.18);
    border-radius: 16px;
    padding: 18px 20px;
    backdrop-filter: blur(10px);
    margin-bottom: 14px;
    transition: .25s;
}
.reg-card:hover { background: rgba(255,255,255,.18); }
.reg-card-header { display: flex; justify-content: space-between; align-items: flex-start; gap: 10px; margin-bottom: 10px; }
.reg-card-title { font-size: .95rem; font-weight: 700; color: #fff; }
.reg-status {
    padding: 3px 10px; border-radius: 999px; font-size: .72rem; font-weight: 700;
    white-space: nowrap; flex-shrink: 0;
}
.reg-status.pending  { background: #fef3c7; color: #92400e; }
.reg-status.approved { background: #d1fae5; color: #065f46; }
.reg-status.rejected { background: #fee2e2; color: #991b1b; }
.reg-card-meta { display: flex; gap: 16px; flex-wrap: wrap; }
.reg-card-meta span { font-size: .78rem; color: rgba(255,255,255,.6); display: flex; align-items: center; gap: 5px; }
.reg-card-meta i { color: rgba(255,255,255,.4); }
.empty-state {
    text-align: center; padding: 48px 20px;
    background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.12);
    border-radius: 16px; color: rgba(255,255,255,.5);
}
.empty-state i { font-size: 2.8rem; display: block; margin-bottom: 12px; }

@media (max-width: 768px) {
    .daftar-layout { grid-template-columns: 1fr; }
    .form-panel { position: static; }
}
</style>
@endpush

@section('content')

<section class="page-hero">
    <div class="tag"><i class="bi bi-person-plus-fill"></i> Registrasi</div>
    <h1>Daftar Event</h1>
    <p>Pilih event favoritmu dan bergabung bersama ribuan pelari</p>
</section>

@if(session('success'))
    <div class="container mb-4"><div class="alert alert-success rounded-3 d-flex align-items-center gap-2"><i class="bi bi-check-circle-fill"></i> {{ session('success') }}</div></div>
@endif
@if(session('error'))
    <div class="container mb-4"><div class="alert alert-danger rounded-3 d-flex align-items-center gap-2"><i class="bi bi-exclamation-circle-fill"></i> {{ session('error') }}</div></div>
@endif
@if($errors->any())
    <div class="container mb-4">
        <div class="alert alert-danger rounded-3">
            <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    </div>
@endif

<div class="daftar-layout">

    {{-- Form Panel --}}
    <div class="form-panel">
        <h3><i class="bi bi-clipboard-check me-2 text-danger"></i>Form Pendaftaran</h3>
        <p class="subtitle">Isi form di bawah untuk mendaftar event</p>
        <form action="{{ route('proses_daftar') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="form-label">Pilih Event</label>
                <select name="event_id" class="form-select" required>
                    <option value="">-- Pilih Event --</option>
                    @foreach($events as $event)
                        <option value="{{ $event->id }}"
                            {{ old('event_id', $id_event ?? '') == $event->id ? 'selected' : '' }}>
                            {{ $event->title }} ({{ $event->date->format('d M Y') }}) — sisa {{ $event->remaining_quota }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn-daftar">
                <i class="bi bi-send-fill"></i> Daftar Sekarang
            </button>
        </form>
        <div class="info-note">
            <i class="bi bi-info-circle-fill"></i>
            <span>Pendaftaran akan berstatus <strong>Menunggu</strong> hingga disetujui admin. Kamu akan terdaftar otomatis setelah disetujui.</span>
        </div>
    </div>

    {{-- Riwayat Panel --}}
    <div class="history-panel">
        <h3><i class="bi bi-clock-history me-2"></i>Riwayat Pendaftaranku</h3>
        <p class="subtitle">{{ $myRegistrations->count() }} pendaftaran tercatat</p>

        @if($myRegistrations->isEmpty())
        <div class="empty-state">
            <i class="bi bi-calendar-x"></i>
            <p class="mb-3">Belum ada pendaftaran.</p>
            <p class="mb-0" style="font-size:.85rem;">Pilih event di sebelah kiri untuk mendaftar!</p>
        </div>
        @else
            @foreach($myRegistrations as $reg)
            <div class="reg-card">
                <div class="reg-card-header">
                    <div class="reg-card-title">{{ $reg->event->title ?? '-' }}</div>
                    <span class="reg-status {{ $reg->status }}">
                        @if($reg->status === 'approved') Disetujui
                        @elseif($reg->status === 'rejected') Ditolak
                        @else Menunggu
                        @endif
                    </span>
                </div>
                <div class="reg-card-meta">
                    <span><i class="bi bi-calendar3"></i> {{ $reg->event->date?->format('d M Y') ?? '-' }}</span>
                    <span><i class="bi bi-geo-alt"></i> {{ $reg->event->location ?? '-' }}</span>
                    <span><i class="bi bi-clock"></i> Daftar {{ $reg->created_at->format('d M Y') }}</span>
                </div>
            </div>
            @endforeach
        @endif
    </div>

</div>

@endsection
