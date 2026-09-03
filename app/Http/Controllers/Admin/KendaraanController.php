<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AreaParkir;
use App\Models\Kendaraan;
use App\Models\User;
use Illuminate\Http\Request;

class KendaraanController extends Controller
{
    public function index()
    {
        $kendaraans = Kendaraan::with(['user', 'area'])->get();
        $users = User::all();
        $areas = AreaParkir::withCount('kendaraans')->get();
        return view('admin.kendaraan', compact('kendaraans', 'users', 'areas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'plat_nomor'      => 'required|string|max:15|unique:tb_kendaraan,plat_nomor',
            'jenis_kendaraan' => 'required|string|max:20',
            'merk'            => 'required|string|max:50',
            'pemilik'         => 'required|string|max:100',
            'id_user'         => 'required|exists:tb_user,id_user',
            'id_area'         => 'required|exists:tb_area_parkir,id_area',
        ]);

        // Cek apakah area masih ada kapasitas (hitung nyata dari DB)
        $area = AreaParkir::withCount('kendaraans')->findOrFail($request->id_area);
        if ($area->kendaraans_count >= $area->kapasitas) {
            return back()->withErrors(['id_area' => 'Area parkir "' . $area->nama_area . '" sudah penuh!'])->withInput();
        }

        Kendaraan::create($request->all());

        return redirect()->route('admin.kendaraan.index')->with('success', 'Kendaraan berhasil ditambahkan ke area ' . $area->nama_area . '.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'plat_nomor'      => 'required|string|max:15|unique:tb_kendaraan,plat_nomor,' . $id . ',id_kendaraan',
            'jenis_kendaraan' => 'required|string|max:20',
            'merk'            => 'required|string|max:50',
            'pemilik'         => 'required|string|max:100',
            'id_user'         => 'required|exists:tb_user,id_user',
            'id_area'         => 'required|exists:tb_area_parkir,id_area',
        ]);

        $kendaraan = Kendaraan::findOrFail($id);
        $kendaraan->update($request->all());

        return redirect()->route('admin.kendaraan.index')->with('success', 'Kendaraan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kendaraan = Kendaraan::findOrFail($id);
        $area = AreaParkir::find($kendaraan->id_area);

        $kendaraan->delete();

        return redirect()->route('admin.kendaraan.index')->with('success', 'Kendaraan berhasil dihapus.');
    }
}
