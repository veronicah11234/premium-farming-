<!DOCTYPE html>
<html>
<head>
    <title>Shop Panel</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<nav class="navbar navbar-dark bg-dark px-3">
    <a class="navbar-brand text-white" href="/shop">Shop</a>
    <a class="text-white ms-3" href="/shop/orders">Orders</a>
    <a class="text-white ms-3" href="/shop/customers">Customers</a>
    <a class="text-white ms-3" href="/shop/categories">Categories</a>

    <a class="text-white ms-3" href="/shop/products">Products</a>
    <a class="text-white ms-3" href="/shop/reports">Reports</a>
</nav>

<div class="container mt-4">
    @yield('content')
</div>

</body>
</html>
