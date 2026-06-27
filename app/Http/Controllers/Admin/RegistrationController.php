<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Event;
use App\Models\Registration;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function index(Request $request)
    {
        $query = Registration::with(['user', 'event']);

        if ($request->filled('event_id')) {
            $query->where('event_id', $request->event_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $registrations = $query->latest()->paginate(10)->withQueryString();
        $events        = Event::orderBy('title')->get();

        return view('admin.registrations.index', compact('registrations', 'events'));
    }

    public function approve(Registration $registration)
    {
        // Cek kuota
        $event    = $registration->event;
        $approved = $event->approvedRegistrations()->count();

        if ($approved >= $event->quota) {
            return back()->with('error', 'Kuota event sudah penuh.');
        }

        $registration->update(['status' => 'approved']);
        ActivityLog::record('approve_registration', "Registrasi {$registration->user->email} di event '{$registration->event->title}' disetujui");

        return back()->with('success', 'Registrasi berhasil disetujui.');
    }

    public function reject(Registration $registration)
    {
        $registration->update(['status' => 'rejected']);
        ActivityLog::record('reject_registration', "Registrasi {$registration->user->email} di event '{$registration->event->title}' ditolak");

        return back()->with('success', 'Registrasi berhasil ditolak.');
    }
}
