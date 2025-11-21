<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dashboard' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">

<div class="flex">

    <!-- SIDEBAR -->
    <aside class="w-64 h-screen bg-white shadow-md fixed left-0 top-0 overflow-y-auto">

        <!-- LOGO AREA -->
        <div class="p-6 border-b text-center bg-white">
            <div class="flex flex-col items-center">
                <div class="shadow-md border border-gray-300 bg-white p-1">
                    <img src="{{ asset('images/logo.jpeg') }}" 
                         alt="Logo"
                         class="h-24 w-auto object-contain">
                </div>
                <h2 class="font-extrabold text-xl mt-3 text-green-700 tracking-wide">
                    Premium Farming Feeds
                </h2>
                <p class="text-sm text-gray-500 mt-1 italic">
                    Quality • Nutrition • Growth
                </p>
            </div>
        </div>

        <!-- NAVIGATION -->
        <nav class="mt-4 px-4">
            {{-- Toggle Button --}}
            @if ($mode === 'pos')
                <a href="{{ route('shop.index') }}" 
                   class="block p-2 mb-4 bg-green-600 text-white text-center rounded hover:bg-green-700 font-bold">
                    Switch to Online Shop
                </a>
            @elseif ($mode === 'shop')
                <a href="{{ route('dashboard') }}" 
                   class="block p-2 mb-4 bg-blue-600 text-white text-center rounded hover:bg-blue-700 font-bold">
                    Switch to POS Dashboard
                </a>
            @endif

            <ul class="space-y-2">
                @if ($mode === 'pos')
                    <li class="font-bold text-gray-600">POS</li>
                    <li><a href="{{ route('pos.sell') }}" class="block p-2 hover:bg-gray-200 rounded">Pos</a></li>
                    <li><a href="{{ route('pos.categories') }}" class="block p-2 hover:bg-gray-200 rounded">Categories</a></li>
                    <li><a href="{{ route('pos.items') }}" class="block p-2 hover:bg-gray-200 rounded">Items</a></li>
                    <li><a href="{{ route('pos.stores') }}" class="block p-2 hover:bg-gray-200 rounded">Stores</a></li>
                    <li><a href="{{ route('pos.goods-received') }}" class="block p-2 hover:bg-gray-200 rounded">Goods Received</a></li>
                    <li><a href="{{ route('pos.update-prices') }}" class="block p-2 hover:bg-gray-200 rounded">Update Prices</a></li>
                @elseif ($mode === 'shop')
                    <li class="font-bold text-gray-600">Online Shop</li>
                    <li><a href="{{ route('shop.index') }}" class="block p-2 hover:bg-gray-200 rounded">Shop Home</a></li>
                    <li><a href="{{ route('shop.products') }}" class="block p-2 hover:bg-gray-200 rounded">Manage Products</a></li>
                @endif
            </ul>
        </nav>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="ml-64 w-full p-6">
        @yield('content')
    </main>
</div>

</body>
</html>
