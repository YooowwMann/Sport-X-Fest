<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Event;
use App\Models\Registration;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users'         => User::where('role', 'user')->count(),
            'total_events'        => Event::count(),
            'total_registrations' => Registration::count(),
            'active_events'       => Event::where('status', 'open')
                                         ->where('date', '>=', now()->toDateString())
                                         ->count(),
        ];

        // Data chart: registrasi per event (top 7)
        $chartEvents = Event::withCount('registrations')
            ->orderByDesc('registrations_count')
            ->limit(7)
            ->get();

        // Data chart: registrasi per bulan (12 bulan terakhir)
        $monthlyData = Registration::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        $monthlyChart = [];
        for ($m = 1; $m <= 12; $m++) {
            $monthlyChart[] = $monthlyData[$m] ?? 0;
        }

        $recentLogs = ActivityLog::with('user')
            ->latest()
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'chartEvents', 'monthlyChart', 'recentLogs'));
    }
}
