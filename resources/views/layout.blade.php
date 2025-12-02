<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>{{ $title ?? 'Dashboard' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
      /* small extra styles for transitions */
      .sidebar-collapsed { width: 72px; }
      .sidebar-expanded { width: 16rem; } /* 256px */
      .main-shifted { margin-left: 16rem; } /* matches sidebar-expanded */
      .main-collapsed { margin-left: 4.5rem; } /* matches sidebar-collapsed */
      .avatar-small { width: 32px; height: 32px; }
      .avatar-medium { width: 40px; height: 40px; }
    </style>
</head>
<body class="bg-gray-100 text-gray-800 transition-colors" id="page-body">

<!-- TOP NAVBAR -->
<header class="fixed top-0 left-0 right-0 z-30 bg-white/95 backdrop-blur-sm border-b">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between h-16">

      <!-- Left: sidebar toggle + title -->
      <div class="flex items-center gap-3">
        <button id="sidebarToggle" class="p-2 rounded-md hover:bg-gray-100" aria-label="Toggle sidebar">
          <!-- hamburger -->
          <svg id="hamburgerIcon" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
          </svg>
        </button>

        <a href="{{ route('dashboard') }}" class="text-lg font-bold text-green-700 hidden sm:inline">Premium Farming Feeds</a>
      </div>

      <!-- Middle: search -->
      {{-- <div class="flex-1 px-4">
        <div class="max-w-xl mx-auto">
          <form action="{{ url()->current() }}" method="GET" class="relative">
            <input name="q" type="search" placeholder="Search products, orders, customers..." 
                   class="w-full rounded-full border px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-300" />
            <button type="submit" class="absolute right-1 top-1/2 -translate-y-1/2 px-3 py-1 rounded-full bg-green-600 text-white hover:bg-green-700">
              Search
            </button>
          </form>
        </div>
      </div> --}}

      <!-- Right: controls -->
      <div class="flex items-center gap-3">

        <!-- Dark mode toggle -->
        <button id="themeToggle" class="p-2 rounded-full hover:bg-gray-100" title="Toggle dark mode">
          <svg id="sunIcon" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v2m0 14v2m9-9h-2M5 12H3m15.364-6.364l-1.414 1.414M7.05 16.95l-1.414 1.414M18.364 18.364l-1.414-1.414M7.05 7.05L5.636 5.636" />
          </svg>
          <svg id="moonIcon" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/>
          </svg>
        </button>

        <!-- Notifications -->
        <div class="relative">
          <button id="notifBtn" class="p-2 rounded-full hover:bg-gray-100" aria-expanded="false" aria-haspopup="true" title="Notifications">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>
            <span id="notifBadge" class="inline-block ml-[-8px] -mt-2 bg-red-600 text-white text-xs rounded-full px-1.5">3</span>
          </button>

          <!-- notifications dropdown -->
          <div id="notifMenu" class="hidden origin-top-right absolute right-0 mt-2 w-72 bg-white border rounded shadow-lg">
            <div class="px-4 py-2 text-sm font-semibold">Notifications</div>
            <div class="divide-y max-h-56 overflow-auto">
              <a class="block px-4 py-2 hover:bg-gray-50" href="#">Order #1024 completed</a>
              <a class="block px-4 py-2 hover:bg-gray-50" href="#">Stock low: Layers Mash</a>
              <a class="block px-4 py-2 hover:bg-gray-50" href="#">New customer registered</a>
            </div>
            <div class="p-2 text-center">
              <a href="{{ route('shop.orders') }}" class="text-sm text-green-600 hover:underline">View all</a>
            </div>
          </div>
        </div>

        <!-- Profile dropdown -->
        <div class="relative">
          <button id="profileBtn" class="flex items-center gap-2 px-2 py-1 rounded-full hover:bg-gray-100" aria-expanded="false">
            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0D8ABC&color=fff" 
                 alt="avatar" class="avatar-small rounded-full border" />
            <span class="hidden sm:inline font-medium">{{ Auth::user()->name }}</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
          </button>

          <div id="profileMenu" class="hidden origin-top-right absolute right-0 mt-2 w-44 bg-white border rounded shadow-lg">
            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 hover:bg-gray-50">Profile Settings</a>
            <a href="{{ route('dashboard') }}" class="block px-4 py-2 hover:bg-gray-50">Dashboard</a>
            <hr />
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-50 text-red-600">Logout</button>
            </form>
          </div>
        </div>

      </div>
    </div>
  </div>
</header>

<!-- LAYOUT: sidebar + main -->
<div class="flex pt-16">

  <!-- SIDEBAR -->
  <aside id="sidebar" class="sidebar-expanded fixed top-16 left-0 bottom-0 bg-white border-r overflow-y-auto transition-width" aria-label="Sidebar">
    <!-- Logo area -->
    <div class="p-6 border-b text-center">
      {{-- <img src="{{ asset('images/logo.jpeg') }}" alt="Logo" class="mx-auto object-contain h-20" /> --}}
      <h2 class="font-extrabold text-lg mt-3 text-green-700">Premium Farming Feeds</h2>
      <p class="text-xs text-gray-500 italic">Quality • Nutrition • Growth</p>

      <!-- Back to dashboard / Switch -->
      <div class="mt-4 space-y-2">
        <a href="{{ route('dashboard') }}" class="block text-center bg-blue-600 text-white py-2 rounded hover:bg-blue-700">← Dashboard</a>

        @if (isset($mode) && $mode === 'pos')
          <a href="{{ route('shop.index') }}" class="block text-center bg-green-600 text-white py-2 rounded hover:bg-green-700">Switch to Shop</a>
        @elseif (isset($mode) && $mode === 'shop')
          <a href="{{ route('pos.index') }}" class="block text-center bg-green-600 text-white py-2 rounded hover:bg-green-700">Switch to POS</a>
        @endif
      </div>
    </div>

    <!-- NAV -->
    <nav class="px-3 py-4">
      <ul class="space-y-1">
        @if (isset($mode) && $mode === 'pos')
          <li class="font-semibold text-gray-600 px-2">POS</li>
          <li><a href="{{ route('pos.sell') }}" class="block p-2 rounded hover:bg-gray-50">Pos</a></li>
          <li><a href="{{ route('pos.categories') }}" class="block p-2 rounded hover:bg-gray-50">Categories</a></li>
          <li><a href="{{ route('pos.items') }}" class="block p-2 rounded hover:bg-gray-50">Items</a></li>
          <li><a href="{{ route('pos.stores') }}" class="block p-2 rounded hover:bg-gray-50">Stores</a></li>
          <li><a href="{{ route('pos.goods-received') }}" class="block p-2 rounded hover:bg-gray-50">Goods Received</a></li>
          <li><a href="{{ route('pos.update-prices') }}" class="block p-2 rounded hover:bg-gray-50">Update Prices</a></li>
        @elseif (isset($mode) && $mode === 'shop')
          <li class="font-semibold text-gray-600 px-2">Online Shop</li>
          <li><a href="{{ route('shop.index') }}" class="block p-2 rounded hover:bg-gray-50">Shop Home</a></li>
          <li><a href="{{ route('shop.products') }}" class="block p-2 rounded hover:bg-gray-50">Manage Products</a></li>
          <li><a href="{{ route('shop.orders') }}" class="block p-2 rounded hover:bg-gray-50">Orders</a></li>
          <li><a href="{{ route('shop.customers') }}" class="block p-2 rounded hover:bg-gray-50">Customers</a></li>
          <li><a href="{{ route('shop.reports') }}" class="block p-2 rounded hover:bg-gray-50">Reports</a></li>
        @else
          <li><a href="{{ route('dashboard') }}" class="block p-2 rounded hover:bg-gray-50">Dashboard</a></li>
          <li><a href="{{ route('shop.index') }}" class="block p-2 rounded hover:bg-gray-50">Shop</a></li>
          <li><a href="{{ route('pos.index') }}" class="block p-2 rounded hover:bg-gray-50">POS</a></li>
        @endif
      </ul>
    </nav>

  </aside>

  <!-- MAIN -->
  <main id="mainContent" class="ml-64 flex-1 p-6 transition-all">
    @yield('content')
  </main>
</div>

<!-- Scripts (vanilla JS) -->
<script>
  // Dropdown helpers
  function toggleEl(id) {
    document.getElementById(id).classList.toggle('hidden');
  }

  // Profile dropdown
  const profileBtn = document.getElementById('profileBtn');
  const profileMenu = document.getElementById('profileMenu');

  // Notifications
  const notifBtn = document.getElementById('notifBtn');
  const notifMenu = document.getElementById('notifMenu');

  function closeAllDropdowns(event) {
    const target = event.target;
    if (!profileBtn.contains(target)) profileMenu.classList.add('hidden');
    if (!notifBtn.contains(target)) notifMenu.classList.add('hidden');
  }

  // toggle handlers
  profileBtn?.addEventListener('click', (e) => {
    e.stopPropagation();
    profileMenu.classList.toggle('hidden');
    notifMenu.classList.add('hidden');
  });

  notifBtn?.addEventListener('click', (e) => {
    e.stopPropagation();
    notifMenu.classList.toggle('hidden');
    profileMenu.classList.add('hidden');
  });

  // close on outside click
  document.addEventListener('click', closeAllDropdowns);

  // keyboard escape to close
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
      profileMenu.classList.add('hidden');
      notifMenu.classList.add('hidden');
    }
  });

  // Theme toggle (dark/light) with localStorage
  const body = document.getElementById('page-body');
  const themeToggle = document.getElementById('themeToggle');
  const sunIcon = document.getElementById('sunIcon');
  const moonIcon = document.getElementById('moonIcon');

  function applyTheme(theme) {
    if (theme === 'dark') {
      body.classList.add('dark', 'bg-gray-900', 'text-gray-100');
      sunIcon.classList.remove('hidden');
      moonIcon.classList.add('hidden');
    } else {
      body.classList.remove('dark', 'bg-gray-900', 'text-gray-100');
      sunIcon.classList.add('hidden');
      moonIcon.classList.remove('hidden');
    }
  }

  // initialize theme
  const savedTheme = localStorage.getItem('pff_theme') || 'light';
  applyTheme(savedTheme);

  themeToggle?.addEventListener('click', () => {
    const current = localStorage.getItem('pff_theme') || 'light';
    const next = current === 'dark' ? 'light' : 'dark';
    localStorage.setItem('pff_theme', next);
    applyTheme(next);
  });

  // Sidebar collapse
  const sidebar = document.getElementById('sidebar');
  const mainContent = document.getElementById('mainContent');
  const sidebarToggle = document.getElementById('sidebarToggle');

  function collapseSidebar() {
    if (sidebar.classList.contains('sidebar-expanded')) {
      // collapse
      sidebar.classList.remove('sidebar-expanded');
      sidebar.classList.add('sidebar-collapsed');
      mainContent.classList.remove('ml-64','main-shifted');
      mainContent.classList.add('main-collapsed');
      // reduce logo and text
      sidebar.querySelectorAll('h2, p, .mt-4, .font-semibold').forEach(el => el.classList.add('hidden'));
    } else {
      // expand
      sidebar.classList.remove('sidebar-collapsed');
      sidebar.classList.add('sidebar-expanded');
      mainContent.classList.remove('main-collapsed');
      mainContent.classList.add('main-shifted','ml-64');
      sidebar.querySelectorAll('h2, p, .mt-4, .font-semibold').forEach(el => el.classList.remove('hidden'));
    }
  }

  // Init classes
  sidebar.classList.add('sidebar-expanded');
  mainContent.classList.add('main-shifted');

  sidebarToggle?.addEventListener('click', (e) => {
    e.preventDefault();
    collapseSidebar();
  });

  // prevent dropdowns from closing when clicking inside
  profileMenu?.addEventListener('click', e => e.stopPropagation());
  notifMenu?.addEventListener('click', e => e.stopPropagation());

</script>

</body>
</html>
