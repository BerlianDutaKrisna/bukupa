<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemeriksaan;
use App\Models\Pasien;
use Carbon\Carbon;

class PemeriksaanSyncController extends Controller
{
    public function updateStatus(Request $request)
    {
        $norm = $request->input('norm');
        $tanggal = Carbon::parse($request->input('tanggal'));

        // Cari pasien berdasarkan norm
        $pasien = Pasien::where('norm', $norm)->first();
        if (!$pasien) {
            return response()->json([
                'updated' => false,
                'reason' => 'Pasien tidak ditemukan',
            ]);
        }

        // Cek pemeriksaan 3 hari terakhir
        $threeDaysAgo = Carbon::today()->subDays(3);
        $pemeriksaan = Pemeriksaan::where('id_pasien', $pasien->id)
            ->whereBetween('tanggal_pemeriksaan', [$threeDaysAgo, Carbon::today()])
            ->first();

        if ($pemeriksaan) {
            $pemeriksaan->update(['status' => 'Registered']);
            return response()->json(['updated' => true]);
        }

        return response()->json([
            'updated' => false,
            'reason' => 'Tidak ada pemeriksaan dalam 3 hari terakhir',
        ]);
    }
}
