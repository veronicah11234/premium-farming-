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
    
        /* Sidebar */
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
    
        /* Logo area */
        .logo-box {
            text-align: center;
            margin-bottom: 20px;
        }
    
        .logo-box img {
            width: 130px;
            object-fit: contain;
            border-radius: 6px;
        }
    
        /* Sidebar menu */
        .nav-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 8px;
        }
    
        .nav-item a {
            color: #fff;
            text-decoration: none;
            flex: 1;
            padding: 8px 10px;
            border-radius: 5px;
        }
    
        .nav-item a:hover {
            background: #334155;
        }
    
        .nav-item img {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #fff;
            margin-left: 10px;
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
        <div class="logo-box">
            <img src="{{ asset('images/logo.jpeg') }}" alt="Logo">
            <h5 class="text-white mt-2 mb-0">Premium Farming Feeds</h5>
            <small class="text-secondary">Quality • Nutrition • Growth</small>
        </div>

        <!-- QUICK BUTTONS -->
        <div class="px-4 py-4 border-b">
            <a href="{{ route('dashboard') }}"
               class="block text-center bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 font-semibold">
                ← Back to Dashboard
            </a>

            <a href="{{ route('shop.index') }}"
               class="mt-2 block text-center bg-green-600 text-black py-2 rounded-lg hover:bg-green-700 font-semibold">
                🏠 Shop Home
            </a>
        </div>

        <!-- MENU -->
        <nav class="px-4 py-4 flex-1 overflow-y-auto">
            <p class="text-xs uppercase font-bold text-gray-500 mb-2">Shop Management</p>

            <a href="{{ route('shop.products') }}"
               class="block p-2 rounded hover:bg-green-100 text-gray-700 font-medium">
                📦 Manage Products
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

    <!-- CONTENT AREA -->
    <div class="content">
        @yield('content')
    </div>

</div>

</body>
</html>
