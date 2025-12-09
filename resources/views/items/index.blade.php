@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="text-success">Items List</h2>
        <a href="{{ route('items.create') }}" class="btn btn-success">
            + Add New Item
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead class="table-success">
            <tr>
                <th>ID</th>
                <th>Item Name</th>
                <th>Buying Price</th>
                <th>Selling Price</th>
                <th>Supplier</th>
                <th width="180">Actions</th>
            </tr>
        </thead>

        <tbody>
            @forelse($items as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->item_name }}</td>
                    <td>KES {{ number_format($item->buying_price) }}</td>
                    <td>KES {{ number_format($item->selling_price) }}</td>
                    <td>{{ $item->supplier }}</td>

                    <td>
                        <!-- EDIT BUTTON -->
                        <a href="{{ route('items.edit', $item->id) }}" class="btn btn-primary btn-sm">
                            Edit
                        </a>

                        <!-- DELETE BUTTON -->
                        <form action="{{ route('items.destroy', $item->id) }}" 
                              method="POST" 
                              style="display:inline-block;"
                              onsubmit="return confirm('Are you sure you want to delete this item?');">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-danger btn-sm">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>

            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">
                        No items found.
                    </td>
                </tr>
            @endforelse
        </tbody>

    </table>

</div>
@endsection
