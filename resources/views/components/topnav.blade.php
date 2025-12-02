<!-- CLEAN + UNIFIED TOP NAVBAR -->
<nav class="w-full bg-white shadow-lg px-6 py-4 flex justify-between items-center sticky top-0 z-40">

    <!-- Left: Brand -->
    <div class="flex items-center space-x-3">
        <h1 class="font-extrabold text-2xl text-green-700 tracking-wide drop-shadow-sm">
            Premium Farming Feeds
        </h1>
    </div>

    <!-- Right Side Items -->
    <div class="flex items-center space-x-6">

        <!-- 🔍 SEARCH BAR + BUTTON -->
        <div class="flex items-center space-x-2 border border-gray-300 rounded-full px-3 py-1 bg-gray-50 shadow-sm hover:shadow-md transition">
            <input 
                type="text"
                placeholder="Search…"
                class="px-3 py-2 text-gray-700 focus:outline-none bg-transparent w-48 sm:w-64 placeholder-gray-500"
            >
            <button class="px-4 py-2 bg-green-600 text-white rounded-full shadow hover:bg-green-700 transition">
                Search
            </button>
        </div>

        <!-- 👤 PROFILE DROPDOWN -->
        <div class="relative" x-data="{ open: false }">

            <!-- Dropdown Trigger -->
            <button @click="open = !open" class="flex items-center space-x-3 focus:outline-none hover:bg-gray-100 px-2 py-1 rounded-lg transition">

                <!-- User Photo -->
                <img src="{{ Auth::user()->profile_photo 
                            ? asset('storage/profile/' . Auth::user()->profile_photo)
                            : asset('images/me.png') }}"
                     class="h-10 w-10 rounded-full border border-gray-300 shadow-sm object-cover"
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
                 class="absolute right-0 mt-2 w-48 bg-white shadow-xl rounded-md py-2 z-50 border border-gray-200">

                <a href="/profile" 
                   class="block px-4 py-2 hover:bg-green-50 text-gray-700 transition">
                    Profile Settings
                </a>

                <form method="POST" action="/logout">
                    @csrf
                    <button class="w-full text-left px-4 py-2 hover:bg-green-50 text-red-600 transition">
                        Logout
                    </button>
                </form>

            </div>
        </div>

    </div>
</nav>
