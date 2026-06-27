@extends('admin.layouts.app')
@section('title', 'Tambah Event')
@section('page-title', 'Tambah Event Baru')

@section('content')
<div class="card" style="max-width:760px;">
    <div class="card-header">
        <span class="card-title"><i class="fas fa-plus-circle"></i> Form Event Baru</span>
        <a href="{{ route('admin.events.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
    <div style="padding:24px;">
        <form method="POST" action="{{ route('admin.events.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label class="form-label">Judul Event <span style="color:#ef4444;">*</span></label>
                <input type="text" name="title" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" value="{{ old('title') }}" placeholder="Contoh: Marathon 10K 2025" required>
                @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label class="form-label">Deskripsi</label>
                <textarea name="description" class="form-control" rows="4" placeholder="Deskripsi event...">{{ old('description') }}</textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Tanggal <span style="color:#ef4444;">*</span></label>
                    <input type="date" name="date" class="form-control {{ $errors->has('date') ? 'is-invalid' : '' }}" value="{{ old('date') }}" required>
                    @error('date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Lokasi <span style="color:#ef4444;">*</span></label>
                    <input type="text" name="location" class="form-control {{ $errors->has('location') ? 'is-invalid' : '' }}" value="{{ old('location') }}" placeholder="Contoh: Stadion GBK, Jakarta" required>
                    @error('location')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Kuota Peserta <span style="color:#ef4444;">*</span></label>
                    <input type="number" name="quota" class="form-control {{ $errors->has('quota') ? 'is-invalid' : '' }}" value="{{ old('quota', 100) }}" min="1" required>
                    @error('quota')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Status <span style="color:#ef4444;">*</span></label>
                    <select name="status" class="form-control" required>
                        <option value="open"   {{ old('status') === 'open'   ? 'selected' : '' }}>Open</option>
                        <option value="closed" {{ old('status') === 'closed' ? 'selected' : '' }}>Closed</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Poster / Gambar Event</label>
                <input type="file" name="image" class="form-control" accept="image/*" onchange="previewImage(event)">
                <div style="color:#6b7280;font-size:.78rem;margin-top:4px;">JPG, PNG, WEBP. Maks 2MB.</div>
                <img id="imagePreview" src="" alt="Preview">
            </div>

            <div style="display:flex;gap:10px;margin-top:8px;">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Event
                </button>
                <a href="{{ route('admin.events.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function previewImage(event) {
    const preview = document.getElementById('imagePreview');
    const file    = event.target.files[0];
    if (file) {
        preview.src     = URL.createObjectURL(file);
        preview.style.display = 'block';
    }
}
</script>
@endpush
