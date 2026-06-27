@extends('admin.layouts.app')
@section('title', 'Registrations')
@section('page-title', 'Registration Management')

@section('content')
<div class="card">
    <div class="card-header">
        <span class="card-title"><i class="fas fa-clipboard-list"></i> Daftar Registrasi</span>
        <form method="GET" class="filter-bar">
            <input type="text" name="search" class="form-control" placeholder="Cari nama / email..." value="{{ request('search') }}">
            <select name="event_id" class="form-control">
                <option value="">Semua Event</option>
                @foreach($events as $event)
                    <option value="{{ $event->id }}" {{ request('event_id') == $event->id ? 'selected' : '' }}>
                        {{ $event->title }}
                    </option>
                @endforeach
            </select>
            <select name="status" class="form-control">
                <option value="">Semua Status</option>
                <option value="pending"  {{ request('status') === 'pending'  ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
            <button type="submit" class="btn btn-secondary btn-sm"><i class="fas fa-search"></i></button>
            <a href="{{ route('admin.registrations.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-times"></i></a>
        </form>
    </div>

    <div class="card-body">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Peserta</th>
                    <th>Event</th>
                    <th>Tanggal Daftar</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($registrations as $reg)
                <tr>
                    <td style="color:#9ca3af;">{{ $loop->iteration + ($registrations->currentPage()-1) * 10 }}</td>
                    <td>
                        <div style="font-weight:500;">{{ $reg->user->name }}</div>
                        <div style="color:#9ca3af;font-size:.78rem;">{{ $reg->user->email }}</div>
                    </td>
                    <td>
                        <div style="font-weight:500;">{{ $reg->event->title }}</div>
                        <div style="color:#9ca3af;font-size:.78rem;">{{ $reg->event->date->format('d M Y') }}</div>
                    </td>
                    <td style="color:#6b7280;font-size:.8rem;">{{ $reg->created_at->format('d M Y, H:i') }}</td>
                    <td><span class="badge badge-{{ $reg->status }}">{{ ucfirst($reg->status) }}</span></td>
                    <td>
                        <div style="display:flex;gap:6px;">
                            @if($reg->status === 'pending')
                                <form method="POST" action="{{ route('admin.registrations.approve', $reg) }}">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn btn-success btn-sm" title="Approve">
                                        <i class="fas fa-check"></i> Approve
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.registrations.reject', $reg) }}">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Reject">
                                        <i class="fas fa-times"></i> Reject
                                    </button>
                                </form>
                            @elseif($reg->status === 'approved')
                                <form method="POST" action="{{ route('admin.registrations.reject', $reg) }}">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn btn-secondary btn-sm">
                                        <i class="fas fa-ban"></i> Cabut
                                    </button>
                                </form>
                            @elseif($reg->status === 'rejected')
                                <form method="POST" action="{{ route('admin.registrations.approve', $reg) }}">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn btn-success btn-sm">
                                        <i class="fas fa-undo"></i> Approve
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align:center;color:#9ca3af;padding:32px;">
                        <i class="fas fa-clipboard" style="font-size:2rem;margin-bottom:8px;display:block;"></i>
                        Tidak ada data registrasi.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-wrapper">
        <span>Menampilkan {{ $registrations->firstItem() ?? 0 }}–{{ $registrations->lastItem() ?? 0 }} dari {{ $registrations->total() }} registrasi</span>
        {{ $registrations->links() }}
    </div>
</div>
@endsection
