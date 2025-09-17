<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Transaksi;

class TransaksiSyncController extends Controller
{
    public function sync()
    {
        $today = now()->format('Y-m-d');
        $url = "http://172.20.29.240/apibdrs/apibdrs/getKunjunganPasien/{$today}";

        try {
            $response = Http::withoutVerifying()->get($url);
            $json = $response->json();

            $insertedCount = 0;

            if (isset($json['status']) && $json['status'] === "Ok") {
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
                'total_api' => $json['data'] ? count($json['data']) : 0,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
