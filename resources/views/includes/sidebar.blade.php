  <aside class="bg-white border border-r w-64 h-screen flex flex-col justify-between shadow-md">
    <!-- Header -->
    <div class="flex items-center justify-center my-3">
      <a href="{{ route('dashboard.index') }}" class="flex items-center">
        <img src="assets/img/lazismu-logo.png" alt="" class="w-14 mt-2">
        <span class="ml-2 font-bold text-xl">Lazismu</span>
      </a>
    </div>
    <hr class="-mt-24">
    <!-- Navigasi Utama -->
    <ul class="w-full flex flex-col items-center -mt-20 overflow-hidden">
      <a href="{{ route('dashboard.index') }}" class="w-full flex items-center px-8 py-2 hover:bg-orange-200 rounded-md transition duration-300 transform hover:scale-105 mb-4 {{ Request::routeIs('dashboard.index') ? 'ml-5 bg-orange-300 underline underline-offset-2' : '' }}">
        <img src="assets/img/dashboard.svg" alt="" class="w-7 mr-2">
        <li class="font-semibold">Dashboard</li>
      </a>
      <a href="{{ route('pengguna.index') }}" class="w-full flex items-center px-8 py-2 hover:bg-orange-200 rounded-md transition duration-300 transform hover:scale-105 mb-4  {{ Request::routeIs('pengguna.index') ? 'ml-5 bg-orange-300 underline underline-offset-2' : '' }}">
        <img src="assets/img/user.svg" alt="" class="w-7 mr-2">
        <li class="font-semibold">Pengguna</li>
      </a>
      <a href="{{ route('campaign.index') }}" class="w-full flex items-center px-8 py-2 hover:bg-orange-200 rounded-md transition duration-300 transform hover:scale-105 mb-4  {{ Request::routeIs('campaign.index') ? 'bg-orange-200' : '' }}">
        <img src="assets/img/campaign.svg" alt="" class="w-7 mr-2">
        <li class="font-semibold">Campaign</li>
      </a>
      <a href="{{ route('transaksi.index') }}" class="w-full flex items-center px-8 py-2 hover:bg-orange-200 rounded-md transition duration-300 transform hover:scale-105 mb-4 {{ Request::routeIs('transaksi.index') ? 'bg-orange-200' : '' }}">
        <img src="assets/img/cash.svg" alt="" class="w-7 mr-2">
        <li class="font-semibold">Transaksi</li>
      </a>
      <a href="#" class="w-full flex items-center px-8 py-2 hover:bg-orange-200 rounded-md transition duration-300 transform hover:scale-105 mb-4">
        <img src="assets/img/penghimpunan.svg" alt="" class="w-7 mr-2">
        <li class="font-semibold">Penghimpunan</li>
      </a>
      <a href="#" class="w-full flex items-center px-8 py-2 hover:bg-orange-200 rounded-md transition duration-300 transform hover:scale-105 mb-4">
        <img src="assets/img/amil.svg" alt="" class="w-7 mr-2">
        <li class="font-semibold">Amil</li>
      </a>
      <a href="#" class="w-full flex items-center px-8 py-2 hover:bg-orange-200 rounded-md transition duration-300 transform hover:scale-105 mb-4">
        <img src="assets/img/distribusi.svg" alt="" class="w-7 mr-2">
        <li class="font-semibold">Distribusi</li>
      </a>
    </ul>
  
    <!-- Footer -->
    <div class="w-full">
      <a href="#" class="w-full flex items-center px-8 py-2 hover:bg-orange-200 rounded-md transition duration-300 transform hover:scale-105 mb-4">
        <img src="assets/img/logout.svg" alt="" class="w-7 mr-2">
        <span class="font-semibold">Logout</span>
      </a>
    </div>
  </aside>
  