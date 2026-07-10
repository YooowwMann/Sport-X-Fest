@extends('layouts.public')

@section('title', 'Daftar Event - SportXFest')

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
.page-hero h1 { font-size: clamp(1.9rem,4.5vw,3rem); font-weight: 800; color: #fff; margin-bottom: 10px; text-shadow: 0 2px 10px rgba(0,0,0,.2); }
.page-hero p  { color: rgba(255,255,255,.7); font-size: .95rem; max-width: 480px; margin: 0 auto; }

/* Filter bar */
.filter-bar {
    max-width: 700px;
    margin: 0 auto 40px;
    padding: 0 20px;
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}
.filter-btn {
    padding: 8px 20px;
    border-radius: 50px;
    border: 1px solid rgba(255,255,255,.3);
    background: rgba(255,255,255,.12);
    color: #fff;
    font-size: .85rem;
    font-weight: 500;
    cursor: pointer;
    transition: .2s;
    backdrop-filter: blur(6px);
}
.filter-btn:hover, .filter-btn.active {
    background: rgba(255,255,255,.28);
    border-color: rgba(255,255,255,.5);
}

/* Grid */
.events-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 24px;
    max-width: 1100px;
    margin: 0 auto;
    padding: 0 20px 80px;
}
.ev-card {
    background: #fff;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 8px 28px rgba(0,0,0,.16);
    transition: transform .3s, box-shadow .3s;
    display: flex; flex-direction: column;
}
.ev-card:hover { transform: translateY(-7px); box-shadow: 0 20px 45px rgba(0,0,0,.22); }
.ev-card-img { position: relative; height: 195px; overflow: hidden; }
.ev-card-img img { width: 100%; height: 100%; object-fit: cover; transition: transform .4s; }
.ev-card:hover .ev-card-img img { transform: scale(1.06); }
.ev-badge {
    position: absolute; top: 12px; left: 12px;
    padding: 4px 11px; border-radius: 999px; font-size: .7rem; font-weight: 700;
}
.ev-badge.open   { background: #d1fae5; color: #065f46; }
.ev-badge.closed { background: #fee2e2; color: #991b1b; }
.ev-quota-badge {
    position: absolute; top: 12px; right: 12px;
    background: rgba(0,0,0,.5); color: #fff;
    padding: 4px 10px; border-radius: 999px; font-size: .7rem; font-weight: 600;
    backdrop-filter: blur(4px);
}
.ev-body { padding: 20px 18px 18px; flex: 1; display: flex; flex-direction: column; }
.ev-title { font-size: 1rem; font-weight: 700; color: #111827; margin-bottom: 8px; }
.ev-desc {
    font-size: .82rem; color: #6b7280; line-height: 1.6; flex: 1; margin-bottom: 12px;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
}
.ev-meta { display: flex; flex-direction: column; gap: 4px; margin-bottom: 14px; }
.ev-meta span { font-size: .78rem; color: #6b7280; display: flex; align-items: center; gap: 5px; }
.ev-meta i { color: #e63946; font-size: .8rem; }

/* Progress bar kuota */
.quota-bar-wrap { margin-bottom: 14px; }
.quota-bar-label { display: flex; justify-content: space-between; font-size: .72rem; color: #9ca3af; margin-bottom: 5px; }
.quota-bar { height: 5px; background: #f3f4f6; border-radius: 999px; overflow: hidden; }
.quota-bar-fill { height: 100%; border-radius: 999px; background: linear-gradient(90deg, #e63946, #d633ff); transition: width .4s; }

.ev-footer { border-top: 1px solid #f3f4f6; padding-top: 14px; display: flex; justify-content: space-between; align-items: center; gap: 8px; }
.btn-join {
    background: linear-gradient(135deg,#e63946,#d633ff);
    color: #fff; font-weight: 600; padding: 8px 18px;
    border-radius: 50px; font-size: .82rem; border: none;
    text-decoration: none; transition: .2s; white-space: nowrap;
}
.btn-join:hover { color: #fff; opacity: .88; transform: translateY(-1px); }
.btn-disabled { background: #e5e7eb; color: #9ca3af; padding: 8px 18px; border-radius: 50px; font-size: .82rem; cursor: not-allowed; }
</style>
@endpush

@section('content')

<section class="page-hero">
    <div class="tag"><i class="bi bi-calendar-event-fill"></i> Semua Event</div>
    <h1>Daftar Event Lomba</h1>
    <p>Temukan event olahraga yang sesuai kemampuanmu dan daftar sekarang</p>
</section>

<div class="filter-bar">
    <button class="filter-btn active" onclick="filterEvents('all', this)">Semua</button>
    <button class="filter-btn" onclick="filterEvents('open', this)">Dibuka</button>
    <button class="filter-btn" onclick="filterEvents('closed', this)">Ditutup</button>
</div>

@if(session('success'))
    <div class="container"><div class="alert alert-success rounded-3">{{ session('success') }}</div></div>
@endif

<div class="events-grid" id="eventsGrid">
    @forelse($events as $event)
    @php $pct = $event->quota > 0 ? round(($event->approved_count / $event->quota) * 100) : 0; @endphp
    <div class="ev-card" id="event-{{ $event->id }}" data-status="{{ $event->status }}">
        <div class="ev-card-img">
            @if($event->image)
                <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->title }}">
            @else
                <img src="https://images.unsplash.com/photo-1517649763962-0c623066013b?auto=format&fit=crop&w=900&q=80" alt="{{ $event->title }}">
            @endif
            <span class="ev-badge {{ $event->status }}">
                {{ $event->status === 'open' ? 'Dibuka' : 'Ditutup' }}
            </span>
            <span class="ev-quota-badge">
                <i class="bi bi-people-fill me-1"></i>{{ $event->approved_count }}/{{ $event->quota }}
            </span>
        </div>
        <div class="ev-body">
            <div class="ev-title">{{ $event->title }}</div>
            <div class="ev-desc">{{ $event->description }}</div>
            <div class="ev-meta">
                <span><i class="bi bi-calendar3"></i> {{ $event->date->format('d M Y') }}</span>
                <span><i class="bi bi-geo-alt-fill"></i> {{ $event->location }}</span>
            </div>
            <div class="quota-bar-wrap">
                <div class="quota-bar-label">
                    <span>Kuota terisi</span>
                    <span>{{ $pct }}%</span>
                </div>
                <div class="quota-bar">
                    <div class="quota-bar-fill" style="width:{{ $pct }}%"></div>
                </div>
            </div>
            <div class="ev-footer">
                @auth
                    @if($event->status === 'open' && $event->remaining_quota > 0)
                        <a href="{{ route('daftar', ['event_id' => $event->id]) }}" class="btn-join">
                            Ikuti Lomba <i class="bi bi-arrow-right"></i>
                        </a>
                    @else
                        <span class="btn-disabled">Kuota Penuh</span>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn-join">Login untuk Daftar</a>
                @endauth
                <small style="color:#9ca3af;font-size:.72rem;">Sisa {{ $event->remaining_quota }}</small>
            </div>
        </div>
    </div>
    @empty
    <div style="grid-column:1/-1;text-align:center;padding:60px;color:rgba(255,255,255,.5);">
        <i class="bi bi-calendar-x" style="font-size:3rem;display:block;margin-bottom:12px;"></i>
        Belum ada event tersedia.
    </div>
    @endforelse
</div>

@endsection

@push('scripts')
<script>
function filterEvents(status, btn) {
    document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    document.querySelectorAll('.ev-card').forEach(card => {
        card.style.display = (status === 'all' || card.dataset.status === status) ? '' : 'none';
    });
}
</script>
@endpush
