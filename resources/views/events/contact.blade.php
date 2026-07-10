@extends('layouts.public')

@section('title', 'Contact - SportXFest')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
<style>
    .contact-hero {
        padding: 72px 20px 32px;
        background: linear-gradient(135deg, rgba(26,26,46,.96), rgba(15,52,96,.95));
        color: #fff;
    }

    .contact-shell {
        max-width: 1120px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 1.1fr .9fr;
        gap: 24px;
        padding: 0 20px 72px;
    }

    .contact-panel,
    .contact-form-panel {
        background: #fff;
        border-radius: 22px;
        box-shadow: 0 18px 50px rgba(0,0,0,.12);
        overflow: hidden;
    }

    .contact-panel {
        padding: 28px;
    }

    .contact-form-panel {
        padding: 28px;
        position: sticky;
        top: 92px;
        align-self: start;
    }

    .eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 6px 14px;
        border-radius: 999px;
        background: rgba(255,255,255,.12);
        color: rgba(255,255,255,.9);
        font-size: .8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .5px;
        margin-bottom: 16px;
    }

    .contact-hero h1 {
        font-size: clamp(2rem, 4vw, 3.2rem);
        font-weight: 800;
        margin-bottom: 10px;
    }

    .contact-hero p {
        max-width: 720px;
        color: rgba(255,255,255,.76);
        margin-bottom: 0;
        line-height: 1.7;
    }

    .contact-card {
        background: linear-gradient(180deg, #f8fafc 0%, #ffffff 100%);
        border: 1px solid #e5e7eb;
        border-radius: 18px;
        padding: 18px;
        margin-bottom: 16px;
    }

    .contact-card-header {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        margin-bottom: 8px;
        text-align: center;
    }

    .contact-card-header .card-icon {
        width: 38px;
        height: 38px;
        border-radius: 12px;
        display: grid;
        place-items: center;
        background: linear-gradient(135deg, #e94560, #f97316);
        color: #fff;
        flex-shrink: 0;
    }

    .contact-card h3 {
        font-size: 1rem;
        font-weight: 700;
        color: #111827;
        margin-bottom: 0;
    }

    .contact-card p {
        color: #6b7280;
        margin-bottom: 0;
        line-height: 1.6;
    }

    .info-grid {
        display: grid;
        gap: 14px;
        margin-top: 18px;
    }

    .info-tile {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 14px 16px;
        border-radius: 14px;
        background: #f9fafb;
        border: 1px solid #eef2f7;
    }

    .info-tile > div {
        display: flex;
        flex-direction: column;
        justify-content: center;
        min-height: 42px;
    }

    .info-tile .icon {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        display: grid;
        place-items: center;
        background: linear-gradient(135deg, #e94560, #f97316);
        color: #fff;
        flex-shrink: 0;
    }

    .info-tile strong {
        display: block;
        color: #111827;
        font-size: .92rem;
    }

    .info-tile span {
        color: #6b7280;
        font-size: .88rem;
    }

    .form-label {
        font-weight: 600;
        color: #374151;
    }

    .form-control {
        color: #111827 !important;
        background-color: #fff;
        border: 1px solid #d1d5db;
    }

    .contact-form-panel .form-control,
    .contact-form-panel textarea.form-control,
    .contact-form-panel input.form-control {
        color: #080a0f !important;
        -webkit-text-fill-color: #585b60 !important;
        caret-color: #111827;
    }

    .form-control::placeholder {
        color: #9ca3af;
        opacity: 1;
    }

    .form-control:focus {
        border-color: #e94560;
        box-shadow: 0 0 0 .2rem rgba(233,69,96,.12);
    }

    .btn-contact {
        width: 100%;
        padding: 12px 18px;
        border: none;
        border-radius: 12px;
        background: linear-gradient(135deg, #e94560, #f59e0b);
        color: #fff;
        font-weight: 700;
    }

    @media (max-width: 992px) {
        .contact-shell {
            grid-template-columns: 1fr;
        }

        .contact-form-panel {
            position: static;
        }
    }
</style>
@endpush

@section('content')
<section class="contact-hero">
    <div class="container">
        <div class="eyebrow"><i class="bi bi-chat-dots-fill"></i> Contact Us</div>
        <h1>Kirim pesan ke SportXFest</h1>
        <p>Gunakan form ini untuk tanya event, kerja sama, atau menyampaikan masukan. Pesan akan masuk dan bisa dibalas admin melalui email yang kamu isi.</p>
    </div>
</section>

<div class="contact-shell">
    <section class="contact-panel">
        <h2 class="h4 fw-bold mb-2">Informasi Kontak</h2>
        <p class="text-muted mb-4">Hubungi panitia SportXFest lewat jalur resmi di bawah ini.</p>

        <div class="contact-card">
            <div class="contact-card-header">
                <div class="card-icon"><i class="bi bi-info-circle-fill"></i></div>
                <h3>Tentang Contact Form</h3>
            </div>
            <p>Setiap pesan akan disimpan sebagai record baru. Admin dapat melihat nama pengirim, email, subject, dan isi pesan di inbox admin.</p>
        </div>

        <div class="info-grid">
            <div class="info-tile">
                <div class="icon"><i class="bi bi-envelope-fill"></i></div>
                <div>
                    <strong>Email</strong>
                    <span>sportxfest@gmail.com</span>
                </div>
            </div>
            <div class="info-tile">
                <div class="icon"><i class="bi bi-telephone-fill"></i></div>
                <div>
                    <strong>Telepon</strong>
                    <span>+62 812 3456 7890</span>
                </div>
            </div>
            <div class="info-tile">
                <div class="icon"><i class="bi bi-geo-alt-fill"></i></div>
                <div>
                    <strong>Lokasi</strong>
                    <span>Jakarta, Indonesia</span>
                </div>
            </div>
        </div>
    </section>

    <section class="contact-form-panel">
        <h2 class="h4 fw-bold mb-2">Tulis Pesan</h2>
        <p class="text-muted mb-4">Isi form di bawah dan admin akan membalas melalui email yang kamu cantumkan.</p>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('contact.store') }}" method="POST" class="row g-3">
            @csrf
            <div class="col-12">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" id="nama" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" placeholder="Nama lengkap" required>
                @error('nama')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="email@gmail.com" required>
                @error('email')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12">
                <label for="subject" class="form-label">Subject</label>
                <input type="text" id="subject" name="subject" class="form-control @error('subject') is-invalid @enderror" value="{{ old('subject') }}" placeholder="Subject1" required>
                @error('subject')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12">
                <label for="pesan" class="form-label">Pesan</label>
                <textarea id="pesan" name="pesan" rows="6" class="form-control @error('pesan') is-invalid @enderror" placeholder="Tulis pesanmu di sini" required>{{ old('pesan') }}</textarea>
                @error('pesan')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12">
                <button type="submit" class="btn-contact">Kirim Pesan</button>
            </div>
        </form>
    </section>
</div>
@endsection
