@extends('admin.layouts.app')

@section('title', 'Dokumentasi')
@section('page-title', 'Dokumentasi')

@section('content')
<div class="card" style="margin-bottom:24px;">
    <div class="card-header">
        <div>
            <span class="card-title"><i class="fas fa-images"></i> Tambah Foto Dokumentasi</span>
            <p style="margin-top:6px;color:#6b7280;font-size:.85rem;">Upload foto kegiatan per event dan tambahkan deskripsinya.</p>
        </div>
    </div>
    <div style="padding:24px;">
        <form method="POST" action="{{ route('admin.dokumentasi.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Event <span style="color:#ef4444;">*</span></label>
                    <select name="event_id" class="form-control {{ $errors->has('event_id') ? 'is-invalid' : '' }}" required>
                        <option value="">Pilih event</option>
                        @foreach($events as $event)
                            <option value="{{ $event->id }}" {{ old('event_id') == $event->id ? 'selected' : '' }}>
                                {{ $event->title }} - {{ $event->date->format('d M Y') }}
                            </option>
                        @endforeach
                    </select>
                    @error('event_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Foto <span style="color:#ef4444;">*</span></label>
                    <input type="file" name="photo" class="form-control {{ $errors->has('photo') ? 'is-invalid' : '' }}" accept="image/*" required>
                    @error('photo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Deskripsi Kegiatan</label>
                <textarea name="description" class="form-control" rows="4" placeholder="Contoh: Finisher marathon, podium juara, sesi pemanasan...">{{ old('description') }}</textarea>
                @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div style="display:flex;gap:10px;margin-top:8px;">
                <button type="submit" class="btn btn-primary"><i class="fas fa-upload"></i> Upload Foto</button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <span class="card-title"><i class="fas fa-photo-video"></i> Daftar Foto Dokumentasi</span>
    </div>
    <div class="card-body">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Foto</th>
                    <th>Event</th>
                    <th>Deskripsi</th>
                    <th>Dibuat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($galleryPhotos as $photo)
                    <tr>
                        <td style="color:#9ca3af;">{{ $loop->iteration + (($galleryPhotos->currentPage() - 1) * $galleryPhotos->perPage()) }}</td>
                        <td>
                            <img src="{{ asset('storage/' . $photo->photo_path) }}" alt="" style="width:64px;height:64px;object-fit:cover;border-radius:12px;">
                        </td>
                        <td>
                            <div style="font-weight:600;">{{ $photo->event?->title ?? 'Event dihapus' }}</div>
                            <div style="color:#9ca3af;font-size:.8rem;">{{ $photo->event?->date?->format('d M Y') ?? 'Arsip' }}</div>
                        </td>
                        <td style="max-width:360px;white-space:pre-wrap;line-height:1.6;">{{ $photo->description ?: '-' }}</td>
                        <td style="color:#6b7280;font-size:.85rem;">{{ $photo->created_at?->format('d M Y, H:i') }}</td>
                        <td>
                            <div style="display:flex;gap:8px;flex-wrap:wrap;">
                                <a href="{{ route('admin.dokumentasi.edit', $photo) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                <form id="del-photo-{{ $photo->id }}" method="POST" action="{{ route('admin.dokumentasi.destroy', $photo) }}">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('del-photo-{{ $photo->id }}', 'foto ini')"><i class="fas fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center;color:#9ca3af;padding:32px;">
                            Belum ada foto dokumentasi.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="pagination-wrapper">
        <span>Menampilkan {{ $galleryPhotos->firstItem() ?? 0 }}–{{ $galleryPhotos->lastItem() ?? 0 }} dari {{ $galleryPhotos->total() }} foto</span>
        {{ $galleryPhotos->links() }}
    </div>
</div>
@endsection