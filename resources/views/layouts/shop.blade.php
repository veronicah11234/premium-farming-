<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Online Shop' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">

<div class="flex">

    <!-- MODERN ONLINE SHOP SIDEBAR -->
    <aside class="w-64 h-screen bg-gradient-to-b from-green-50 to-white shadow-md fixed left-0 top-0 overflow-y-auto">

        <!-- LOGO -->
        <div class="p-6 text-center border-b border-gray-200">
            <img src="{{ asset('images/logo.jpeg') }}" 
                 alt="Logo"
                 class="h-32 w-auto object-contain mx-auto shadow-md p-1">
            <h2 class="font-bold text-2xl mt-2 text-green-700">Premium Farming Feeds</h2>
            <p class="text-sm text-gray-500 mt-1 italic">
                The Best Feed in Kenya • Quality • Nutrition • Growth
            </p>
        </div>

        <!-- TOGGLE BUTTONS -->
        <div class="p-4 space-y-2">
            <a href="{{ route('dashboard') }}"
               class="block text-center bg-blue-600 text-white py-2 rounded hover:bg-blue-700 font-semibold">
                ← Back to Dashbord
            </a>
            <a href="{{ route('shop.index') }}"
               class="block text-center bg-green-600 text-white py-2 rounded hover:bg-green-700 font-semibold">
                Shop Home
            </a>
        </div>

        <!-- NAVIGATION -->
        <nav class="mt-4 px-4">
            <ul class="space-y-2">
                <li class="font-bold text-gray-600">Shop Management</li>
                <li><a href="{{ route('shop.products') }}" class="block p-2 hover:bg-green-100 rounded font-medium">Manage Products</a></li>
                <li><a href="{{ route('shop.orders') }}" class="block p-2 hover:bg-green-100 rounded font-medium">Orders</a></li>
                <li><a href="{{ route('shop.customers') }}" class="block p-2 hover:bg-green-100 rounded font-medium">Customers</a></li>
                <li><a href="{{ route('shop.reports') }}" class="block p-2 hover:bg-green-100 rounded font-medium">Reports</a></li>
            </ul>
        </nav>

    </aside>

    <!-- MAIN CONTENT AREA -->
    <main class="ml-64 w-full p-6">
        @yield('content')
    </main>

</div>

</body>
</html>
