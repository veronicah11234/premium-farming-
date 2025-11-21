@extends('layouts.app')

@section('content')
<div class="p-6 bg-gray-100 min-h-screen">

    <h1 class="text-2xl font-bold mb-4">POS - New Sale</h1>

    <div class="flex flex-col lg:flex-row gap-6">

        <!-- LEFT: Form + Table -->
        <div class="flex-1 bg-white shadow rounded p-4">

            <!-- SEARCH + SELECT -->
            <div class="mb-4 flex flex-col gap-2">
                <div class="flex gap-2">
                    <input type="text" id="productSearch" placeholder="Search product..." class="border px-2 py-1 flex-1">
                    <button type="button" id="openProductList" class="px-3 py-1 bg-blue-600 text-white rounded">Select Item</button>
                </div>

                <select id="productSelect" class="border w-full mt-2">
                    <option value="">Select Item</option>
                    <option value="1" data-price="100">Maize Germ</option>
                    <option value="2" data-price="150">Dairy Meal</option>
                    <option value="3" data-price="80">Growers Mash</option>
                    <option value="4" data-price="120">Maize Bran</option>
                    <option value="5" data-price="200">Layer Mash</option>
                    <option value="6" data-price="250">Broiler Starter</option>
                    <option value="7" data-price="180">Chicken Feed</option>
                    <option value="8" data-price="220">Pig Grower</option>
                </select>

                <div class="grid grid-cols-3 gap-2 mt-2">
                    <input type="number" id="qty" placeholder="Qty" class="border px-2 py-1" value="1">
                    <select id="unit" class="border px-2 py-1">
                        <option>pcs</option>
                        <option>kg</option>
                        <option>bag</option>
                    </select>
                    <input type="number" id="unitPrice" placeholder="Unit Price" class="border px-2 py-1">
                    <input type="number" id="discount" placeholder="Discount" class="border px-2 py-1" value="0">
                    <select id="vatMode" class="border px-2 py-1">
                        <option value="none">No VAT</option>
                        <option value="inclusive">VAT Inclusive</option>
                        <option value="exclusive">VAT Exclusive</option>
                    </select>
                    <button type="button" id="addItemBtn" class="px-3 py-1 bg-green-600 text-white rounded">Add Item</button>
                </div>
            </div>

            <!-- TABLE -->
            <table class="w-full table-auto border-collapse border border-gray-200 mt-4">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="border px-2 py-1">Item</th>
                        <th class="border px-2 py-1">Qty</th>
                        <th class="border px-2 py-1">Unit</th>
                        <th class="border px-2 py-1">Price</th>
                        <th class="border px-2 py-1">Discount</th>
                        <th class="border px-2 py-1">VAT</th>
                        <th class="border px-2 py-1">Subtotal</th>
                        <th class="border px-2 py-1">Action</th>
                    </tr>
                </thead>
                <tbody id="saleItems"></tbody>
            </table>

            <input type="hidden" name="items" id="itemsInput">
        </div>

        <!-- RIGHT: Calculator -->
        <div class="w-full lg:w-1/4 bg-white shadow rounded p-4 sticky top-6 h-fit">
            <h2 class="text-xl font-semibold mb-4">Calculator</h2>
            <div class="flex flex-col space-y-2">
                <div class="flex justify-between"><span>Subtotal:</span><span id="subtotal">0.00</span></div>
                <div class="flex justify-between"><span>Tax:</span><span id="taxTotal">0.00</span></div>
                <div class="flex justify-between font-bold text-lg"><span>Total:</span><span id="total">0.00</span></div>
            </div>
        </div>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let saleItems = [];

    const productSelect = document.getElementById('productSelect');
    const productSearch = document.getElementById('productSearch');
    const openProductList = document.getElementById('openProductList');
    const qtyInput = document.getElementById('qty');
    const unitInput = document.getElementById('unit');
    const unitPriceInput = document.getElementById('unitPrice');
    const discountInput = document.getElementById('discount');
    const vatModeInput = document.getElementById('vatMode');
    const saleItemsTbody = document.getElementById('saleItems');
    const itemsInput = document.getElementById('itemsInput');

    // toggle dropdown visibility
    openProductList.addEventListener('click', () => {
        productSelect.classList.toggle('hidden');
    });

    // live search
    productSearch.addEventListener('input', function() {
        const search = this.value.toLowerCase();
        [...productSelect.options].forEach(option => {
            option.style.display = option.text.toLowerCase().includes(search) ? 'block' : 'none';
        });
    });

    // auto-fill price on select
    productSelect.addEventListener('change', function() {
        const selected = this.options[this.selectedIndex];
        if(!selected.value) return;
        unitPriceInput.value = selected.dataset.price;
    });

    // add item
    document.getElementById('addItemBtn').addEventListener('click', function() {
        const selected = productSelect.options[productSelect.selectedIndex];
        if(!selected.value){ alert('Select a product'); return; }

        const qty = parseFloat(qtyInput.value) || 1;
        const unit = unitInput.value;
        const price = parseFloat(unitPriceInput.value) || 0;
        const discount = parseFloat(discountInput.value) || 0;
        const vatMode = vatModeInput.value;
        const taxRate = 0.16;

        let subtotal = qty * price - discount;
        let tax = 0;
        if(vatMode === 'inclusive') tax = subtotal - (subtotal / (1+taxRate));
        else if(vatMode === 'exclusive'){ tax = subtotal * taxRate; subtotal += tax; }

        saleItems.push({
            product_id: selected.value,
            name: selected.text,
            quantity: qty,
            unit,
            unit_price: price,
            discount,
            vatMode,
            tax,
            subtotal
        });

        renderTable();

        qtyInput.value = 1;
        unitPriceInput.value = '';
        discountInput.value = 0;
        productSelect.value = '';
    });

    function renderTable() {
        saleItemsTbody.innerHTML = '';
        let subtotalTotal = 0, taxTotal = 0, total = 0;

        saleItems.forEach((item, idx) => {
            subtotalTotal += item.subtotal - item.tax;
            taxTotal += item.tax;
            total += item.subtotal;

            saleItemsTbody.innerHTML += `
                <tr>
                    <td class="border px-2 py-1">${item.name}</td>
                    <td class="border px-2 py-1">${item.quantity}</td>
                    <td class="border px-2 py-1">${item.unit}</td>
                    <td class="border px-2 py-1">${item.unit_price}</td>
                    <td class="border px-2 py-1">${item.discount}</td>
                    <td class="border px-2 py-1">${item.vatMode}</td>
                    <td class="border px-2 py-1">${item.subtotal.toFixed(2)}</td>
                    <td class="border px-2 py-1">
                        <button type="button" onclick="removeItem(${idx})" class="px-2 py-1 bg-red-600 text-white rounded hover:bg-red-700">Remove</button>
                    </td>
                </tr>`;
        });

        document.getElementById('subtotal').innerText = subtotalTotal.toFixed(2);
        document.getElementById('taxTotal').innerText = taxTotal.toFixed(2);
        document.getElementById('total').innerText = total.toFixed(2);
        itemsInput.value = JSON.stringify(saleItems);
    }

    window.removeItem = function(idx){ saleItems.splice(idx,1); renderTable(); }

});
</script>
@endsection
