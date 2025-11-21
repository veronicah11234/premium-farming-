<!-- CLEAN + UNIFIED TOP NAVBAR -->
<nav class="w-full bg-white shadow-md px-6 py-4 flex justify-between items-center z-40">

    <!-- Left: Brand -->
    <div class="flex items-center space-x-3">
        <h1 class="font-extrabold text-2xl text-green-700">
            Premium Farming Feeds
        </h1>
    </div>

    <!-- Right Side Items -->
    <div class="flex items-center space-x-6">

        <!-- 🔍 SEARCH BAR + BUTTON (Unified Design) -->
        <div class="flex items-center space-x-2 border rounded-full px-3 py-1 bg-white">
            <input 
                type="text"
                placeholder="Search…"
                class="px-3 py-2 text-gray-700 focus:outline-none bg-white w-48 sm:w-64"
            >
            <button class="px-4 py-2 bg-green-600 text-white rounded-full shadow hover:bg-green-700">
                Search
            </button>
        </div>

        <!-- 👤 PROFILE DROPDOWN -->
        <div class="relative" x-data="{ open: false }">

            <!-- Dropdown Trigger -->
            <button @click="open = !open" class="flex items-center space-x-3 focus:outline-none">

                <!-- User Photo (your photo as default) -->
                <img src="{{ Auth::user()->profile_photo 
                            ? asset('storage/profile/' . Auth::user()->profile_photo)
                            : asset('images/me.png') }}"
                     class="h-10 w-10 rounded-full border border-gray-300"
                     alt="User">

                <!-- User Name -->
                <span class="font-semibold text-gray-800">
                    {{ Auth::user()->name ?? 'User' }}
                </span>

                <!-- Arrow -->
                <svg class="h-5 w-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" 
                    stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>

            </button>

            <!-- Dropdown Menu -->
            <div x-show="open" @click.away="open = false"
                 class="absolute right-0 mt-2 w-48 bg-white shadow-lg rounded-md py-2 z-50">

                <a href="/profile" class="block px-4 py-2 hover:bg-gray-100">
                    Profile Settings
                </a>

                <form method="POST" action="/logout">
                    @csrf
                    <button class="w-full text-left px-4 py-2 hover:bg-gray-100">
                        Logout
                    </button>
                </form>

            </div>
        </div>

    </div>
</nav>
