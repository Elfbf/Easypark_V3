<?php

namespace App\Http\Controllers;

use App\Models\ParkingArea;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class LandingController extends Controller
{
    public function index(): View
    {
        $activeUsers = \App\Models\User::where('is_active', true)->count();

        return view('landing.index', compact('activeUsers'));
    }

    public function user(): View
    {
        $recommendations = $this->getRecommendations();

        return view('landing.user', compact('recommendations'));
    }

    public function cekSlot(): View
    {
        $recommendations = $this->getRecommendations();

        return view('landing.cek-slot', compact('recommendations'));
    }

    /**
     * Endpoint polling: dicek landing.user tiap 2 detik.
     * Kalau ada flag kiosk_just_confirmed → kembalikan triggered=true
     * dan langsung hapus flag agar tidak dobel trigger.
     */
    public function kioskStatus()
    {
        $flag = Cache::get('kiosk_just_confirmed');

        if ($flag && $flag['aksi'] === 'masuk') {
            Cache::forget('kiosk_just_confirmed');

            return response()->json([
                'triggered' => true,
                'aksi'      => $flag['aksi'],
                'plate'     => $flag['plate_number'],
            ]);
        }

        if ($flag && $flag['aksi'] === 'keluar') {
            Cache::forget('kiosk_just_confirmed');
        }

        return response()->json(['triggered' => false]);
    }

    public function info(): View
    {
        $areas = ParkingArea::where('is_active', true)->get();

        return view('landing.info', compact('areas'));
    }

    // -------------------------------------------------------------------------
    // Private Helpers
    // -------------------------------------------------------------------------

    private function getRecommendations(): \Illuminate\Support\Collection
    {
        return ParkingArea::withCount([
            'parkingRecords as parked_count' => fn($q) => $q->where('status', 'parked'),
        ])
            ->where('is_active', true)
            ->get()
            ->each(fn($area) => $area->available_count = max(0, $area->capacity - $area->parked_count))
            ->sortByDesc('available_count')
            ->values();
    }
}
