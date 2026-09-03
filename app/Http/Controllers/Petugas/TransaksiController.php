<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\AreaParkir;
use App\Models\Kendaraan;
use App\Models\LogAktivitas;
use App\Models\Tarif;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    public function index()
    {
        // Transaksi yang sedang aktif (masuk, belum keluar)
        $transaksiAktif = Transaksi::with(['kendaraan', 'areaParkir', 'tarif'])
            ->where('status', 'masuk')
            ->orderByDesc('waktu_masuk')
            ->get();

        // Riwayat transaksi selesai hari ini
        $riwayat = Transaksi::with(['kendaraan', 'areaParkir', 'tarif'])
            ->where('status', 'keluar')
            ->whereDate('waktu_keluar', now()->toDateString())
            ->orderByDesc('waktu_keluar')
            ->get();

        $kendaraans = Kendaraan::all();
        $areas = AreaParkir::all();
        $tarifs = Tarif::all();

        return view('petugas.transaksi', compact('transaksiAktif', 'riwayat', 'kendaraans', 'areas', 'tarifs'));
    }

    public function masuk(Request $request)
    {
        $request->validate([
            'id_kendaraan' => 'required|exists:tb_kendaraan,id_kendaraan',
            'id_area'      => 'required|exists:tb_area_parkir,id_area',
            'id_tarif'     => 'required|exists:tb_tarif,id_tarif',
        ]);

        // Cek apakah kendaraan masih di dalam (belum keluar)
        $aktif = Transaksi::where('id_kendaraan', $request->id_kendaraan)
            ->where('status', 'masuk')
            ->first();

        if ($aktif) {
            return back()->withErrors(['id_kendaraan' => 'Kendaraan ini masih berada di dalam parkiran!'])->withInput();
        }

        // Cek kapasitas area
        $area = AreaParkir::findOrFail($request->id_area);
        if ($area->terisi >= $area->kapasitas) {
            return back()->withErrors(['id_area' => 'Area parkir sudah penuh!'])->withInput();
        }

        // Buat transaksi masuk
        Transaksi::create([
            'id_kendaraan' => $request->id_kendaraan,
            'waktu_masuk'  => now(),
            'id_tarif'     => $request->id_tarif,
            'status'       => 'masuk',
            'id_user'      => Auth::user()->id_user,
            'id_area'      => $request->id_area,
        ]);

        // Tambah jumlah terisi area
        $area->increment('terisi');

        // Log aktivitas
        LogAktivitas::create([
            'id_user'          => Auth::user()->id_user,
            'aktivitas'        => 'Kendaraan masuk: ' . Kendaraan::find($request->id_kendaraan)->plat_nomor . ' ke area ' . $area->nama_area,
            'waktu_aktivitas'  => now(),
        ]);

        return redirect()->route('petugas.transaksi.index')->with('success', 'Kendaraan berhasil dicatat masuk!');
    }

    public function keluar(Request $request, $id_parkir)
    {
        $transaksi = Transaksi::with(['kendaraan', 'areaParkir', 'tarif'])->findOrFail($id_parkir);

        if ($transaksi->status === 'keluar') {
            return back()->with('error', 'Transaksi ini sudah selesai.');
        }

        $waktuMasuk  = \Carbon\Carbon::parse($transaksi->waktu_masuk);
        $waktuKeluar = now();
        $durasiJam   = min(24, max(1, ceil($waktuMasuk->diffInMinutes($waktuKeluar) / 60)));

        $tarif      = $transaksi->tarif;
        // Biaya flat, tidak dikali durasi jam
        $biayaTotal = $tarif->tarif_per_jam;

        $transaksi->update([
            'waktu_keluar' => $waktuKeluar,
            'durasi_jam'   => $durasiJam,
            'biaya_total'  => $biayaTotal,
            'status'       => 'keluar',
        ]);

        // Kurangi jumlah terisi area
        $area = $transaksi->areaParkir;
        if ($area && $area->terisi > 0) {
            $area->decrement('terisi');
        }

        // Log aktivitas
        LogAktivitas::create([
            'id_user'          => Auth::user()->id_user,
            'aktivitas'        => 'Kendaraan keluar: ' . $transaksi->kendaraan->plat_nomor . ' | Durasi: ' . $durasiJam . ' jam | Biaya: Rp ' . number_format($biayaTotal, 0, ',', '.'),
            'waktu_aktivitas'  => now(),
        ]);

        return redirect()->route('petugas.transaksi.index')->with('success', "Kendaraan {$transaksi->kendaraan->plat_nomor} berhasil keluar. Biaya: Rp " . number_format($biayaTotal, 0, ',', '.'));
    }
}
