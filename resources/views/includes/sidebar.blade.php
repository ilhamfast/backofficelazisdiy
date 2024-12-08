<aside class="bg-white border border-r w-56 h-screen flex flex-col shadow-md">
    <!-- Header -->
    <div class="flex items-center justify-center my-3">
        <a href="{{ route('dashboard.index') }}" class="flex items-center">
            <img src="{{ asset('assets/img/lazismu-logo.png') }}" alt="" class="w-8">
            <span class="ml-2 font-bold text-xl">Lazismu</span>
        </a>
    </div>
    <div class="border border-gray-200 mt-2"></div>

    <!-- Navigasi Utama -->
    <div class="flex-1 overflow-y-auto overflow-hidden mt-2">
        <ul class="w-full flex flex-col items-center">
            <!-- Dashboard -->
            <a href="{{ route('dashboard.index') }}"
                class="w-full flex items-center px-8 py-2 hover:bg-orange-200 rounded-md transition duration-300 transform hover:scale-105 mb-2 {{ Request::routeIs('dashboard.index') ? 'ml-5 bg-orange-300 underline underline-offset-2' : '' }}">
                <img src="{{ asset('assets/img/dashboard.svg') }}" alt="" class="w-7 mr-2">
                <li class="font-semibold">Dashboard</li>
            </a>

            <!-- Pengguna -->
            <a href="{{ route('pengguna.index') }}"
                class="w-full flex items-center px-8 py-2 hover:bg-orange-200 rounded-md transition duration-300 transform hover:scale-105 mb-2  {{ Request::routeIs('pengguna.index') ? 'ml-5 bg-orange-300 underline underline-offset-2' : '' }}">
                <img src="{{ asset('assets/img/user.svg') }}" alt="" class="w-7 mr-2">
                <li class="font-semibold">Pengguna</li>
            </a>

            <!-- Campaign Dropdown -->
            <div class="w-full" id="campaignDropdown">
                <button id="dropdownToggle"
                    class="w-full flex justify-between items-center px-8 py-2 rounded-md transition duration-300 transform hover:scale-105 {{ Request::routeIs('campaign.index', 'campaignCategory.index', 'campaign.active') ? 'open' : '' }}">
                    <span class="font-semibold">Campaign</span>
                    <svg id="arrowIcon" xmlns="http://www.w3.org/2000/svg"
                        class="w-4 transform transition-transform rotate-180" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 15.75 7.5-7.5 7.5 7.5" />
                    </svg>
                </button>
                <div id="dropdownMenu" class="w-full transition-all duration-300 overflow-hidden mb-4">
                    <a href="{{ route('campaign.index') }}"
                        class="ml-10 flex px-8 py-2 text-sm text-gray-700 hover:bg-orange-200 rounded-tl-md rounded-bl-md transition duration-200 mb-2 {{ Request::routeIs('campaign.index') ? 'bg-orange-200 font-semibold' : '' }}">
                        <img src="{{ asset('assets/img/campaign.svg') }}" alt="" class="w-5 mr-2">
                        <span>Campaign</span>
                    </a>
                    <a href="{{ route('campaignCategory.index') }}"
                        class="ml-10 flex px-8 py-2 text-sm text-gray-700 hover:bg-orange-200 rounded-tl-md rounded-bl-md transition duration-200 mb-2 {{ Request::routeIs('campaignCategory.index') ? 'bg-orange-200 font-semibold' : '' }}">
                        <img src="{{ asset('assets/img/list.svg') }}" alt="" class="w-5 mr-2">
                        <span>Category</span>
                    </a>
                    <a href="#"
                        class="ml-10 flex px-8 py-2 text-sm text-gray-700 hover:bg-orange-200 rounded-tl-md rounded-bl-md transition duration-200 {{ Request::routeIs('campaign.active') ? 'bg-orange-200 font-semibold' : '' }}">
                        <img src="{{ asset('assets/img/pause.svg') }}" alt="" class="w-5 mr-2">
                        <span>Campaign non-aktif</span>
                    </a>
                </div>
            </div>

            {{-- Ziswaf dropdown --}}
            <div class="w-full mt-2" id="ziswafDropdown">
                <button id="dropdownToggleZiswaf"
                    class="w-full flex justify-between items-center px-8 py-2 rounded-md transition duration-300 transform hover:scale-105 {{ Request::routeIs('zakat.index', 'infak.index') ? 'open' : '' }}">
                    <span class="font-semibold">Ziswaf</span>
                    <svg id="arrowIconZiswaf" xmlns="http://www.w3.org/2000/svg"
                        class="w-4 transform transition-transform rotate-180" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 15.75 7.5-7.5 7.5 7.5" />
                    </svg>
                </button>
                <div id="dropdownMenuZiswaf" class="w-full transition-all duration-300 overflow-hidden mb-4">
                    <a href="{{ route('zakat.index') }}"
                        class="ml-10 flex px-8 py-2 text-sm text-gray-700 hover:bg-orange-200 rounded-tl-md rounded-bl-md transition duration-200 mb-2 {{ Request::routeIs('zakat.index') ? 'bg-orange-200 font-semibold' : '' }}">
                        <img src="{{ asset('assets/img/zakat.svg') }}" alt="" class="w-5 mr-2">
                        <span>Zakat</span>
                    </a>
                    <a href="{{ route('infak.index') }}"
                        class="ml-10 flex px-8 py-2 text-sm text-gray-700 hover:bg-orange-200 rounded-tl-md rounded-bl-md transition duration-200 mb-2 {{ Request::routeIs('infak.index') ? 'bg-orange-200 font-semibold' : '' }}">
                        <img src="{{ asset('assets/img/infaq.svg') }}" alt="" class="w-5 mr-2">
                        <span>Infak</span>
                    </a>
                </div>
            </div>

            <!-- Transaksi -->
            <a href="{{ route('transaksi.index') }}"
                class="w-full flex items-center px-8 py-2 hover:bg-orange-200 rounded-md transition duration-300 transform hover:scale-105 mb-2 {{ Request::routeIs('transaksi.index') ? 'ml-5 bg-orange-300 underline underline-offset-2' : '' }}">
                <img src="{{ asset('assets/img/cash.svg') }}" alt="" class="w-7 mr-2">
                <li class="font-semibold">Transaksi</li>
            </a>

            <!-- Kabar Terbaru -->
            <a href="{{ route('news.index') }}"
                class="w-full flex items-center px-8 py-2 hover:bg-orange-200 rounded-md transition duration-300 transform hover:scale-105 mb-2 {{ Request::routeIs('news.index') ? 'ml-5 bg-orange-300 underline underline-offset-2' : '' }}">
                <img src="{{ asset('assets/img/kabarterbaru.svg') }}" alt="" class="w-7 mr-2">
                <li class="font-semibold">Kabar terbaru</li>
            </a>
        </ul>
    </div>

    <!-- Footer -->
    <div class="w-full mt-auto">
        <a href="#"
            class="w-full flex items-center px-8 py-2 hover:bg-orange-200 rounded-md transition duration-300 transform hover:scale-105 mb-4">
            <img src="{{ asset('assets/img/logout.svg') }}" alt="" class="w-7 mr-2">
            <span class="font-semibold">Logout</span>
        </a>
    </div>
</aside>

<script>
    const dropdownToggle = document.getElementById('dropdownToggle');
    const dropdownMenu = document.getElementById('dropdownMenu');
    const arrowIcon = document.getElementById('arrowIcon');

    // Status default dropdown
    let isOpen = false;
    dropdownMenu.style.maxHeight = '0'; // Dropdown tertutup di awal

    // Fungsi untuk toggle dropdown
    dropdownToggle.addEventListener('click', () => {
        // Toggle status dropdown
        isOpen = !isOpen;

        if (isOpen) {
            // Jika terbuka
            dropdownMenu.style.maxHeight = dropdownMenu.scrollHeight + 'px'; // Buka dropdown
            arrowIcon.classList.remove('rotate-180'); // Putar ikon
        } else {
            // Jika tertutup
            dropdownMenu.style.maxHeight = '0'; // Tutup dropdown
            arrowIcon.classList.add('rotate-180'); // Kembalikan ikon
        }
    });

    if (dropdownToggle.classList.contains('open')) {
        dropdownMenu.style.maxHeight = dropdownMenu.scrollHeight + 'px';
        arrowIcon.classList.remove('rotate-180');
        isOpen = true; // Set status dropdown terbuka
    }

    const dropdownToggleZiswaf = document.getElementById('dropdownToggleZiswaf');
    const dropdownMenuZiswaf = document.getElementById('dropdownMenuZiswaf');
    const arrowIconZiswaf = document.getElementById('arrowIconZiswaf');

    // Status default dropdown
    let ZiswafisOpen = false;
    dropdownMenuZiswaf.style.maxHeight = '0'; // Default tertutup

    // Fungsi untuk toggle dropdown
    dropdownToggleZiswaf.addEventListener('click', () => {
        ZiswafisOpen = !ZiswafisOpen;

        if (ZiswafisOpen) {
            // Buka dropdown
            dropdownMenuZiswaf.style.maxHeight = dropdownMenuZiswaf.scrollHeight + 'px'; // Sesuai isi konten
            arrowIconZiswaf.classList.add('rotate-180'); // Tambahkan rotasi
        } else {
            // Tutup dropdown
            dropdownMenuZiswaf.style.maxHeight = '0'; // Tutup dropdown
            arrowIconZiswaf.classList.remove('rotate-180'); // Hilangkan rotasi
        }
    });
    if (dropdownToggleZiswaf.classList.contains('open')) {
        dropdownMenuZiswaf.style.maxHeight = dropdownMenu.scrollHeight + 'px';
        arrowIconZiswaf.classList.remove('rotate-180');
        ZiswafisOpen = true; // Set status dropdown terbuka
    }
</script>
