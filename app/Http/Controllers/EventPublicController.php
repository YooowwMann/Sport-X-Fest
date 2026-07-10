<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\GalleryPhoto;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventPublicController extends Controller
{
    // Halaman home publik dengan upcoming events
    public function home()
    {
        $events = Event::where('status', 'open')
            ->withCount([
                'registrations as approved_count' => fn($q) => $q->where('status', 'approved'),
            ])
            ->orderBy('date')
            ->take(4)
            ->get();

        return view('home', compact('events'));
    }

    // Daftar semua event (halaman publik)
    public function index()
    {
        $events = Event::withCount([
            'registrations as peserta_count',
            'registrations as approved_count' => fn($q) => $q->where('status', 'approved'),
        ])->orderBy('date')->get();

        return view('events.public_index', compact('events'));
    }

    // Halaman pendaftaran
    public function daftar(Request $request)
    {
        $events = Event::where('status', 'open')->orderBy('date')->get();
        // Konsisten: terima event_id atau id_event dari query string
        $id_event = $request->query('event_id') ?? $request->query('id_event');

        // Riwayat pendaftaran user yang sedang login
        $myRegistrations = collect();
        if (Auth::check()) {
            $myRegistrations = Registration::with('event')
                ->where('user_id', Auth::id())
                ->latest()
                ->get();
        }

        return view('events.daftar', compact('events', 'id_event', 'myRegistrations'));
    }

    // Proses pendaftaran
    public function prosesDaftar(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
        ]);

        $event = Event::findOrFail($request->event_id);

        // Cek kuota
        $approved = $event->approvedRegistrations()->count();
        if ($approved >= $event->quota) {
            return back()->with('error', 'Kuota event ini sudah penuh.');
        }

        // Cek sudah daftar belum
        $sudahDaftar = Registration::where('user_id', Auth::id())
            ->where('event_id', $request->event_id)
            ->exists();

        if ($sudahDaftar) {
            return back()->with('error', 'Kamu sudah terdaftar di event ini.');
        }

        Registration::create([
            'user_id'  => Auth::id(),
            'event_id' => $request->event_id,
            'status'   => 'pending',
        ]);

        return back()->with('success', 'Pendaftaran berhasil! Menunggu persetujuan admin.');
    }

    // Halaman dokumentasi
    public function dokumentasi()
    {
        $photos = GalleryPhoto::with('event')->latest()->get();

        $galleryGroups = $photos
            ->groupBy(fn (GalleryPhoto $photo) => $photo->event_id ?? 'archived')
            ->map(function ($group) {
                return [
                    'event' => $group->first()->event,
                    'photos' => $group,
                ];
            })
            ->values();

        return view('events.dokumentasi', compact('galleryGroups'));
    }

    // Halaman contact
    public function contact()
    {
        return view('events.contact');
    }
}
