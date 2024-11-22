<aside class="bg-white border border-r w-56 h-screen flex flex-col shadow-md">
  <!-- Header -->
  <div class="flex items-center justify-center my-3">
      <a href="{{ route('dashboard.index') }}" class="flex items-center">
          <img src="../assets/img/lazismu-logo.png" alt="" class="w-8">
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
              <img src="../assets/img/dashboard.svg" alt="" class="w-7 mr-2">
              <li class="font-semibold">Dashboard</li>
          </a>
          
          <!-- Pengguna -->
          <a href="{{ route('pengguna.index') }}"
              class="w-full flex items-center px-8 py-2 hover:bg-orange-200 rounded-md transition duration-300 transform hover:scale-105 mb-2  {{ Request::routeIs('pengguna.index') ? 'ml-5 bg-orange-300 underline underline-offset-2' : '' }}">
              <img src="../assets/img/user.svg" alt="" class="w-7 mr-2">
              <li class="font-semibold">Pengguna</li>
          </a>

          <!-- Campaign Dropdown -->
          <div class="w-full">
              <button id="dropdownToggle"
                  class="w-full flex justify-between items-center px-8 py-2 rounded-md transition duration-300 transform hover:scale-105">
                  <span class="font-semibold">Campaign</span>
                  <svg id="arrowIcon" xmlns="http://www.w3.org/2000/svg" class="w-4 transform transition-transform"
                      fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 15.75 7.5-7.5 7.5 7.5" />
                  </svg>
              </button>
              <div id="dropdownMenu" class="w-full transition-all duration-300 overflow-hidden mb-4">
                  <a href="{{ route('campaign.index') }}"
                      class="ml-10 flex px-8 py-2 text-sm text-gray-700 hover:bg-orange-200 rounded-tl-md rounded-bl-md transition duration-200 mb-2 {{ Request::routeIs('campaign.index') ? 'bg-orange-200 font-semibold' : '' }}">
                      <img src="../assets/img/campaign.svg" alt="" class="w-5 mr-2">
                      <span>Campaign</span>
                  </a>
                  <a href="{{ route('campaignCategory.index') }}"
                      class="ml-10 flex px-8 py-2 text-sm text-gray-700 hover:bg-orange-200 rounded-tl-md rounded-bl-md transition duration-200 mb-2 {{ Request::routeIs('campaignCategory.index') ? 'bg-orange-200 font-semibold' : '' }}">
                      <img src="../assets/img/list.svg" alt="" class="w-5 mr-2">
                      <span>Category</span>
                  </a>
                  <a href="#"
                      class="ml-10 flex px-8 py-2 text-sm text-gray-700 hover:bg-orange-200 rounded-tl-md rounded-bl-md transition duration-200 mb-2 {{ Request::routeIs('campaign.active') ? 'bg-orange-200 font-semibold' : '' }}">
                      <img src="../assets/img/pause.svg" alt="" class="w-5 mr-2">
                      <span>Campaign non-aktif</span>
                  </a>
              </div>
          </div>

          <!-- Transaksi -->
          <a href="{{ route('transaksi.index') }}"
              class="w-full flex items-center px-8 py-2 hover:bg-orange-200 rounded-md transition duration-300 transform hover:scale-105 mb-2 {{ Request::routeIs('transaksi.index') ? 'ml-5 bg-orange-300 underline underline-offset-2' : '' }}">
              <img src="../assets/img/cash.svg" alt="" class="w-7 mr-2">
              <li class="font-semibold">Transaksi</li>
          </a>

          <!-- Kabar Terbaru -->
          <a href="#"
              class="w-full flex items-center px-8 py-2 hover:bg-orange-200 rounded-md transition duration-300 transform hover:scale-105 mb-2">
              <img src="../assets/img/kabarterbaru.svg" alt="" class="w-7 mr-2">
              <li class="font-semibold">Kabar terbaru</li>
          </a>
      </ul>
  </div>

  <!-- Footer -->
  <div class="w-full mt-auto">
      <a href="#"
          class="w-full flex items-center px-8 py-2 hover:bg-orange-200 rounded-md transition duration-300 transform hover:scale-105 mb-4">
          <img src="assets/img/logout.svg" alt="" class="w-7 mr-2">
          <span class="font-semibold">Logout</span>
      </a>
  </div>
</aside>

<script>
  const dropdownToggle = document.getElementById('dropdownToggle');
  const dropdownMenu = document.getElementById('dropdownMenu');
  const arrowIcon = document.getElementById('arrowIcon');

  // Status default dropdown
  let isOpen = true;
  dropdownMenu.style.maxHeight = dropdownMenu.scrollHeight + 'px';

  // Fungsi untuk toggle dropdown
  dropdownToggle.addEventListener('click', () => {
      isOpen = !isOpen;
      
      if (isOpen) {
          dropdownMenu.style.maxHeight = dropdownMenu.scrollHeight + 'px';
          arrowIcon.classList.remove('rotate-180');
      } else {
          dropdownMenu.style.maxHeight = '0';
          arrowIcon.classList.add('rotate-180');
      }
  });
</script>