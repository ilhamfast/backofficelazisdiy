<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- @vite('resources/css/app.css') --}}
    {{-- <script src="//unpkg.com/alpinejs" defer></script> --}}
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css" rel="stylesheet">

    <title>Zakat</title>
    <style>
        [x-cloak] {
            display: none !important;
        }

        ,

        .hidden {
            display: none !important;
        }
    </style>
</head>

<body class="h-screen bg-gray-100 overflow-x-hidden">
    @include('sweetalert::alert')
    <div class="flex h-full">
        <!-- Sidebar -->
        <aside class="w-56 h-full bg-white shadow-md fixed z-40">
            @include('includes.sidebar')
        </aside>

        <!-- Main Content -->
        <div class="flex-1 ml-56">
            <!-- Header -->
            <header class="bg-white p-4 shadow-md mb-10">
                @include('includes.header')
            </header>

            <!-- Content -->
            <main class="p-4 max-w-5xl mx-auto">
                <div class="bg-white col-span-3 rounded-md mt-2 mx-2 shadow-xl">
                    <div class="mx-5">
                        <div class="flex justify-between items-center mb-6">
                            <div class="mt-2">
                                <h1 class="text-2xl font-semibold text-gray-900">Kabar Terbaru</h1>
                            </div>

                            <div x-data="{ isOpen: false }" class="relative mt-10">

                                <!-- Tombol untuk membuka modal -->
                                <button type="button" @click="isOpen = true"
                                    class="bg-green-600 p-2 rounded-md shadow-md text-white">Buat kabar terbaru</button>

                                <div>

                                </div>
                            </div>



                        </div>
                        <div class="overflow-auto w-full">
                            <div class="max-h-[calc(100vh-240px)] overflow-y-auto">
                                <table id="transaction-table" class="min-w-full bg-white table-auto overflow-x-auto">
                                    <thead class="sticky top-0 z-10">
                                        <!-- Table Header -->
                                        <tr>
                                            <th
                                                class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                No
                                            </th>
                                            <th
                                                class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Tanggal berita
                                            </th>
                                            <th
                                                class="px-6 py-3 border-b text-center border-gray-200 bg-gray-50 text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Image
                                            </th>
                                            <th
                                                class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Deskripsi
                                            </th>
                                            <th
                                                class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                category
                                            </th>
                                            <th
                                                class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                name
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach ($newss as $index => $news)
                                            @php
                                                $globalIndex = $index + 1;
                                            @endphp
                                            <tr>
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    {{ $globalIndex }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $news['latest_news_date'] }}</td>

                                                <!-- Gambar di dalam tabel, menggunakan class dan data-image -->
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    <img src="{{ $news['image'] }}" alt="Image"
                                                        class="w-96 h-auto rounded-md cursor-pointer imageModalTrigger"
                                                        data-image="{{ $news['image'] }}">
                                                </td>

                                                <!-- Modal untuk menampilkan gambar besar -->
                                                <div id="imageModal"
                                                    class="fixed inset-0 z-50 bg-black bg-opacity-50 hidden justify-center items-center">
                                                    <div
                                                        class="relative w-full h-full flex items-center justify-center">
                                                        <span id="closeModal"
                                                            class="absolute top-2 right-2 text-white text-3xl cursor-pointer">&times;</span>
                                                        <img id="modalImage" src="" alt="Full Image"
                                                            class="max-w-6xl max-h-[calc(100vh-5rem)] object-contain">
                                                    </div>
                                                </div>


                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-ellipsis text-sm line-clamp-5 text-wrap text-justify text-gray-500">
                                                    {{ $news['description'] }}
                                                </td>
                                                <td class="px-6 py-4 w-32 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $news['category'] }}
                                                </td>
                                                <td
                                                    class="px-6 py-4 text-sm  text-gray-500 text-wrap truncate overflow-hidden">
                                                    {{ $news['campaign_name'] }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

        </div>
        </main>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>
    <script>
        // Ambil semua elemen gambar dengan kelas 'imageModalTrigger'
        const images = document.querySelectorAll('.imageModalTrigger');
        const modal = document.getElementById('imageModal');
        const modalImage = document.getElementById('modalImage');
        const closeModal = document.getElementById('closeModal');

        // Loop melalui semua gambar dan tambahkan event listener
        images.forEach(image => {
            image.addEventListener('click', function() {
                const imageSrc = image.getAttribute(
                    'data-image'); // Ambil src gambar dari atribut data-image
                modal.classList.remove('hidden'); // Tampilkan modal
                modalImage.src = imageSrc; // Set gambar modal menjadi gambar yang diklik
            });
        });

        // Ketika tombol close modal diklik, sembunyikan modal
        closeModal.addEventListener('click', function() {
            modal.classList.add('hidden');
        });

        // Menutup modal jika area luar gambar diklik
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                modal.classList.add('hidden');
            }
        });
    </script>


</body>

</html>
