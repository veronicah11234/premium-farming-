@extends('layout')

@section('title','Place Order')

@section('content')
<h1>Place an Order</h1>

<form method="post" action="{{ route('orders.store') }}">
    @csrf

    <div class="mb-3">
        <label>Your name</label>
        <input type="text" name="customer_name" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Phone</label>
        <input type="text" name="customer_phone" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Delivery Address</label>
        <textarea name="delivery_address" class="form-control"></textarea>
    </div>

    <div id="items">
        <h5>Order Items</h5>
        <div class="row item-row mb-2">
            <div class="col-md-6">
                <select name="items[0][product_id]" class="form-control" required>
                    <option value="">Select product</option>
                    @foreach($products as $p)
                        <option value="{{ $p->id }}">{{ $p->name }} — KES {{ number_format($p->price,2) }} (Stock: {{ $p->quantity }})</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <input type="number" name="items[0][quantity]" class="form-control" value="1" min="1" required>
            </div>
            <div class="col-md-3">
                <button type="button" class="btn btn-danger remove-item">Remove</button>
            </div>
        </div>
    </div>

    <button id="add-item" type="button" class="btn btn-secondary mb-3">Add another item</button>

    <button class="btn btn-primary">Place Order</button>
</form>

<script>
document.addEventListener('DOMContentLoaded', function(){
    let index = 1;
    document.getElementById('add-item').addEventListener('click', function(){
        const row = document.querySelector('.item-row').cloneNode(true);
        row.querySelectorAll('select,input').forEach(function(el){
            el.name = el.name.replace(/\[\d+\]/, '['+index+']');
            if(el.tagName == 'INPUT') el.value = '1';
            if(el.tagName == 'SELECT') el.selectedIndex = 0;
        });
        document.getElementById('items').appendChild(row);
        index++;
    });

    document.getElementById('items').addEventListener('click', function(e){
        if(e.target.classList.contains('remove-item')){
            const rows = document.querySelectorAll('.item-row');
            if(rows.length > 1) e.target.closest('.item-row').remove();
        }
    });
});
</script>
@endsection

