@extends('admin.layouts.app')
@section('title', 'Event Management')
@section('page-title', 'Event Management')

@section('content')
<div class="card">
    <div class="card-header">
        <span class="card-title"><i class="fas fa-calendar-alt"></i> Daftar Event</span>
        <div style="display:flex;gap:10px;flex-wrap:wrap;align-items:center;">
            <form method="GET" class="filter-bar">
                <input type="text" name="search" class="form-control" placeholder="Cari event / lokasi..." value="{{ request('search') }}">
                <select name="status" class="form-control">
                    <option value="">Semua Status</option>
                    <option value="open"   {{ request('status') === 'open'   ? 'selected' : '' }}>Open</option>
                    <option value="closed" {{ request('status') === 'closed' ? 'selected' : '' }}>Closed</option>
                </select>
                <input type="date" name="date" class="form-control" value="{{ request('date') }}">
                <button type="submit" class="btn btn-secondary btn-sm"><i class="fas fa-search"></i></button>
                <a href="{{ route('admin.events.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-times"></i></a>
            </form>
            <a href="{{ route('admin.events.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Tambah Event
            </a>
        </div>
    </div>

    <div class="card-body">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Event</th>
                    <th>Tanggal</th>
                    <th>Lokasi</th>
                    <th>Kuota</th>
                    <th>Peserta</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($events as $event)
                <tr>
                    <td style="color:#9ca3af;">{{ $loop->iteration + ($events->currentPage()-1) * 10 }}</td>
                    <td>
                        <div style="display:flex;align-items:center;gap:10px;">
                            @if($event->image)
                                <img src="{{ Storage::url($event->image) }}" alt="" style="width:40px;height:40px;border-radius:8px;object-fit:cover;">
                            @else
                                <div style="width:40px;height:40px;border-radius:8px;background:linear-gradient(135deg,#e94560,#f72585);display:flex;align-items:center;justify-content:center;color:#fff;">
                                    <i class="fas fa-running"></i>
                                </div>
                            @endif
                            <div>
                                <div style="font-weight:500;">{{ $event->title }}</div>
                                <div style="color:#9ca3af;font-size:.78rem;">{{ Str::limit($event->description, 40) }}</div>
                            </div>
                        </div>
                    </td>
                    <td style="white-space:nowrap;">{{ $event->date->format('d M Y') }}</td>
                    <td>{{ $event->location }}</td>
                    <td>{{ $event->quota }}</td>
                    <td>
                        <span style="font-weight:600;color:{{ $event->registrations_count >= $event->quota ? '#ef4444' : '#10b981' }};">
                            {{ $event->registrations_count }} / {{ $event->quota }}
                        </span>
                    </td>
                    <td><span class="badge badge-{{ $event->status }}">{{ ucfirst($event->status) }}</span></td>
                    <td>
                        <div style="display:flex;gap:6px;">
                            <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form id="del-event-{{ $event->id }}" method="POST" action="{{ route('admin.events.destroy', $event) }}">
                                @csrf @method('DELETE')
                            </form>
                            <button onclick="confirmDelete('del-event-{{ $event->id }}', '{{ addslashes($event->title) }}')" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align:center;color:#9ca3af;padding:32px;">
                        <i class="fas fa-calendar-times" style="font-size:2rem;margin-bottom:8px;display:block;"></i>
                        Belum ada event.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-wrapper">
        <span>Menampilkan {{ $events->firstItem() ?? 0 }}–{{ $events->lastItem() ?? 0 }} dari {{ $events->total() }} event</span>
        {{ $events->links() }}
    </div>
</div>
@endsection
