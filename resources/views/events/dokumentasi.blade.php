@extends('layouts.public')

@section('title', 'Dokumentasi - SportXFest')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
<style>
    .doc-hero {
        padding: 76px 20px 34px;
        text-align: center;
        color: #fff;
    }

    .doc-hero .tag {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 6px 14px;
        border-radius: 999px;
        background: rgba(255,255,255,.12);
        border: 1px solid rgba(255,255,255,.2);
        font-size: .78rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .5px;
        margin-bottom: 16px;
    }

    .doc-hero h1 {
        font-size: clamp(2rem, 4vw, 3.2rem);
        font-weight: 800;
        margin-bottom: 10px;
    }

    .doc-hero p {
        max-width: 760px;
        margin: 0 auto;
        color: rgba(255,255,255,.75);
        line-height: 1.7;
    }

    .doc-wrap {
        max-width: 1180px;
        margin: 0 auto;
        padding: 0 20px 80px;
    }

    .doc-group {
        background: rgba(255,255,255,.06);
        border: 1px solid rgba(255,255,255,.1);
        border-radius: 22px;
        padding: 24px;
        margin-bottom: 24px;
        backdrop-filter: blur(8px);
    }

    .doc-group-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 16px;
        margin-bottom: 18px;
        flex-wrap: wrap;
    }

    .doc-group-title {
        color: #fff;
        font-weight: 800;
        font-size: 1.25rem;
        margin-bottom: 6px;
    }

    .doc-group-meta {
        color: rgba(255,255,255,.68);
        font-size: .88rem;
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
    }

    .doc-group-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .btn-doc {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 18px;
        border-radius: 999px;
        text-decoration: none;
        font-weight: 700;
        font-size: .9rem;
        transition: .2s;
    }

    .btn-doc-primary {
        background: linear-gradient(135deg, #e63946, #d633ff);
        color: #fff;
    }

    .btn-doc-secondary {
        background: rgba(255,255,255,.12);
        border: 1px solid rgba(255,255,255,.18);
        color: #fff;
    }

    .doc-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 18px;
    }

    .doc-card {
        background: #fff;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 12px 32px rgba(0,0,0,.12);
        display: flex;
        flex-direction: column;
        min-height: 100%;
    }

    .doc-card img {
        width: 100%;
        height: 210px;
        object-fit: cover;
    }

    .doc-card-body {
        padding: 18px;
        display: flex;
        flex-direction: column;
        gap: 12px;
        flex: 1;
    }

    .doc-photo-desc {
        color: #374151;
        line-height: 1.65;
        font-size: .92rem;
    }

    .doc-photo-meta {
        display: flex;
        flex-direction: column;
        gap: 4px;
        color: #6b7280;
        font-size: .8rem;
    }

    .doc-card-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-top: auto;
    }

    .doc-empty {
        text-align: center;
        padding: 70px 20px;
        color: rgba(255,255,255,.65);
    }

    .doc-empty i {
        font-size: 3rem;
        display: block;
        margin-bottom: 12px;
    }

    @media (max-width: 768px) {
        .doc-group {
            padding: 18px;
        }
    }
</style>
@endpush

@section('content')
<section class="doc-hero">
    <div class="tag"><i class="bi bi-images"></i> Dokumentasi Event</div>
    <h1>Arsip Foto SportXFest</h1>
    <p>Foto dokumentasi tiap event ditampilkan per event dan tetap tersimpan sebagai arsip. Setiap foto bisa ditautkan ke event yang sesuai, sehingga user dapat langsung menuju event terkait.</p>
</section>

<div class="doc-wrap">
    @forelse($galleryGroups as $group)
        @php
            $event = $group['event'];
            $photos = $group['photos'];
        @endphp
        <section class="doc-group">
            <div class="doc-group-header">
                <div>
                    <div class="doc-group-title">
                        {{ $event?->title ?? 'Arsip Dokumentasi' }}
                    </div>
                    <div class="doc-group-meta">
                        @if($event)
                            <span><i class="bi bi-calendar3"></i> {{ $event->date->format('d M Y') }}</span>
                            <span><i class="bi bi-geo-alt-fill"></i> {{ $event->location }}</span>
                            <span><i class="bi bi-circle-fill" style="font-size:.5rem;color:{{ $event->status === 'open' ? '#22c55e' : '#f59e0b' }}"></i> {{ $event->status === 'open' ? 'Dibuka' : 'Ditutup' }}</span>
                        @else
                            <span><i class="bi bi-exclamation-triangle-fill"></i> Event sudah tidak tersedia, tetapi dokumentasinya tetap disimpan.</span>
                        @endif
                    </div>
                </div>

                <div class="doc-group-actions">
                    @if($event)
                        <a href="{{ route('events.public') }}#event-{{ $event->id }}" class="btn-doc btn-doc-secondary">
                            <i class="bi bi-box-arrow-up-right"></i> Lihat Event
                        </a>
                        @if($event->status === 'open')
                            <a href="{{ route('daftar', ['event_id' => $event->id]) }}" class="btn-doc btn-doc-primary">
                                <i class="bi bi-person-plus-fill"></i> Daftar Event
                            </a>
                        @endif
                    @else
                        <span class="btn-doc btn-doc-secondary" style="cursor:not-allowed;opacity:.75;">
                            <i class="bi bi-lock-fill"></i> Event Tidak Tersedia
                        </span>
                    @endif
                </div>
            </div>

            <div class="doc-grid">
                @foreach($photos as $photo)
                    <article class="doc-card">
                        <img src="{{ asset('storage/' . $photo->photo_path) }}" alt="{{ $photo->description ?? ($event?->title ?? 'Dokumentasi') }}">
                        <div class="doc-card-body">
                            <div class="doc-photo-desc">
                                {{ $photo->description ?: 'Dokumentasi kegiatan event.' }}
                            </div>
                            <div class="doc-photo-meta">
                                <span><i class="bi bi-calendar2-event"></i> {{ $photo->created_at?->format('d M Y') }}</span>
                                <span><i class="bi bi-link-45deg"></i> {{ $event?->title ?? 'Arsip tanpa event' }}</span>
                            </div>
                            <div class="doc-card-actions">
                                @if($event)
                                    <a href="{{ route('events.public') }}#event-{{ $event->id }}" class="btn-doc btn-doc-primary">
                                        <i class="bi bi-arrow-right-circle"></i> Buka Event
                                    </a>
                                @else
                                    <span class="btn-doc btn-doc-secondary" style="cursor:not-allowed;opacity:.75;">
                                        <i class="bi bi-archive-fill"></i> Event Dihapus
                                    </span>
                                @endif
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>
    @empty
        <div class="doc-empty">
            <i class="bi bi-camera"></i>
            <h3>Belum ada dokumentasi</h3>
            <p class="mb-0">Admin belum mengunggah foto dokumentasi untuk event apa pun.</p>
        </div>
    @endforelse
</div>
@endsection
