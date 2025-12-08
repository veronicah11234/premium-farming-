<div class="container mt-5">
    <h2 class="mb-4 fw-bold text-primary">Your Cart</h2>

    @if(count($cart) > 0)
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Image</th>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($cart as $item)
                    <tr>
                        <td>
                            <img src="{{ asset('images/'.$item['image']) }}" width="90" height="70" class="rounded">
                        </td>

                        <td>{{ $item['name'] }}</td>
                        <td>KES {{ number_format($item['price']) }}</td>

                        <!-- Editable Quantity -->
                        <td>
                            <form action="{{ route('cart.update', $item['id']) }}" method="POST" class="d-flex">
                                @csrf
                                <input type="number" name="quantity" value="{{ $item['quantity'] }}"
                                       class="form-control form-control-sm w-50">

                                <button class="btn btn-success btn-sm ms-1">Update</button>
                            </form>
                        </td>

                        <td>KES {{ number_format($item['price'] * $item['quantity']) }}</td>

                        <!-- EDIT & REMOVE -->
                        <td class="d-flex gap-2 flex-nowrap" style="min-width: 150px;">
                            <button class="btn btn-danger btn-sm">Remove</button>

                            
                        
                            <form action="{{ route('cart.remove', $item['id']) }}" method="POST">
                                @csrf
                                <button class="btn btn-danger btn-sm">Remove</button>
                            </form>
                        </td>
                        

                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="text-end">
            <a href="{{ route('checkout') }}" class="btn btn-lg btn-warning text-dark fw-bold">
                Proceed to Checkout →
            </a>
        </div>

    @else
        <p class="text-muted">Your cart is empty.</p>
    @endif
</div>
