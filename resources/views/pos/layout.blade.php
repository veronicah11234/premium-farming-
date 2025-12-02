@extends('layouts.app')

@section('content')
@php
    // pageTitle is used in main layout topbar
    $pageTitle = 'POS - New Sale';
@endphp

<div class="p-3">

    <div class="bg-white shadow rounded p-3 mb-4">
        <h2 class="h6 mb-3">Current Sale</h2>

        <!-- Items Table -->
        <div class="table-responsive">
            <table class="table table-sm table-bordered mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Item</th>
                        <th style="width:80px">Qty</th>
                        <th style="width:100px">Unit</th>
                        <th style="width:110px">Unit Price</th>
                        <th style="width:110px">Discount</th>
                        <th style="width:120px">VAT Mode</th>
                        <th style="width:110px">Tax</th>
                        <th style="width:120px">Subtotal</th>
                        <th style="width:100px">Action</th>
                    </tr>
                </thead>
                <tbody id="saleItems">
                    <!-- JS will populate -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add Item Row -->
    <div class="bg-white shadow rounded p-3 mb-4 d-flex flex-wrap gap-2 align-items-center">
        <div style="min-width:280px; flex:1;">
            <label class="form-label mb-1">Product</label>
            <select id="productSelect" class="form-select">
                <option value="">Select Item</option>
                @if(!empty($products) && $products->count())
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                            {{ $product->name }}
                        </option>
                    @endforeach
                @else
                    <!-- fallback demo options so page doesn't break -->
                    <option value="1" data-price="100">Maize Germ</option>
                    <option value="2" data-price="150">Dairy Meal</option>
                    <option value="3" data-price="80">Growers Mash</option>
                @endif
            </select>
        </div>

        <div style="width:100px">
            <label class="form-label mb-1">Qty</label>
            <input id="qty" type="number" class="form-control" value="1">
        </div>

        <div style="width:110px">
            <label class="form-label mb-1">Unit</label>
            <select id="unit" class="form-select">
                <option>pcs</option>
                <option>kg</option>
                <option>bag</option>
            </select>
        </div>

        <div style="width:120px">
            <label class="form-label mb-1">Unit Price</label>
            <input id="unitPrice" type="number" class="form-control">
        </div>

        <div style="width:120px">
            <label class="form-label mb-1">Discount</label>
            <input id="discount" type="number" class="form-control" value="0">
        </div>

        <div style="width:140px">
            <label class="form-label mb-1">VAT Mode</label>
            <select id="vatMode" class="form-select">
                <option value="non-vatable">Non-Vatable</option>
                <option value="inclusive">Inclusive</option>
                <option value="exclusive">Exclusive</option>
            </select>
        </div>

        <div class="align-self-end">
            <button id="addItemBtn" class="btn btn-success">Add Item</button>
        </div>
    </div>

    <!-- Totals & Actions -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <div>Subtotal: <strong id="subtotal">0.00</strong></div>
            <div>Tax: <strong id="taxTotal">0.00</strong></div>
            <div class="fs-5">Total: <strong id="total">0.00</strong></div>
        </div>

        <div class="d-flex gap-2">
            <button id="cashBtn" class="btn btn-primary">Cash</button>
            <button id="mobileBtn" class="btn btn-warning text-dark">Mobile Pay</button>
            <button id="cardBtn" class="btn btn-secondary">Card</button>
        </div>
    </div>

</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    let saleItems = [];

    const productSelect = document.getElementById('productSelect');
    const qty = document.getElementById('qty');
    const unit = document.getElementById('unit');
    const unitPrice = document.getElementById('unitPrice');
    const discount = document.getElementById('discount');
    const vatMode = document.getElementById('vatMode');
    const saleItemsTbody = document.getElementById('saleItems');

    function renderTable(){
        saleItemsTbody.innerHTML = '';
        let sub = 0, taxTotal = 0, total = 0;

        saleItems.forEach((it, i) => {
            sub += (it.subtotal - it.tax);
            taxTotal += it.tax;
            total += it.subtotal;

            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${it.name}</td>
                <td>${it.qty}</td>
                <td>${it.unit}</td>
                <td>${it.unitPrice.toFixed(2)}</td>
                <td>${it.discount.toFixed(2)}</td>
                <td>${it.vatMode}</td>
                <td>${it.tax.toFixed(2)}</td>
                <td>${it.subtotal.toFixed(2)}</td>
                <td><button class="btn btn-sm btn-danger" onclick="removeItem(${i})">Remove</button></td>
            `;
            saleItemsTbody.appendChild(tr);
        });

        document.getElementById('subtotal').textContent = sub.toFixed(2);
        document.getElementById('taxTotal').textContent = taxTotal.toFixed(2);
        document.getElementById('total').textContent = total.toFixed(2);
    }

    window.removeItem = function(idx){
        saleItems.splice(idx,1);
        renderTable();
    }

    productSelect.addEventListener('change', function(){
        const opt = this.options[this.selectedIndex];
        if(opt && opt.dataset && opt.dataset.price){
            unitPrice.value = opt.dataset.price;
        }
    });

    document.getElementById('addItemBtn').addEventListener('click', function(){
        const selected = productSelect.options[productSelect.selectedIndex];
        if(!selected || !selected.value){
            alert('Please select a product');
            return;
        }

        const q = parseFloat(qty.value) || 1;
        const u = unit.value || 'pcs';
        const p = parseFloat(unitPrice.value) || parseFloat(selected.dataset.price) || 0;
        const d = parseFloat(discount.value) || 0;
        const v = vatMode.value || 'non-vatable';
        const taxRate = 0.16;

        let subtotal = q * p - d;
        let tax = 0;
        if(v === 'inclusive'){
            tax = subtotal - (subtotal / (1 + taxRate));
        } else if(v === 'exclusive'){
            tax = subtotal * taxRate;
            subtotal += tax;
        }

        saleItems.push({
            product_id: selected.value,
            name: selected.text,
            qty: q,
            unit: u,
            unitPrice: p,
            discount: d,
            vatMode: v,
            tax: tax,
            subtotal: subtotal
        });

        // reset small inputs
        qty.value = 1;
        unitPrice.value = '';
        discount.value = 0;
        productSelect.value = '';

        renderTable();
    });

    // quick handlers for payment buttons (hook into storeSale route later)
    document.getElementById('cashBtn').addEventListener('click', function(){
        if(saleItems.length === 0){ alert('Add at least one item'); return; }
        // TODO: POST to /pos/storeSale or open payment modal
        alert('Record sale (implement backend call). Total: ' + document.getElementById('total').textContent);
    });

    document.getElementById('mobileBtn').addEventListener('click', function(){
        if(saleItems.length === 0){ alert('Add at least one item'); return; }
        alert('Mobile payment (implement backend integration).');
    });

    document.getElementById('cardBtn').addEventListener('click', function(){
        if(saleItems.length === 0){ alert('Add at least one item'); return; }
        alert('Card payment (implement backend integration).');
    });

});
</script>
@endpush

@endsection
