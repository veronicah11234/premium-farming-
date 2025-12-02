<!-- Product Page with Bootstrap -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Premium Feeds</a>
  </div>
</nav>

<div class="container">
    <h2 class="mb-4 text-center">Our Products</h2>

    <div class="row" id="product-list">
        <!-- Example product card -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                <img src="{{ asset('images/dairyhigh.jpeg') }}" class="h-48 w-full object-cover">
                <div class="card-body">
                    <h5 class="card-title">Dairy Meal</h5>
                    <p class="card-text">High‑quality feed specially formulated for dairy cows.</p>
                    <h6 class="text-success fw-bold mb-3">Ksh 2,500</h6>
                    <form action="/cart/add" method="POST">
                        <!-- @csrf in real Blade file -->
                        <input type="hidden" name="product_id" value="1">
                        <button type="submit" class="btn btn-primary w-100">Add to Cart</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Duplicate for more products -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                <img src="{{ asset('images/kienyeji.jpeg') }}" class="h-48 w-full object-cover">
                <div class="card-body">
                    <h5 class="card-title">Layers Mash</h5>
                    <p class="card-text">Nutritious feed designed for improved egg production.</p>
                    <h6 class="text-success fw-bold mb-3">Ksh 1,800</h6>
                    <form action="/cart/add" method="POST">
                        <input type="hidden" name="product_id" value="2">
                        <button type="submit" class="btn btn-primary w-100">Add to Cart</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                <img src="{{ asset('images/dairy.jpeg') }}" class="h-48 w-full object-cover">
                <div class="card-body">
                    <h5 class="card-title">Pig Grower</h5>
                    <p class="card-text">Balanced nutrition feed for growing pigs.</p>
                    <h6 class="text-success fw-bold mb-3">Ksh 2,200</h6>
                    <form action="/cart/add" method="POST">
                        <input type="hidden" name="product_id" value="3">
                        <button type="submit" class="btn btn-primary w-100">Add to Cart</button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
