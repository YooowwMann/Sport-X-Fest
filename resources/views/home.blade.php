@extends('layouts.public')

@section('title', 'Home - SportXFest')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
<style>
/* ── Hero ── */
.hero-home {
    position: relative;
    text-align: center;
    padding: 110px 20px 80px;
    overflow: hidden;
}
.hero-home::before {
    content: '';
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,.18);
    z-index: 0;
}
.hero-home > * { position: relative; z-index: 1; }
.hero-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: rgba(255,255,255,.15);
    border: 1px solid rgba(255,255,255,.3);
    color: #fff;
    padding: 5px 16px;
    border-radius: 999px;
    font-size: .78rem;
    font-weight: 600;
    letter-spacing: .6px;
    text-transform: uppercase;
    margin-bottom: 20px;
}
.hero-home h1 {
    font-size: clamp(2.2rem, 5vw, 3.6rem);
    font-weight: 800;
    color: #fff;
    text-shadow: 0 3px 16px rgba(0,0,0,.3);
    margin-bottom: 16px;
    line-height: 1.15;
}
.hero-home h1 span {
    background: linear-gradient(90deg,#ff7f50,#d633ff);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
.hero-home .lead {
    color: rgba(255,255,255,.85);
    font-size: 1.1rem;
    max-width: 520px;
    margin: 0 auto 36px;
    line-height: 1.7;
}
.hero-cta { display: flex; gap: 14px; justify-content: center; flex-wrap: wrap; }
.btn-hero-primary {
    background: linear-gradient(135deg,#ff7f50,#e63946);
    color: #fff;
    font-weight: 700;
    padding: 13px 28px;
    border-radius: 50px;
    border: none;
    font-size: 1rem;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: .25s;
    box-shadow: 0 6px 20px rgba(230,57,70,.4);
}
.btn-hero-primary:hover { transform: translateY(-2px); color: #fff; box-shadow: 0 10px 28px rgba(230,57,70,.5); }
.btn-hero-secondary {
    background: rgba(255,255,255,.15);
    color: #fff;
    font-weight: 600;
    padding: 13px 28px;
    border-radius: 50px;
    border: 1px solid rgba(255,255,255,.35);
    font-size: 1rem;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: .25s;
    backdrop-filter: blur(6px);
}
.btn-hero-secondary:hover { background: rgba(255,255,255,.25); color: #fff; transform: translateY(-2px); }

/* ── Stats bar ── */
.stats-bar {
    display: flex;
    justify-content: center;
    gap: 0;
    flex-wrap: wrap;
    margin: 56px auto 0;
    max-width: 700px;
}
.stat-block {
    flex: 1;
    min-width: 140px;
    text-align: center;
    padding: 20px 16px;
    background: rgba(255,255,255,.1);
    border: 1px solid rgba(255,255,255,.15);
    backdrop-filter: blur(10px);
}
.stat-block:first-child { border-radius: 16px 0 0 16px; }
.stat-block:last-child  { border-radius: 0 16px 16px 0; }
.stat-block + .stat-block { border-left: none; }
.stat-block .num {
    font-size: 2rem;
    font-weight: 800;
    color: #fff;
    line-height: 1;
    text-shadow: 0 2px 8px rgba(0,0,0,.2);
}
.stat-block .lbl {
    font-size: .72rem;
    color: rgba(255,255,255,.6);
    text-transform: uppercase;
    letter-spacing: .5px;
    margin-top: 5px;
}

/* ── Section ── */
.section-title {
    text-align: center;
    padding: 64px 20px 36px;
}
.section-title .tag {
    display: inline-block;
    background: rgba(255,255,255,.15);
    border: 1px solid rgba(255,255,255,.25);
    color: #fff;
    padding: 4px 14px;
    border-radius: 999px;
    font-size: .75rem;
    font-weight: 600;
    letter-spacing: .5px;
    text-transform: uppercase;
    margin-bottom: 12px;
}
.section-title h2 {
    font-size: 1.9rem;
    font-weight: 800;
    color: #fff;
    margin-bottom: 8px;
    text-shadow: 0 2px 8px rgba(0,0,0,.2);
}
.section-title p { color: rgba(255,255,255,.65); font-size: .95rem; }

/* ── Event cards ── */
.events-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 24px;
    max-width: 1100px;
    margin: 0 auto;
    padding: 0 20px 80px;
}
.ev-card {
    background: #fff;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 8px 30px rgba(0,0,0,.18);
    transition: transform .3s, box-shadow .3s;
    display: flex;
    flex-direction: column;
}
.ev-card:hover { transform: translateY(-7px); box-shadow: 0 18px 45px rgba(0,0,0,.25); }
.ev-card-img {
    position: relative;
    height: 200px;
    overflow: hidden;
}
.ev-card-img img {
    width: 100%; height: 100%;
    object-fit: cover;
    transition: transform .4s;
}
.ev-card:hover .ev-card-img img { transform: scale(1.05); }
.ev-card-badge {
    position: absolute;
    top: 12px; left: 12px;
    padding: 4px 12px;
    border-radius: 999px;
    font-size: .72rem;
    font-weight: 700;
    letter-spacing: .3px;
}
.ev-card-badge.open   { background: #d1fae5; color: #065f46; }
.ev-card-badge.closed { background: #fee2e2; color: #991b1b; }
.ev-card-quota {
    position: absolute;
    top: 12px; right: 12px;
    background: rgba(0,0,0,.55);
    color: #fff;
    padding: 4px 10px;
    border-radius: 999px;
    font-size: .72rem;
    font-weight: 600;
    backdrop-filter: blur(4px);
}
.ev-card-body {
    padding: 22px 20px 20px;
    flex: 1;
    display: flex;
    flex-direction: column;
}
.ev-card-title {
    font-size: 1.05rem;
    font-weight: 700;
    color: #1a1a2e;
    margin-bottom: 8px;
}
.ev-card-desc {
    font-size: .85rem;
    color: #6b7280;
    line-height: 1.6;
    flex: 1;
    margin-bottom: 14px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.ev-card-meta {
    display: flex;
    flex-direction: column;
    gap: 4px;
    margin-bottom: 16px;
}
.ev-card-meta span {
    font-size: .8rem;
    color: #6b7280;
    display: flex;
    align-items: center;
    gap: 6px;
}
.ev-card-meta i { color: #e63946; }
.ev-card-footer {
    border-top: 1px solid #f3f4f6;
    padding-top: 14px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.btn-join {
    background: linear-gradient(135deg,#e63946,#d633ff);
    color: #fff;
    font-weight: 600;
    padding: 8px 20px;
    border-radius: 50px;
    font-size: .85rem;
    border: none;
    text-decoration: none;
    transition: .25s;
}
.btn-join:hover { color: #fff; opacity: .88; transform: translateY(-1px); }
.btn-join:disabled, .btn-join.disabled { background: #dee2e6; color: #6c757d; cursor: not-allowed; }
.view-all-wrap { text-align: center; padding-bottom: 60px; }
.btn-view-all {
    background: rgba(255,255,255,.15);
    color: #fff;
    border: 1px solid rgba(255,255,255,.3);
    padding: 12px 32px;
    border-radius: 50px;
    font-weight: 600;
    font-size: .95rem;
    text-decoration: none;
    transition: .25s;
    backdrop-filter: blur(6px);
    display: inline-flex;
    align-items: center;
    gap: 8px;
}
.btn-view-all:hover { background: rgba(255,255,255,.25); color: #fff; transform: translateY(-2px); }

/* ── Features section ── */
.features-section {
    padding: 0 20px 80px;
    max-width: 1000px;
    margin: 0 auto;
}
.feature-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 20px;
}
.feature-card {
    background: rgba(255,255,255,.1);
    border: 1px solid rgba(255,255,255,.15);
    border-radius: 16px;
    padding: 28px 22px;
    backdrop-filter: blur(10px);
    transition: .3s;
}
.feature-card:hover {
    background: rgba(255,255,255,.18);
    transform: translateY(-4px);
}
.feature-icon {
    width: 50px; height: 50px;
    border-radius: 14px;
    background: rgba(255,255,255,.15);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.4rem;
    margin-bottom: 16px;
}
.feature-card h5 { color: #fff; font-weight: 700; font-size: 1rem; margin-bottom: 8px; }
.feature-card p  { color: rgba(255,255,255,.65); font-size: .85rem; line-height: 1.6; margin: 0; }
</style>
@endpush

@section('content')

{{-- HERO --}}
<section class="hero-home">
    <div class="hero-eyebrow"><i class="bi bi-lightning-fill"></i> Platform Event Olahraga #1</div>
    <h1>Berlari Lebih Jauh,<br><span>Bersama SportXFest</span></h1>
    <p class="lead">Jelajahi event lari terbaik se-Indonesia. Daftar mudah, gratis, dan langsung terhubung dengan ribuan pelari.</p>
    <div class="hero-cta">
        <a href="{{ route('events.public') }}" class="btn-hero-primary">
            <i class="bi bi-calendar-event-fill"></i> Lihat Semua Event
        </a>
        @auth
            <a href="{{ route('daftar') }}" class="btn-hero-secondary">
                <i class="bi bi-person-plus"></i> Daftar Sekarang
            </a>
        @else
            <a href="{{ route('login') }}" class="btn-hero-secondary">
                <i class="bi bi-box-arrow-in-right"></i> Masuk Dulu
            </a>
        @endauth
    </div>

    {{-- Stats --}}
    <div class="stats-bar">
        <div class="stat-block">
            <div class="num">8+</div>
            <div class="lbl">Event Aktif</div>
        </div>
        <div class="stat-block">
            <div class="num">3K+</div>
            <div class="lbl">Peserta</div>
        </div>
        <div class="stat-block">
            <div class="num">10+</div>
            <div class="lbl">Kota</div>
        </div>
        <div class="stat-block">
            <div class="num">100%</div>
            <div class="lbl">Gratis Daftar</div>
        </div>
    </div>
</section>

{{-- UPCOMING EVENTS --}}
<div class="section-title">
    <div class="tag"><i class="bi bi-fire me-1"></i>Upcoming</div>
    <h2>Event Terdekat</h2>
    <p>Jangan sampai kehabisan kuota — daftar sekarang sebelum terlambat</p>
</div>

<div class="events-grid">
    @forelse($events as $event)
    <div class="ev-card">
        <div class="ev-card-img">
            @if($event->image)
                <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->title }}">
            @else
                <img src="https://images.unsplash.com/photo-1517649763962-0c623066013b?auto=format&fit=crop&w=900&q=80" alt="{{ $event->title }}">
            @endif
            <span class="ev-card-badge {{ $event->status }}">
                {{ $event->status === 'open' ? 'Dibuka' : 'Ditutup' }}
            </span>
            <span class="ev-card-quota">
                {{ $event->approved_count }}/{{ $event->quota }}
            </span>
        </div>
        <div class="ev-card-body">
            <div class="ev-card-title">{{ $event->title }}</div>
            <div class="ev-card-desc">{{ $event->description }}</div>
            <div class="ev-card-meta">
                <span><i class="bi bi-calendar3"></i> {{ $event->date->format('d M Y') }}</span>
                <span><i class="bi bi-geo-alt-fill"></i> {{ $event->location }}</span>
            </div>
            <div class="ev-card-footer">
                @auth
                    <a href="{{ route('daftar', ['event_id' => $event->id]) }}" class="btn-join">
                        Ikuti Lomba <i class="bi bi-arrow-right"></i>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn-join">
                        Login untuk Daftar
                    </a>
                @endauth
                <small style="color:#9ca3af;font-size:.75rem;">
                    Sisa {{ $event->remaining_quota }} slot
                </small>
            </div>
        </div>
    </div>
    @empty
    <div style="grid-column:1/-1;text-align:center;padding:60px;color:rgba(255,255,255,.5);">
        <i class="bi bi-calendar-x" style="font-size:3rem;display:block;margin-bottom:12px;"></i>
        Belum ada event tersedia saat ini.
    </div>
    @endforelse
</div>

<div class="view-all-wrap">
    <a href="{{ route('events.public') }}" class="btn-view-all">
        Lihat Semua Event <i class="bi bi-arrow-right"></i>
    </a>
</div>

{{-- FEATURES --}}
<div class="section-title" style="padding-top:20px;">
    <div class="tag">Kenapa SportXFest?</div>
    <h2>Serba Mudah, Serba Gratis</h2>
    <p>Platform terpercaya untuk para pelari di seluruh Indonesia</p>
</div>

<div class="features-section">
    <div class="feature-grid">
        <div class="feature-card">
            <div class="feature-icon">🏃</div>
            <h5>Event Beragam</h5>
            <p>Marathon, fun run, trail run, sprint — semua kategori tersedia untuk semua level.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">⚡</div>
            <h5>Daftar Cepat</h5>
            <p>Pendaftaran online dalam hitungan detik. Tidak perlu antri atau isi formulir panjang.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">🎯</div>
            <h5>Kuota Terbatas</h5>
            <p>Sistem kuota otomatis memastikan setiap peserta mendapat pengalaman terbaik.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">🏆</div>
            <h5>Hadiah Menarik</h5>
            <p>Berbagai event berhadiah menarik menanti para finisher terbaik di setiap kategori.</p>
        </div>
    </div>
</div>

@endsection
