@extends('admin.layouts.app')

@section('title', 'Edit Dokumentasi')
@section('page-title', 'Edit Dokumentasi')

@section('content')
<div class="card" style="max-width:860px;">
    <div class="card-header">
        <span class="card-title"><i class="fas fa-edit"></i> Edit Foto Dokumentasi</span>
        <a href="{{ route('admin.dokumentasi.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
    <div style="padding:24px;">
        <form method="POST" action="{{ route('admin.dokumentasi.update', $galleryPhoto) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Event <span style="color:#ef4444;">*</span></label>
                    <select name="event_id" class="form-control {{ $errors->has('event_id') ? 'is-invalid' : '' }}" required>
                        @foreach($events as $event)
                            <option value="{{ $event->id }}" {{ old('event_id', $galleryPhoto->event_id) == $event->id ? 'selected' : '' }}>
                                {{ $event->title }} - {{ $event->date->format('d M Y') }}
                            </option>
                        @endforeach
                    </select>
                    @error('event_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Foto Baru</label>
                    @if($galleryPhoto->photo_path)
                        <div style="margin-bottom:10px;">
                            <img src="{{ asset('storage/' . $galleryPhoto->photo_path) }}" alt="" style="max-width:200px;border-radius:12px;object-fit:cover;">
                        </div>
                    @endif
                    <input type="file" name="photo" class="form-control {{ $errors->has('photo') ? 'is-invalid' : '' }}" accept="image/*">
                    @error('photo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Deskripsi Kegiatan</label>
                <textarea name="description" class="form-control" rows="4">{{ old('description', $galleryPhoto->description) }}</textarea>
                @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div style="display:flex;gap:10px;margin-top:8px;">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Perubahan</button>
                <a href="{{ route('admin.dokumentasi.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection