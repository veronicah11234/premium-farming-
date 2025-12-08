<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Online Shop' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background: #f1f5f9;
        }

        .sidebar {
            width: 250px;
            background: #1e293b;
            color: #fff;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            overflow-y: auto;
            padding-top: 20px;
        }

        .content {
            margin-left: 250px;
            padding: 25px;
            min-height: 100vh;
            width: calc(100% - 250px);
        }
    </style>
</head>

<body class="bg-gray-100">

<div class="flex">

    <!-- SIDEBAR -->
    <aside id="sidebar"
        class="w-64 bg-white shadow-xl fixed top-0 left-0 flex flex-col z-50 transition-all duration-300"
        style="height: 100vh;">

        <!-- LOGO -->
        <div class="logo-box text-center p-4 border-b">
            {{-- <img src="{{ asset('images/logo.jpeg') }}" alt="Logo" class="w-28 mx-auto rounded"> --}}
            <h5 class="text-green-700 mt-2 font-bold">Premium Farming Feeds</h5>
            <small class="text-gray-600">Quality • Nutrition • Growth</small>
        </div>

        <!-- BACK TO DASHBOARD -->
        <div class="px-4 py-4 border-b">
            <a href="{{ route('dashboard') }}"
                class="block text-center bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 font-semibold">
                ← Dashboard
            </a>
        </div>

        <!-- MENU -->
        <nav class="px-4 py-4 flex-1 overflow-y-auto">

            <p class="text-xs uppercase font-bold text-gray-500 mb-2">Shop Management</p>

            <a href="{{ route('shop.products') }}"
               class="block p-2 rounded hover:bg-green-100 text-gray-700 font-medium">
                📦 Manage Products
            </a>

            <!-- CATEGORY DROPDOWN -->
            <div class="mt-4">

                <button onclick="toggleCategories()"
                    class="w-full bg-green-700 text-white py-3 px-4 rounded-lg font-bold mb-3">
                    Categories
                </button>

                <ul id="categoryList" class="hidden pl-3 space-y-3">

                    {{-- <li>
                        <a href="{{ route('category.index', 'poultry') }}"
                           class="text-gray-800 font-semibold hover:text-green-700">
                            Poultry Feeds
                        </a>
                    </li> --}}
                    

                    {{-- <li>
                        <a href="{{ route('shop.category', 'dairy') }}"
                           class="text-gray-800 font-semibold hover:text-green-700">
                            Dairy Feeds
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('shop.category', 'swine') }}"
                           class="text-gray-800 font-semibold hover:text-green-700">
                            Swine Feeds
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('shop.category', 'by-products') }}"
                           class="text-gray-800 font-semibold hover:text-green-700">
                            By-products
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('shop.category', 'pets') }}"
                           class="text-gray-800 font-semibold hover:text-green-700">
                            Pet Feeds
                        </a>
                    </li> --}}

                </ul>

            </div>

            <!-- CART -->
            <a href="{{ route('cart.index') }}"
               class="mt-2 block text-center bg-black text-white py-2 rounded-lg hover:bg-gray-900 font-semibold flex items-center justify-center space-x-2">
                <span>🛒 Cart</span>

                @if(session('cart') && count(session('cart')) > 0)
                    <span class="bg-green-500 text-black text-xs font-bold px-2 py-1 rounded-full">
                        {{ count(session('cart')) }}
                    </span>
                @endif
            </a>

            <a href="{{ route('shop.orders') }}"
               class="block p-2 rounded hover:bg-green-100 text-gray-700 font-medium">
                🧾 Orders
            </a>

            <a href="{{ route('shop.customers') }}"
               class="block p-2 rounded hover:bg-green-100 text-gray-700 font-medium">
                👥 Customers
            </a>

            <a href="{{ route('shop.reports') }}"
               class="block p-2 rounded hover:bg-green-100 text-gray-700 font-medium">
                📊 Reports
            </a>
        </nav>
    </aside>

    <!-- MAIN CONTENT -->
    <div class="content">
        @yield('content')
    </div>

</div>

<!-- JS FOR DROPDOWN -->
<script>
    function toggleCategories() {
        const list = document.getElementById('categoryList');
        list.classList.toggle('hidden');
    }
</script>

</body>
</html>
