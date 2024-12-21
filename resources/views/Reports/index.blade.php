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

    <title>Laporan</title>
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
                                <h1 class="text-2xl font-semibold text-gray-900">Laporan</h1>
                            </div>

                            <div x-data="{ isOpen: false }" class="relative mt-10">

                                <!-- Tombol untuk membuka modal -->
                                <button type="button" @click="isOpen = true"
                                    class="bg-green-600 p-2 rounded-md shadow-md text-white">Upload laporan</button>

                                <div>
                                    @include('Reports.create')
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
                                                Nama file
                                            </th>
                                            <th
                                                class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                File
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach ($reports as $index => $report)
                                            @php
                                                $globalIndex = $index + 1;
                                            @endphp
                                            <tr>
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    {{ $globalIndex }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $report['title'] }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    <a href="{{ $report['file_url'] }}" target="_blank"
                                                        data-id="{{ $report['id'] }}">
                                                        <img src="{{ asset('assets/img/doc.svg') }}" alt="PDF Preview"
                                                            class="w-7 h-7">
                                                    </a>
                                                </td>
                                                {{-- <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    Rp {{ number_format($report['distribution'], 0, ',', '.') }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    <div class="flex items-center gap-2">
                                                        <div x-data="{ isOpen: false }">
                                                            <button class="text-yellow-800" type="button"
                                                                value="{{ $report['id'] }}" @click="isOpen = true">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 24 24" stroke-width="1.5"
                                                                    stroke="currentColor" class="w-5">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                                </svg>
                                                            </button>
                                                            <div>
                                                                @include('Zakat.edit')
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td> --}}
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


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.getElementById("reportsform");
            const fileNameInput = document.getElementById("file_name");
            const fileInput = document.getElementById("file");
            const errorMessage = document.getElementById("errorMessage");
            const fileError = document.getElementById("file-error");
            const fileNameDisplay = document.getElementById("fileName");
            const fileInfoContainer = document.getElementById("fileInfo");
            const resetButton = document.getElementById("resetButton");
            const submitButton = form.querySelector('[type="submit"]');
            const maxFileSize = 2; // Maksimal ukuran file dalam MB

            // Fungsi untuk menampilkan atau menyembunyikan tombol submit
            function toggleSubmitButton(enable) {
                if (enable) {
                    submitButton.disabled = false;
                    submitButton.classList.remove("bg-gray-400", "cursor-not-allowed");
                    submitButton.classList.add("bg-green-600", "hover:bg-green-700");
                } else {
                    submitButton.disabled = true;
                    submitButton.classList.remove("bg-green-600", "hover:bg-green-700");
                    submitButton.classList.add("bg-gray-400", "cursor-not-allowed");
                }
            }

            // Validasi input nama file
            function validateFileName() {
                const value = fileNameInput.value.trim();
                if (!value) {
                    errorMessage.textContent = "Nama file tidak boleh kosong.";
                    errorMessage.classList.remove("hidden");
                    toggleSubmitButton(false);
                    return false;
                } else {
                    errorMessage.classList.add("hidden");
                    return true;
                }
            }

            // Validasi ukuran file
            function validateFileSize(file) {
                const fileSize = file.size / 1024 / 1024; // Konversi ke MB
                if (fileSize > maxFileSize) {
                    fileError.textContent = `Ukuran file tidak boleh lebih dari ${maxFileSize}MB!`;
                    fileError.classList.remove("hidden");
                    toggleSubmitButton(false);
                    return false;
                } else {
                    fileError.classList.add("hidden");
                    return true;
                }
            }

            // Event listener untuk input nama file
            fileNameInput.addEventListener("input", () => {
                validateFileName();
            });

            // Event listener untuk file input
            fileInput.addEventListener("change", function() {
                const file = this.files[0];
                if (file) {
                    if (validateFileSize(file)) {
                        fileNameDisplay.textContent = `File terpilih: ${file.name}`;
                        fileInfoContainer.classList.remove("hidden");
                        toggleSubmitButton(true);
                    } else {
                        fileInfoContainer.classList.add("hidden");
                    }
                } else {
                    fileInfoContainer.classList.add("hidden");
                }
            });

            // Tombol reset file
            resetButton.addEventListener("click", function() {
                fileInput.value = "";
                fileNameDisplay.textContent = "File terpilih: Tidak ada file";
                fileInfoContainer.classList.add("hidden");
                toggleSubmitButton(false);
            });

            // Validasi akhir sebelum submit
            form.addEventListener("submit", function(event) {
                if (!validateFileName() || fileInput.files.length === 0 || !validateFileSize(fileInput
                        .files[0])) {
                    event.preventDefault();
                    alert("Pastikan semua input valid sebelum mengirim formulir.");
                }
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>

</body>

</html>
