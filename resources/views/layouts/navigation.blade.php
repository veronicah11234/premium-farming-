<!-- Page Container -->
<div class="max-w-7xl mx-auto p-4">

    <!-- Top Section: Profile + Search -->
    <div class="w-full flex flex-col sm:flex-row items-center sm:items-start justify-between gap-6">

        <!-- Profile Picture -->
        <div class="flex flex-col items-center">
            <img src="{{ Auth::user()->profile_photo_url ?? 'https://via.placeholder.com/120' }}"
                class="w-28 h-28 rounded-full object-cover shadow-md border">
            <h2 class="mt-2 text-lg font-semibold text-gray-700">{{ Auth::user()->name }}</h2>
        </div>

        <!-- Search Box (center) -->
        <div class="flex-1 flex justify-center">
            <input type="text"
                placeholder="Search..."
                class="w-full sm:w-2/3 lg:w-1/2 px-4 py-2 border rounded-full shadow-sm focus:ring-2 focus:ring-blue-400 focus:outline-none">
        </div>

    </div>

    <!-- Video Section -->
    <div class="mt-10">
        <h3 class="text-xl font-semibold text-gray-800 mb-4">Latest Video</h3>

        <div class="w-full aspect-video bg-black rounded-lg overflow-hidden shadow-lg">
            <video controls class="w-full h-full">
                <source src="/videos/sample.mp4" type="video/mp4">
            </video>
        </div>
    </div>

</div>
