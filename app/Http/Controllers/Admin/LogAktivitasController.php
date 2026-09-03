<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LogAktivitas;

class LogAktivitasController extends Controller
{
    public function index()
    {
        $logs = LogAktivitas::with('user')->orderBy('waktu_aktivitas', 'desc')->get();
        return view('admin.log', compact('logs'));
    }
}
