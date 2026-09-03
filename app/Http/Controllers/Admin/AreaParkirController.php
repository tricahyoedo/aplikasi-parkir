<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AreaParkir;
use Illuminate\Http\Request;

class AreaParkirController extends Controller
{
    public function index()
    {
        // Hitung terisi secara dinamis berdasarkan jumlah kendaraan di setiap area
        $areas = AreaParkir::withCount('kendaraans')->get();

        // Sinkronisasi kolom terisi dengan jumlah nyata
        foreach ($areas as $area) {
            $area->update(['terisi' => $area->kendaraans_count]);
        }

        // Ambil ulang setelah update
        $areas = AreaParkir::withCount('kendaraans')->get();

        return view('admin.area', compact('areas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_area' => 'required|string|max:50',
            'kapasitas' => 'required|integer|min:1',
        ]);

        AreaParkir::create([
            'nama_area' => $request->nama_area,
            'kapasitas' => $request->kapasitas,
            'terisi' => 0,
        ]);

        return redirect()->route('admin.area.index')->with('success', 'Area Parkir berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_area' => 'required|string|max:50',
            'kapasitas' => 'required|integer|min:1',
            'terisi' => 'required|integer|min:0',
        ]);

        $area = AreaParkir::findOrFail($id);
        $area->update([
            'nama_area' => $request->nama_area,
            'kapasitas' => $request->kapasitas,
            'terisi' => $request->terisi,
        ]);

        return redirect()->route('admin.area.index')->with('success', 'Area Parkir berhasil diperbarui.');
    }

    public function destroy($id)
    {
        AreaParkir::findOrFail($id)->delete();
        return redirect()->route('admin.area.index')->with('success', 'Area Parkir berhasil dihapus.');
    }
}
