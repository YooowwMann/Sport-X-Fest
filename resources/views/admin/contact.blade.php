@extends('admin.layouts.app')

@section('title', 'Contact Inbox')
@section('page-title', 'Contact Inbox')

@section('content')
<div class="card">
    <div class="card-header">
        <div>
            <span class="card-title"><i class="fas fa-envelope-open-text"></i> Pesan Masuk</span>
            <p style="margin-top:6px;color:#6b7280;font-size:.85rem;">Lihat pesan dari pengunjung dan balas via email pengirim.</p>
        </div>
    </div>

    <div class="card-body">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Subject</th>
                    <th>Pesan</th>
                    <th>Dikirim</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($contacts as $contact)
                    <tr>
                        <td style="color:#9ca3af;">{{ $loop->iteration + (($contacts->currentPage() - 1) * $contacts->perPage()) }}</td>
                        <td>
                            <div style="font-weight:600;">{{ $contact->nama }}</div>
                        </td>
                        <td>
                            <a href="mailto:{{ $contact->email }}" style="color:#e94560;text-decoration:none;font-weight:600;">{{ $contact->email }}</a>
                        </td>
                        <td style="font-weight:600;">{{ $contact->subject }}</td>
                        <td>
                            <div style="max-width:380px; white-space:pre-wrap; color:#374151; line-height:1.6;">
                                {{ $contact->pesan }}
                            </div>
                        </td>
                        <td style="color:#6b7280; font-size:.85rem;">
                            {{ $contact->created_at?->format('d M Y, H:i') }}
                        </td>
                        <td>
                            <div style="display:flex; gap:8px; flex-wrap:wrap;">
                                @php
                                    $replySubject = rawurlencode('Re: ' . $contact->subject);
                                    $replyBody = rawurlencode("Halo {$contact->nama},\n\nTerima kasih sudah menghubungi SportXFest.\n\n");
                                @endphp
                                <a class="btn btn-primary btn-sm" href="mailto:{{ $contact->email }}?subject={{ $replySubject }}&body={{ $replyBody }}">
                                    <i class="fas fa-reply"></i> Balas
                                </a>
                                <form id="delete-contact-{{ $contact->id }}" method="POST" action="{{ route('admin.contacts.destroy', $contact) }}">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('delete-contact-{{ $contact->id }}', '{{ addslashes($contact->nama) }}')">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align:center;color:#9ca3af;padding:36px;">
                            Belum ada pesan masuk.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-wrapper">
        <span>Menampilkan {{ $contacts->firstItem() ?? 0 }}–{{ $contacts->lastItem() ?? 0 }} dari {{ $contacts->total() }} pesan</span>
        {{ $contacts->links() }}
    </div>
</div>
@endsection