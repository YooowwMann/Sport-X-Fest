@extends('admin.layouts.app')
@section('title', 'User Management')
@section('page-title', 'User Management')

@section('content')
<div class="card">
    <div class="card-header">
        <span class="card-title"><i class="fas fa-users"></i> Daftar User</span>
        {{-- Filter Bar --}}
        <form method="GET" class="filter-bar">
            <input type="text" name="search" class="form-control" placeholder="Cari nama / email..." value="{{ request('search') }}">
            <select name="role" class="form-control">
                <option value="">Semua Role</option>
                <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="user"  {{ request('role') === 'user'  ? 'selected' : '' }}>User</option>
            </select>
            <select name="status" class="form-control">
                <option value="">Semua Status</option>
                <option value="active"   {{ request('status') === 'active'   ? 'selected' : '' }}>Aktif</option>
                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
            </select>
            <select name="per_page" class="form-control" onchange="this.form.submit()">
                @foreach([10, 25, 50] as $n)
                    <option value="{{ $n }}" {{ $perPage == $n ? 'selected' : '' }}>{{ $n }} per halaman</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Filter</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-times"></i> Reset</a>
        </form>
    </div>

    <div class="card-body">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Bergabung</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td style="color:#9ca3af;">{{ $loop->iteration + ($users->currentPage()-1) * $perPage }}</td>
                    <td>
                        <div style="display:flex;align-items:center;gap:10px;">
                            <div style="width:34px;height:34px;border-radius:50%;background:#e94560;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:.85rem;flex-shrink:0;">
                                {{ strtoupper(substr($user->name,0,1)) }}
                            </div>
                            <span style="font-weight:500;">{{ $user->name }}</span>
                        </div>
                    </td>
                    <td style="color:#6b7280;">{{ $user->email }}</td>
                    <td>
                        <span class="badge badge-{{ $user->role }}">{{ ucfirst($user->role) }}</span>
                    </td>
                    <td>
                        <span class="badge {{ $user->is_active ? 'badge-active' : 'badge-inactive' }}">
                            {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td style="color:#6b7280;font-size:.8rem;">{{ $user->created_at?->format('d M Y') ?? '-' }}</td>
                    <td>
                        <div style="display:flex;gap:6px;flex-wrap:wrap;">
                            {{-- Ubah Role --}}
                            @if($user->id !== auth()->id())
                            <form method="POST" action="{{ route('admin.users.role', $user) }}">
                                @csrf @method('PATCH')
                                <input type="hidden" name="role" value="{{ $user->role === 'admin' ? 'user' : 'admin' }}">
                                <button type="submit" class="btn btn-warning btn-sm" title="Toggle Role">
                                    <i class="fas fa-user-shield"></i>
                                    {{ $user->role === 'admin' ? '→ User' : '→ Admin' }}
                                </button>
                            </form>

                            {{-- Toggle Status --}}
                            <form method="POST" action="{{ route('admin.users.toggle-status', $user) }}">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn btn-sm {{ $user->is_active ? 'btn-secondary' : 'btn-success' }}" title="Toggle Status">
                                    <i class="fas fa-{{ $user->is_active ? 'ban' : 'check' }}"></i>
                                </button>
                            </form>

                            {{-- Hapus --}}
                            <form id="del-user-{{ $user->id }}" method="POST" action="{{ route('admin.users.destroy', $user) }}">
                                @csrf @method('DELETE')
                            </form>
                            <button onclick="confirmDelete('del-user-{{ $user->id }}', '{{ addslashes($user->name) }}')" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i>
                            </button>
                            @else
                            <span style="color:#9ca3af;font-size:.8rem;font-style:italic;">Kamu</span>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align:center;color:#9ca3af;padding:32px;">
                        <i class="fas fa-users" style="font-size:2rem;margin-bottom:8px;display:block;"></i>
                        Tidak ada user ditemukan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-wrapper">
        <span>Menampilkan {{ $users->firstItem() ?? 0 }}–{{ $users->lastItem() ?? 0 }} dari {{ $users->total() }} user</span>
        {{ $users->links() }}
    </div>
</div>
@endsection
