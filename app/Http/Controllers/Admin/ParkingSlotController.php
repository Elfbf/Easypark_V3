<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ParkingSlot;
use App\Models\ParkingArea;
use App\Models\VehicleType;
use Illuminate\Http\Request;

class ParkingSlotController extends Controller
{
    public function index(Request $request)
    {
        $search     = $request->query('search');
        $areaFilter = $request->query('parking_area_id');

        $parkingSlots = ParkingSlot::with(['parkingArea', 'vehicleType'])
            ->when($search, fn($query, $search) =>
                $query->where('slot_code', 'like', "%{$search}%")
            )
            ->when($areaFilter, fn($query) =>
                $query->where('parking_area_id', $areaFilter)
            )
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $parkingAreas = ParkingArea::all();
        $vehicleTypes = VehicleType::all();

        return view('admin.parking-slots.index', compact(
            'parkingSlots',
            'parkingAreas',
            'vehicleTypes',
            'search',
            'areaFilter'
        ));
    }

    public function create()
    {
        $parkingAreas = ParkingArea::all();
        $vehicleTypes = VehicleType::all();
        return view('admin.parking-slots.create', compact('parkingAreas', 'vehicleTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'slot_code'       => 'required|string|unique:parking_slots',
            'parking_area_id' => 'required|exists:parking_areas,id',
            'vehicle_type_id' => 'required|exists:vehicle_types,id',
        ]);

        ParkingSlot::create($request->all());

        return redirect()->route('admin.parking-slots.index')
            ->with('success', 'Slot parkir berhasil ditambahkan.');
    }

    public function edit(ParkingSlot $parkingSlot)
    {
        $parkingAreas = ParkingArea::all();
        $vehicleTypes = VehicleType::all();
        return view('admin.parking-slots.edit', compact('parkingSlot', 'parkingAreas', 'vehicleTypes'));
    }

    public function update(Request $request, ParkingSlot $parkingSlot)
    {
        $request->validate([
            'slot_code'       => 'required|string|unique:parking_slots,slot_code,' . $parkingSlot->id,
            'parking_area_id' => 'required|exists:parking_areas,id',
            'vehicle_type_id' => 'required|exists:vehicle_types,id',
        ]);

        $parkingSlot->update($request->all());

        return redirect()->route('admin.parking-slots.index')
            ->with('success', 'Slot parkir berhasil diperbarui.');
    }

    public function destroy(ParkingSlot $parkingSlot)
    {
        $parkingSlot->delete();

        return redirect()->route('admin.parking-slots.index')
            ->with('success', 'Slot parkir berhasil dihapus.');
    }
}