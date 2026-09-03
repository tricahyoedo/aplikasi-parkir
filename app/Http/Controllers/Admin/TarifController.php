<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tarif;
use Illuminate\Http\Request;

class TarifController extends Controller
{
    public function index()
    {
        $tarifs = Tarif::all();
        return view('admin.tarif', compact('tarifs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_kendaraan' => 'required|string|max:20',
            'tarif_per_jam' => 'required|numeric|min:0',
            'tarif_maksimal' => 'required|numeric|min:0',
        ]);

        Tarif::create($request->all());

        return redirect()->route('admin.tarif.index')->with('success', 'Tarif berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jenis_kendaraan' => 'required|string|max:20',
            'tarif_per_jam' => 'required|numeric|min:0',
            'tarif_maksimal' => 'required|numeric|min:0',
        ]);

        $tarif = Tarif::findOrFail($id);
        $tarif->update($request->all());

        return redirect()->route('admin.tarif.index')->with('success', 'Tarif berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Tarif::findOrFail($id)->delete();
        return redirect()->route('admin.tarif.index')->with('success', 'Tarif berhasil dihapus.');
    }
}
