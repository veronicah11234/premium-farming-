<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $title ?? config('app.name', 'POS System') }}</title>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

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
<body>

<!-- Sidebar -->
<div class="sidebar">

    <!-- Logo -->
    <div class="logo-box">
        <img src="{{ asset('images/logo.jpeg') }}" alt="Logo">
        <h5 class="text-white mt-2 mb-0">Premium Farming Feeds</h5>
        <small class="text-secondary">Quality • Nutrition • Growth</small>
    </div>

    <!-- Menu Navigation -->
    <ul class="nav flex-column px-3 mt-3">

        <!-- Dashboard -->
        <li class="nav-item">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <img src="{{ asset('images/me.png') }}">
        </li>

        <!-- ONLINE SHOP SECTION -->
        <li class="nav-item mt-2">
            <strong class="text-uppercase text-secondary small">Online Shop</strong>
        </li>

        <li class="nav-item">
            <a href="{{ route('shop.index') }}">Shop Home</a>
            <img src="{{ asset('images/me.png') }}">
        </li>

        <li class="nav-item">
            <a href="{{ route('shop.products') }}">Manage Products</a>
            <img src="{{ asset('images/me.png') }}">
        </li>

        <li class="nav-item">
            <a href="{{ route('shop.orders') }}">Orders</a>
            <img src="{{ asset('images/me.png') }}">
        </li>

        <li class="nav-item">
            <a href="{{ route('shop.customers') }}">Customers</a>
            <img src="{{ asset('images/me.png') }}">
        </li>

        <li class="nav-item">
            <a href="{{ route('shop.reports') }}">Reports</a>
            <img src="{{ asset('images/me.png') }}">
        </li>


        <!-- POS SECTION -->
        <li class="nav-item mt-3">
            <strong class="text-uppercase text-secondary small">POS System</strong>
        </li>

        <li class="nav-item">
            <a href="{{ route('pos.sell') }}">POS Sell</a>
            <img src="{{ asset('images/me.png') }}">
        </li>

        <li class="nav-item">
            <a href="{{ route('pos.categories') }}">Categories</a>
            <img src="{{ asset('images/me.png') }}">
        </li>

        <li class="nav-item">
            <a href="{{ route('pos.items') }}">Items</a>
            <img src="{{ asset('images/me.png') }}">
        </li>

        <li class="nav-item">
            <a href="{{ route('pos.stores') }}">Stores</a>
            <img src="{{ asset('images/me.png') }}">
        </li>

        <li class="nav-item">
            <a href="{{ route('pos.goods-received') }}">Goods Received</a>
            <img src="{{ asset('images/me.png') }}">
        </li>

        <li class="nav-item">
            <a href="{{ route('pos.update-prices') }}">Update Prices</a>
            <img src="{{ asset('images/me.png') }}">
        </li>

        <li class="nav-item">
            <a href="/reports/sales">Sales Report</a>
            <img src="{{ asset('images/me.png') }}">
        </li>


        <!-- Profile -->
        <li class="nav-item mt-3">
            <a href="/profile">Profile</a>
            <img src="{{ asset('images/me.png') }}">
        </li>

        <!-- Logout -->
        <li class="nav-item mt-3">
            <a href="/logout" class="text-danger fw-bold">Logout</a>
        </li>

    </ul>

</div>

<!-- Page Content -->
<div class="content">
    @yield('content')
</div>

</body>
</html>
