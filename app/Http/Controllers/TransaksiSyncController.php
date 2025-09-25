<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Transaksi;

class TransaksiSyncController extends Controller
{
    public function sync()
    {
        $insertedCount = 0;

        // Tanggal 3 hari terakhir
        $startDate = now()->subDays(2)->format('Y-m-d');
        $endDate   = now()->format('Y-m-d');

        // Format: 2025-08-06-2025-08-07
        $url = "http://172.20.29.240/apibdrs/apibdrs/getKunjunganPasien/{$startDate}/{$endDate}";

        try {
            $response = Http::withoutVerifying()->get($url);

            if (!$response->successful()) {
                return response()->json([
                    'success' => false,
                    'error' => "Gagal memanggil API",
                ], 500);
            }

            $json = $response->json();

            $totalApi = 0;

            if (isset($json['status']) && $json['status'] === "Ok" && isset($json['data'])) {
                $totalApi = count($json['data']);

                foreach ($json['data'] as $item) {
                    $exists = Transaksi::where('idtransaksi', $item['idtransaksi'])->exists();

                    if (!$exists) {
                        Transaksi::create($item);
                        $insertedCount++;
                    }
                }
            }

            return response()->json([
                'success' => true,
                'inserted' => $insertedCount,
                'total_api' => $totalApi,
                'range' => "{$startDate} s/d {$endDate}",
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function recent()
    {
        $today = now()->startOfDay();
        $threeDaysAgo = now()->subDays(2)->startOfDay();

        $data = Transaksi::whereBetween('tanggal', [$threeDaysAgo, $today])
            ->get(['idtransaksi', 'norm', 'tanggal']);

        return response()->json($data);
    }
}
