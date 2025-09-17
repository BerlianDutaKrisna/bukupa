<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Aplikasi BukuPA' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="bg-gray-100 text-gray-800">
    <header class="bg-sky-500 text-white p-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <a href="{{ route('dashboard') }}" class="text-xl font-bold hover:underline">
                Buku Digital Penerimaan Speciment Patologi Anatomi
            </a>
            <nav>
                <ul class="flex space-x-4">
                    <li><a href="{{ route('dashboard') }}" class="hover:text-gray-200">Dashboard</a></li>
                    <li><a href="{{ route('pemeriksaan') }}" class="hover:text-gray-200">Pemeriksaan</a></li>
                    <li><a href="{{ route('transaksi') }}" class="hover:text-gray-200">Transaksi</a></li>
                    <li><a href="{{ route('pasien') }}" class="hover:text-gray-200">Pasien</a></li>
                    <li><a href="{{ route('unit-asal') }}" class="hover:text-gray-200">Unit Asal</a></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="hover:text-gray-200">Logout</button>
                        </form>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="w-full min-h-screen p-6">
        {{ $slot }}
    </main>

    <footer class="bg-sky-800 text-white p-6 mt-6">
        <!-- Baris 1 -->
        <div class="flex justify-between items-center mb-4">
            <!-- Kiri: Copyright -->
            <div class="text-left text-white">
                &copy; 2025 PA-LIS — Developed by Berlian Duta Krisna, S.Tr.Kes
            </div>
            <!-- Kanan: Sosial Media -->
            <div class="flex space-x-4">
                <!-- Instagram -->
                <a href="https://instagram.com/username" target="_blank" class="hover:text-pink-500 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="white" viewBox="0 0 24 24">
                        <path
                            d="M7.75 2h8.5A5.76 5.76 0 0122 7.75v8.5A5.76 5.76 0 0116.25 22h-8.5A5.76 5.76 0 012 16.25v-8.5A5.76 5.76 0 017.75 2zm0 1.5A4.25 4.25 0 003.5 7.75v8.5A4.25 4.25 0 007.75 20.5h8.5a4.25 4.25 0 004.25-4.25v-8.5A4.25 4.25 0 0016.25 3.5h-8.5zm8.5 2a.75.75 0 110 1.5.75.75 0 010-1.5zm-4.25 1.25a5.5 5.5 0 110 11 5.5 5.5 0 010-11zm0 1.5a4 4 0 100 8 4 4 0 000-8z" />
                    </svg>
                </a>
                <!-- LinkedIn -->
                <a href="https://linkedin.com/in/username" target="_blank" class="hover:text-blue-400 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="white" viewBox="0 0 24 24">
                        <path
                            d="M4.98 3.5C4.98 4.88 3.87 6 2.5 6S0 4.88 0 3.5 1.12 1 2.5 1 4.98 2.12 4.98 3.5zM.22 8h4.56v16H.22V8zm7.72 0h4.38v2.25h.06c.61-1.16 2.11-2.38 4.34-2.38 4.64 0 5.5 3.06 5.5 7.04V24h-4.56v-6.97c0-1.66-.03-3.8-2.32-3.8-2.32 0-2.68 1.81-2.68 3.68V24H7.94V8z" />
                    </svg>
                </a>
                <!-- Email -->
                <a href="mailto:email@example.com" class="hover:text-yellow-300 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="white" viewBox="0 0 24 24">
                        <path d="M12 13.065l-11.964-7.065h23.928L12 13.065zm0 2.935L0 6v12h24V6l-12 10z" />
                    </svg>
                </a>
            </div>
        </div>

        <!-- Baris 2 -->
        <div class="flex justify-between items-center">
            <!-- Kiri: Info versi + ikon -->
            <div class="flex items-center space-x-3 text-sm text-white">
                <span class="flex items-center space-x-1">
                    <!-- PHP Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" fill="white" class="h-5 w-5">
                        <path
                            d="M320 168.5C491.4 168.5 623.2 240.7 623.2 320C623.2 399.3 491.3 471.5 320 471.5C148.6 471.5 16.8 399.3 16.8 320C16.8 240.7 148.7 168.5 320 168.5zM320 151.7C143.3 151.7 0 227 0 320C0 413 143.3 488.3 320 488.3C496.7 488.3 640 413 640 320C640 227 496.7 151.7 320 151.7zM218.2 306.5C210.3 347 182.4 342.8 148.1 342.8L161.8 272.2C199.8 272.2 225.6 268.1 218.2 306.5zM97.4 414.3L134.1 414.3L142.8 369.5C183.9 369.5 209.4 372.5 233 350.4C259.1 326.4 265.9 283.7 247.3 262.3C237.6 251.1 222 245.6 200.8 245.6L130.1 245.6L97.4 414.3zM283.1 200.7L319.6 200.7L310.9 245.5C342.4 245.5 371.6 243.2 385.7 256.2C400.5 269.8 393.4 287.2 377.4 369.3L340.4 369.3C355.8 289.9 358.7 283.3 353.1 277.3C347.7 271.5 335.4 272.7 305.7 272.7L286.9 369.3L250.4 369.3L283.1 200.7zM505 306.5C497 347.6 468.3 342.8 434.9 342.8L448.6 272.2C486.8 272.2 512.4 268.1 505 306.5zM384.2 414.3L421 414.3L429.7 369.5C472.9 369.5 496.8 372 519.9 350.4C546 326.4 552.8 283.7 534.2 262.3C524.5 251.1 508.9 245.6 487.7 245.6L417 245.6L384.2 414.3z" />
                    </svg>
                    <span>PHP 8.1 (Laravel 10)</span>
                </span>
                <span class="flex items-center space-x-1">
                    <!-- Tailwind Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" fill="white" class="h-5 w-5">
                        <path
                            d="M544 96L480 464L256.7 544L64 464L83.6 369.2L165.6 369.2L157.6 409.8L274 454.2L408.1 409.8L426.9 312.7L93.5 312.7L109.5 230.7L443.2 230.7L453.7 178L120.3 178L136.6 96L544 96z" />
                    </svg>
                    <span>Tailwind CSS 3</span>
                </span>
                <span class="flex items-center space-x-1">
                    <!-- Database Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" fill="white" class="h-5 w-5">
                        <path
                            d="M544 269.8C529.2 279.6 512.2 287.5 494.5 293.8C447.5 310.6 385.8 320 320 320C254.2 320 192.4 310.5 145.5 293.8C127.9 287.5 110.8 279.6 96 269.8L96 352C96 396.2 196.3 432 320 432C443.7 432 544 396.2 544 352L544 269.8zM544 192L544 144C544 99.8 443.7 64 320 64C196.3 64 96 99.8 96 144L96 192C96 236.2 196.3 272 320 272C443.7 272 544 236.2 544 192zM494.5 453.8C447.6 470.5 385.9 480 320 480C254.1 480 192.4 470.5 145.5 453.8C127.9 447.5 110.8 439.6 96 429.8L96 496C96 540.2 196.3 576 320 576C443.7 576 544 540.2 544 496L544 429.8C529.2 439.6 512.2 447.5 494.5 453.8z" />
                    </svg>
                    <span>MySQL (MySQLi)</span>
                </span>
            </div>
            <div></div>
        </div>
    </footer>
    <script>
        async function syncTransaksi() {
            try {
                const res = await fetch("{{ route('transaksi.sync') }}");
                const result = await res.json();

                if (result.success) {
                    console.log("[syncTransaksi] Total data dari API:", result.total_api);
                    console.log("[syncTransaksi] Data baru ditambahkan:", result.inserted);
                } else {
                    console.error("[syncTransaksi] Gagal sync:", result.error);
                }
            } catch (err) {
                console.error("[syncTransaksi] Fetch error:", err);
            }
        }

        async function syncPemeriksaan() {
            try {
                const response = await fetch(`/api/transaksi/recent`);
                const transaksiList = await response.json();

                let updatedCount = 0;

                for (const trx of transaksiList) {
                    const res = await fetch(`/api/pemeriksaan/update-status`, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute(
                                "content")
                        },
                        body: JSON.stringify({
                            norm: trx.norm,
                            tanggal: trx.tanggal
                        })
                    });

                    if (res.ok) {
                        const result = await res.json();
                        if (result.updated) updatedCount++;
                    }
                }

                console.log(`[syncPemeriksaan] ${updatedCount} pemeriksaan berhasil diupdate`);
            } catch (err) {
                console.error("[syncPemeriksaan] Gagal:", err);
            }
        }

        // Fungsi gabungan
        async function runSync() {
            console.log("=== Mulai proses sinkronisasi ===");
            await syncTransaksi();
            await syncPemeriksaan();
            console.log("=== Selesai sinkronisasi ===");
        }

        // Panggil saat halaman dibuka
        document.addEventListener("DOMContentLoaded", () => {
            runSync();
            // Auto sync tiap 5 menit
            setInterval(runSync, 5 * 60 * 1000);
        });
    </script>
    @livewireScripts
    @vite('resources/js/app.js')
</body>

</html>
