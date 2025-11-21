@extends('layouts.app')

@section('content')
<div class="p-6 bg-gray-100 min-h-screen">

    <h1 class="text-2xl font-bold mb-4">POS - New Sale</h1>

    <!-- Items Table -->
    <div class="bg-white shadow rounded p-4 mb-4">
        <table class="w-full table-auto border-collapse border border-gray-200">
            <thead>
                <tr class="bg-gray-50">
                    <th class="border px-2 py-1">Item</th>
                    <th class="border px-2 py-1">Qty</th>
                    <th class="border px-2 py-1">Unit</th>
                    <th class="border px-2 py-1">Unit Price</th>
                    <th class="border px-2 py-1">Discount</th>
                    <th class="border px-2 py-1">VAT Mode</th>
                    <th class="border px-2 py-1">Tax</th>
                    <th class="border px-2 py-1">Subtotal</th>
                    <th class="border px-2 py-1">Action</th>
                </tr>
            </thead>
            <tbody id="saleItems">
                <!-- JS will populate items here -->
            </tbody>
        </table>
    </div>

    <!-- Add Item -->
    <div class="bg-white shadow rounded p-4 mb-4 flex space-x-2">
        <select id="productSelect" class="border rounded px-2 py-1">
            <option value="">Select Item</option>
            @foreach($products as $product)
                <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                    {{ $product->name }}
                </option>
            @endforeach
        </select>

        <input type="number" id="qty" placeholder="Qty" class="border rounded px-2 py-1 w-20">
        <select id="unit" class="border rounded px-2 py-1">
            <option value="pcs">pcs</option>
            <option value="kg">kg</option>
            <option value="bag">bag</option>
        </select>

        <input type="number" id="unitPrice" placeholder="Unit Price" class="border rounded px-2 py-1 w-24">
        <input type="number" id="discount" placeholder="Discount" class="border rounded px-2 py-1 w-24">

        <select id="vatMode" class="border rounded px-2 py-1">
            <option value="inclusive">Inclusive</option>
            <option value="exclusive">Exclusive</option>
            <option value="non-vatable">Non-Vatable</option>
        </select>

        <button id="addItemBtn" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
            Add Item
        </button>
    </div>

    <!-- Totals -->
    <div class="bg-white shadow rounded p-4 mb-4 flex justify-end space-x-6">
        <div>Subtotal: <span id="subtotal">0.00</span></div>
        <div>Tax: <span id="taxTotal">0.00</span></div>
        <div>Total: <span id="total">0.00</span></div>
    </div>

    <!-- Payment Section -->
    <div class="bg-white shadow rounded p-4 flex justify-end space-x-4">
        <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            Cash
        </button>
        <button class="px-4 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-700">
            Mobile Payment
        </button>
        <button class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
            Card
        </button>
    </div>
</div>

<script>
    let saleItems = [];

    const addItemBtn = document.getElementById('addItemBtn');

    addItemBtn.addEventListener('click', () => {
        const productSelect = document.getElementById('productSelect');
        const qty = parseFloat(document.getElementById('qty').value);
        const unit = document.getElementById('unit').value;
        const unitPrice = parseFloat(document.getElementById('unitPrice').value);
        const discount = parseFloat(document.getElementById('discount').value) || 0;
        const vatMode = document.getElementById('vatMode').value;

        if(!productSelect.value || !qty || !unitPrice) return;

        const productName = productSelect.options[productSelect.selectedIndex].text;

        const taxRate = 0.16; // 16% VAT
        let tax = 0;
        let subtotal = qty * unitPrice - discount;

        if(vatMode === 'inclusive') {
            tax = subtotal - (subtotal / (1 + taxRate));
        } else if(vatMode === 'exclusive') {
            tax = subtotal * taxRate;
            subtotal = subtotal + tax;
        }

        const item = {
            name: productName,
            qty,
            unit,
            unitPrice,
            discount,
            vatMode,
            tax,
            subtotal
        };

        saleItems.push(item);
        renderTable();
    });

    function renderTable() {
        const tbody = document.getElementById('saleItems');
        tbody.innerHTML = '';
        let subtotalTotal = 0, taxTotal = 0, total = 0;

        saleItems.forEach((item, index) => {
            subtotalTotal += item.subtotal - item.tax;
            taxTotal += item.tax;
            total += item.subtotal;

            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td class="border px-2 py-1">${item.name}</td>
                <td class="border px-2 py-1">${item.qty}</td>
                <td class="border px-2 py-1">${item.unit}</td>
                <td class="border px-2 py-1">${item.unitPrice.toFixed(2)}</td>
                <td class="border px-2 py-1">${item.discount.toFixed(2)}</td>
                <td class="border px-2 py-1">${item.vatMode}</td>
                <td class="border px-2 py-1">${item.tax.toFixed(2)}</td>
                <td class="border px-2 py-1">${item.subtotal.toFixed(2)}</td>
                <td class="border px-2 py-1">
                    <button onclick="removeItem(${index})" class="px-2 py-1 bg-red-600 text-white rounded hover:bg-red-700">Remove</button>
                </td>
            `;
            tbody.appendChild(tr);
        });

        document.getElementById('subtotal').innerText = subtotalTotal.toFixed(2);
        document.getElementById('taxTotal').innerText = taxTotal.toFixed(2);
        document.getElementById('total').innerText = total.toFixed(2);
    }

    function removeItem(index) {
        saleItems.splice(index, 1);
        renderTable();
    }
</script>

@endsection
