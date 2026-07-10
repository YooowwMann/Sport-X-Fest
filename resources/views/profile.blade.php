@extends('layouts.public')

@section('title', 'Profil Tim - SportXFest')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
<style>
    /* ── Hero ── */
    .profile-hero {
        text-align: center;
        padding: 80px 20px 50px;
    }
    .profile-hero .eyebrow {
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
        margin-bottom: 18px;
    }
    .profile-hero h1 {
        font-size: clamp(1.9rem, 4.5vw, 3rem);
        font-weight: 800;
        color: #fff;
        text-shadow: 0 2px 12px rgba(0,0,0,.25);
        margin-bottom: 14px;
        line-height: 1.2;
    }
    .profile-hero p {
        color: rgba(255,255,255,.8);
        font-size: 1.05rem;
        max-width: 520px;
        margin: 0 auto 36px;
        line-height: 1.7;
    }

    /* ── Stats strip ── */
    .stats-strip {
        display: flex;
        justify-content: center;
        gap: 48px;
        flex-wrap: wrap;
        margin-bottom: 10px;
    }
    .stat-item { text-align: center; }
    .stat-item .num {
        font-size: 2.2rem;
        font-weight: 800;
        color: #fff;
        line-height: 1;
        text-shadow: 0 2px 8px rgba(0,0,0,.2);
    }
    .stat-item .lbl {
        font-size: .74rem;
        color: rgba(255,255,255,.6);
        text-transform: uppercase;
        letter-spacing: .6px;
        margin-top: 4px;
    }

    /* ── Section header ── */
    .section-header {
        text-align: center;
        margin-bottom: 40px;
        padding: 0 20px;
    }
    .section-header h2 {
        font-size: 1.5rem;
        font-weight: 700;
        color: #fff;
        margin-bottom: 6px;
    }
    .section-header p { color: rgba(255,255,255,.6); font-size: .9rem; }

    /* ── Cards grid ── */
    .cards-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 20px;
        max-width: 1100px;
        margin: 0 auto;
        padding: 0 20px 80px;
    }
    @media (max-width: 1024px) {
        .cards-grid { grid-template-columns: repeat(3, 1fr); }
    }
    @media (max-width: 640px) {
        .cards-grid { grid-template-columns: repeat(2, 1fr); }
    }

    /* ── Member card ── */
    .member-card {
        position: relative;
        background: rgba(255,255,255,.12);
        border: 1px solid rgba(255,255,255,.18);
        border-radius: 50px;
        padding: 30px 20px 22px;
        text-align: center;
        cursor: pointer;
        transition: transform .3s, box-shadow .3s, background .3s, border-color .3s;
        backdrop-filter: blur(10px);
        overflow: visible;
    }
    .member-card:hover {
        transform: translateY(-8px);
        background: rgba(255,255,255,.2);
        border-color: rgba(255,255,255,.4);
        box-shadow: 0 20px 50px rgba(0,0,0,.25);
    }

    /* Avatar */
    .avatar-wrap {
        position: relative;
        width: 96px;
        height: 96px;
        margin: 0 auto 16px;
    }
    .avatar-wrap img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid rgba(255,255,255,.4);
        position: relative;
        z-index: 1;
        transition: border-color .3s;
    }
    .member-card:hover .avatar-wrap img { border-color: #fff; }

    .avatar-ring {
        position: absolute;
        inset: -5px;
        border-radius: 50%;
        background: conic-gradient(from 0deg, #ff7f50, #d633ff, #2575fc, #ff4d6d, #ff7f50);
        opacity: 0;
        animation: spinRing 3.5s linear infinite;
        transition: opacity .3s;
        z-index: 0;
    }
    .member-card:hover .avatar-ring { opacity: 1; }
    @keyframes spinRing { to { transform: rotate(360deg); } }

    .avatar-inner {
        position: absolute;
        inset: 2px;
        border-radius: 50%;
        background: linear-gradient(135deg, #6a11cb, #2575fc);
        z-index: 0;
    }

    /* Card text */
    .member-name {
        font-size: 1rem;
        font-weight: 700;
        color: #fff;
        margin-bottom: 5px;
    }
    .member-role {
        display: inline-block;
        font-size: .72rem;
        font-weight: 600;
        color: #fff;
        background: rgba(255,255,255,.18);
        border: 1px solid rgba(255,255,255,.25);
        border-radius: 999px;
        padding: 3px 10px;
        letter-spacing: .4px;
        margin-bottom: 10px;
        text-transform: uppercase;
    }
    .member-email {
        font-size: .75rem;
        color: rgba(255,255,255,.55);
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .card-cta {
        margin-top: 12px;
        font-size: .75rem;
        color: rgba(255,255,255,.35);
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: color .3s;
    }
    .member-card:hover .card-cta { color: rgba(255,255,255,.85); }

    /* ── Detail Modal ── */
    .detail-overlay {
        display: none;
        position: fixed;
        inset: 0;
        z-index: 3000;
        background: rgba(30,10,60,.6);
        backdrop-filter: blur(10px);
        align-items: center;
        justify-content: center;
        padding: 20px;
    }
    .detail-overlay.open { display: flex; animation: fadeIn .2s ease; }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

    .detail-modal {
        background: rgba(255,255,255,.1);
        backdrop-filter: blur(24px);
        border: 1px solid rgba(255,255,255,.25);
        border-radius: 24px;
        max-width: 800px;
        width: 100%;
        max-height: 90vh;
        overflow-y: auto;
        position: relative;
        animation: slideUp .3s ease;
        box-shadow: 0 40px 80px rgba(0,0,0,.4);
        color: #fff;
    }
    @keyframes slideUp {
        from { transform: translateY(28px); opacity: 0; }
        to   { transform: translateY(0);    opacity: 1; }
    }

    .modal-close {
        position: absolute;
        top: 14px; right: 14px;
        width: 34px; height: 34px;
        border-radius: 50%;
        border: 1px solid rgba(255,255,255,.25);
        background: rgba(255,255,255,.1);
        color: rgba(255,255,255,.8);
        cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        font-size: .95rem;
        transition: .2s;
        z-index: 10;
    }
    .modal-close:hover { background: rgba(255,100,80,.3); border-color: #ff7f50; color: #fff; }

    .modal-inner {
        display: grid;
        grid-template-columns: 260px 1fr;
    }

    .modal-left {
        padding: 40px 24px;
        border-right: 1px solid rgba(255,255,255,.1);
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        background: rgba(255,255,255,.05);
        border-radius: 24px 0 0 24px;
    }
    .modal-avatar {
        width: 110px; height: 110px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid rgba(255,255,255,.5);
        margin-bottom: 16px;
        box-shadow: 0 8px 28px rgba(0,0,0,.3);
    }
    .modal-name {
        font-size: 1.25rem;
        font-weight: 800;
        color: #fff;
        margin-bottom: 6px;
    }
    .modal-role-badge {
        background: rgba(255,255,255,.15);
        border: 1px solid rgba(255,255,255,.25);
        color: #fff;
        padding: 4px 14px;
        border-radius: 999px;
        font-size: .75rem;
        font-weight: 600;
        margin-bottom: 14px;
        text-transform: uppercase;
        letter-spacing: .4px;
    }
    .modal-email {
        font-size: .8rem;
        color: rgba(255,255,255,.5);
        word-break: break-all;
    }
    .modal-divider {
        width: 36px; height: 2px;
        background: linear-gradient(90deg, #ff7f50, #d633ff, #2575fc);
        border-radius: 2px;
        margin: 14px auto;
    }

    .modal-right { padding: 40px 32px; }
    .modal-right h3 {
        font-size: .82rem;
        font-weight: 700;
        color: rgba(255,255,255,.45);
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 14px;
    }
    .modal-desc {
        color: rgba(255,255,255,.85);
        font-size: .92rem;
        line-height: 1.9;
    }

    /* ── Responsive ── */
    @media (max-width: 640px) {
        .modal-inner { grid-template-columns: 1fr; }
        .modal-left  { border-right: none; border-bottom: 1px solid rgba(255,255,255,.1); border-radius: 24px 24px 0 0; padding: 28px 20px; }
        .modal-right { padding: 24px 20px; }
        .cards-grid  { gap: 40px; }
        .stats-strip { gap: 28px; }
    }
</style>
@endpush

@section('content')

{{-- Hero --}}
<section class="profile-hero">
    <div class="eyebrow">
        <i class="bi bi-people-fill"></i> Tim Kami
    </div>
    <h1>Orang-orang di Balik<br>SportXFest</h1>
    <p>Kenali para anggota tim yang bekerja keras membangun platform event olahraga terbaik untuk kamu.</p>

    <div class="stats-strip">
        <div class="stat-item">
            <div class="num">{{ $profiles->count() }}</div>
            <div class="lbl">Anggota Tim</div>
        </div>
        <div class="stat-item">
            <div class="num">5</div>
            <div class="lbl">Fitur Utama</div>
        </div>
        <div class="stat-item">
            <div class="num">2026</div>
            <div class="lbl">Tahun Berdiri</div>
        </div>
    </div>
</section>

{{-- Section header --}}
<div class="section-header">
    <h2>Anggota Tim</h2>
    <p>Klik kartu untuk melihat detail dan kontribusi masing-masing</p>
</div>

{{-- Cards --}}
<div class="cards-grid">
    @forelse($profiles as $profile)
    <div class="member-card"
         data-nama="{{ $profile->nama }}"
         data-role="{{ $profile->role }}"
         data-email="{{ $profile->email }}"
         data-deskripsi="{{ $profile->deskripsi }}"
         data-foto="{{ asset('images/' . $profile->foto) }}"
         onclick="openDetail(this)">

        <div class="avatar-wrap">
            <div class="avatar-ring"></div>
            <div class="avatar-inner"></div>
            <img src="{{ asset('images/' . $profile->foto) }}"
                 alt="{{ $profile->nama }}"
                 onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($profile->nama) }}&background=6a11cb&color=fff&size=200'">
        </div>

        <div class="member-name">{{ $profile->nama }}</div>
        <div class="member-role">{{ $profile->role }}</div>
        <div class="member-email">{{ $profile->email }}</div>
        <div class="card-cta">
            <i class="bi bi-arrow-right-circle"></i>
            <span>Lihat Detail</span>
        </div>
    </div>
    @empty
    <div style="grid-column:1/-1;text-align:center;padding:60px;color:rgba(255,255,255,.5);">
        <i class="bi bi-people" style="font-size:3rem;display:block;margin-bottom:12px;"></i>
        Belum ada data profil tim.
    </div>
    @endforelse
</div>

{{-- Modal detail --}}
<div class="detail-overlay" id="detailOverlay" onclick="closeOnOverlay(event)">
    <div class="detail-modal">
        <button class="modal-close" onclick="closeDetail()">
            <i class="bi bi-x-lg"></i>
        </button>
        <div class="modal-inner">
            <div class="modal-left">
                <img id="modal-foto" src="" alt="" class="modal-avatar">
                <div class="modal-name"  id="modal-nama"></div>
                <div class="modal-role-badge" id="modal-role"></div>
                <div class="modal-divider"></div>
                <div class="modal-email" id="modal-email"></div>
            </div>
            <div class="modal-right">
                <h3><i class="bi bi-file-person me-2"></i>Tentang</h3>
                <div class="modal-desc" id="modal-deskripsi"></div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function openDetail(el) {
    document.getElementById('modal-nama').textContent      = el.dataset.nama;
    document.getElementById('modal-role').textContent      = el.dataset.role;
    document.getElementById('modal-email').textContent     = el.dataset.email;
    document.getElementById('modal-deskripsi').textContent = el.dataset.deskripsi;
    document.getElementById('modal-foto').src              = el.dataset.foto;
    document.getElementById('modal-foto').alt              = el.dataset.nama;
    document.getElementById('detailOverlay').classList.add('open');
    document.body.style.overflow = 'hidden';
}
function closeDetail() {
    document.getElementById('detailOverlay').classList.remove('open');
    document.body.style.overflow = '';
}
function closeOnOverlay(e) {
    if (e.target === document.getElementById('detailOverlay')) closeDetail();
}
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeDetail(); });
</script>
@endpush
