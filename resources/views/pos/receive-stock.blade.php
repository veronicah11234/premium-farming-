<x-guest-layout>
    <h2 class="text-lg font-semibold mb-4">Receive Stock</h2>

    @if(session('success'))
        <div class="text-green-600 mb-4">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('receive.stock') }}">
        @csrf
        <div class="mb-4">
            <label for="product_id">Product</label>
            <select name="product_id" class="border p-2 w-full">
                <option value="">Select product</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="quantity">Quantity</label>
            <input type="number" name="quantity" min="1" class="border p-2 w-full" />
        </div>

        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded">
            Receive Stock
        </button>
    </form>
</x-guest-layout>
