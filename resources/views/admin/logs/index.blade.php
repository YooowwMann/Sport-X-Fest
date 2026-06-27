@extends('admin.layouts.app')
@section('title', 'Activity Log')
@section('page-title', 'Activity Log')

@section('content')
<div class="card">
    <div class="card-header">
        <span class="card-title"><i class="fas fa-history"></i> Log Aktivitas Admin</span>
    </div>
    <div class="card-body">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Waktu</th>
                    <th>User</th>
                    <th>Aksi</th>
                    <th>Deskripsi</th>
                    <th>IP Address</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                <tr>
                    <td style="color:#9ca3af;">{{ $loop->iteration + ($logs->currentPage()-1) * 20 }}</td>
                    <td style="white-space:nowrap;color:#6b7280;font-size:.8rem;">{{ $log->created_at->format('d M Y, H:i:s') }}</td>
                    <td>
                        @if($log->user)
                            <div style="font-weight:500;">{{ $log->user->name }}</div>
                            <div style="color:#9ca3af;font-size:.78rem;">{{ $log->user->email }}</div>
                        @else
                            <span style="color:#9ca3af;">System</span>
                        @endif
                    </td>
                    <td>
                        @php
                            $colors = [
                                'login'               => 'badge-approved',
                                'logout'              => 'badge-user',
                                'delete_user'         => 'badge-rejected',
                                'delete_event'        => 'badge-rejected',
                                'create_event'        => 'badge-approved',
                                'update_event'        => 'badge-pending',
                                'update_role'         => 'badge-pending',
                                'toggle_status'       => 'badge-pending',
                                'approve_registration'=> 'badge-approved',
                                'reject_registration' => 'badge-rejected',
                            ];
                        @endphp
                        <span class="badge {{ $colors[$log->action] ?? 'badge-user' }}">{{ $log->action }}</span>
                    </td>
                    <td>{{ $log->description }}</td>
                    <td style="color:#6b7280;font-size:.8rem;">{{ $log->ip_address }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align:center;color:#9ca3af;padding:32px;">Belum ada aktivitas tercatat.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="pagination-wrapper">
        <span>Menampilkan {{ $logs->firstItem() ?? 0 }}–{{ $logs->lastItem() ?? 0 }} dari {{ $logs->total() }} log</span>
        {{ $logs->links() }}
    </div>
</div>
@endsection
