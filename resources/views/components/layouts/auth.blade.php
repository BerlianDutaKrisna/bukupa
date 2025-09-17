@props(['title' => 'Auth Page', 'subtitle' => ''])

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/pemkot.png') }}">
    <title>{{ $title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="min-h-screen bg-cover bg-center flex items-center justify-center"
    style="background-image: url('{{ asset('assets/img/bg1.jpg') }}');">

    <!-- Card transparan -->
    <div
        class="w-full max-w-5xl backdrop-blur-sm bg-white/30 border border-white/20 shadow-xl rounded-xl overflow-hidden flex flex-col md:flex-row">

        <!-- Gambar kiri -->
        <div class="hidden md:flex md:w-1/2 backdrop-blur-sm text-white items-center justify-center p-8 bg-cover bg-center"
            style="background-image: url('{{ asset('assets/img/tissue1.jpg') }}');">
            <div class="p-6 rounded-lg">
                <h1 class="text-3xl font-bold mb-4 text-black">Buku Penerimaan Spesimen</h1>
                <p class="text-lg text-gray-700">
                    Patologi Anatomi Laboratorium Information System (PALIS)
                </p>
            </div>
        </div>

        <!-- Konten kanan -->
        <div class="w-full md:w-1/2 p-8">
            <div class="text-center mb-6">
                <img src="{{ asset('assets/img/pemkot.png') }}" alt="Logo Pemkot" class="mx-auto h-20 w-auto mb-4">
                <h2 class="text-2xl font-bold text-black">{{ $title }}</h2>
                <p class="text-gray-700">{{ $subtitle }}</p>
            </div>
            {{ $slot }}
        </div>
    </div>
</body>

</html>
