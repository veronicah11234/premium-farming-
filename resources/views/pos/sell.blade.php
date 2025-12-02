@extends('layouts.app')

@section('content')
<div class="p-6 bg-gray-100 min-h-screen">

    <h1 class="text-2xl font-bold mb-4">POS - New Sale</h1>

    <div class="flex flex-col lg:flex-row gap-6">

        <!-- LEFT: POS FORM -->
        <div class="flex-1 bg-white shadow rounded p-4">

            <!-- SEARCH + DROPDOWN -->
            <div class="mb-4 flex flex-col gap-2">
                
                <div class="flex gap-2">
                    <input type="text" id="productSearch" placeholder="Search product..."
                           class="border px-2 py-1 flex-1">

                    <button type="button" id="openProductList"
                            class="px-3 py-1 bg-blue-600 text-black rounded">
                        Select Item
                    </button>
                </div>

                <!-- PRODUCT SELECT -->
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

                <!-- ITEM INPUTS -->
                <div class="grid grid-cols-3 gap-2 mt-2">
                    <input type="number" id="qty" value="1" placeholder="Qty" class="border px-2 py-1">
                    <select id="unit" class="border px-2 py-1">
                        <option>pcs</option>
                        <option>kg</option>
                        <option>bag</option>
                    </select>
                    <input type="number" id="unitPrice" placeholder="Unit Price" class="border px-2 py-1">
                    <input type="number" id="discount" value="0" placeholder="Discount" class="border px-2 py-1">
                    <select id="vatMode" class="border px-2 py-1">
                        <option value="none">No VAT</option>
                        <option value="inclusive">VAT Inclusive</option>
                        <option value="exclusive">VAT Exclusive</option>
                    </select>

                    <button type="button" id="addItemBtn"
                            class="px-3 py-1 bg-green-600 text-black rounded">
                        Add Item
                    </button>
                </div>
            </div>

            <!-- TABLE -->
            <table class="w-full border border-gray-300 mt-4">
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

            <input type="hidden" id="itemsInput">

            <!-- PRINT RECEIPT -->
            <button id="printReceiptBtn"
                    class="mt-4 px-4 py-2 bg-purple-700 text-black rounded">
                Complete Sale
            </button>
        </div>

        <!-- RIGHT: CALCULATOR -->
        <div class="w-full lg:w-1/4 bg-white shadow rounded p-4">
            <h2 class="text-xl font-semibold mb-4">Calculator</h2>
            <div class="flex flex-col space-y-2">
                <div class="flex justify-between"><span>Subtotal:</span> <span id="subtotal">0.00</span></div>
                <div class="flex justify-between"><span>Tax:</span> <span id="taxTotal">0.00</span></div>
                <div class="flex justify-between font-bold text-lg"><span>Total:</span> <span id="total">0.00</span></div>
            </div>
        </div>
    </div>
</div>

<!-- RECEIPT MODAL -->
<div id="receiptModal" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center">
    <div class="bg-white p-6 rounded shadow w-80">

        <h2 class="text-blue text-xl font-bold text-center mb-1">Premium Farming Feeds</h2>
        <p class="text-center text-xs">Branches: Turitu, Ikinu & Githiga - Kiambu</p>
        <p class="text-center text-xs">Phone: 0790641428</p>
        <p class="text-center text-xs mb-2">Paybill: 247247 | Account No: 470470</p>

        <hr class="my-2">

        <p class="text-center text-sm mb-2 font-semibold">Official Receipt</p>

        <div id="receiptContent" class="text-sm border-t border-b py-2"></div>

        <div class="text-center mt-4 flex justify-between">
            <button onclick="printReceipt()" class="px-4 py-2 bg-green-700 text-black rounded">Print</button>
            <button onclick="closeReceipt()" class="px-4 py-2 bg-red-600 text-black rounded">Close</button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {

    let saleItems = [];

    const productSelect = document.getElementById('productSelect');
    const productSearch = document.getElementById('productSearch');
    const openProductList = document.getElementById('openProductList');

    const qty = document.getElementById('qty');
    const unit = document.getElementById('unit');
    const unitPrice = document.getElementById('unitPrice');
    const discount = document.getElementById('discount');
    const vatMode = document.getElementById('vatMode');

    const saleItemsTbody = document.getElementById('saleItems');

    // Toggle dropdown
    openProductList.addEventListener('click', () => {
        productSelect.classList.toggle('hidden');
    });

    // Search filter
    productSearch.addEventListener('input', () => {
        const text = productSearch.value.toLowerCase();
        [...productSelect.options].forEach(opt => {
            opt.style.display = opt.text.toLowerCase().includes(text) ? "block" : "none";
        });
    });

    // Auto-fill price
    productSelect.addEventListener('change', () => {
        const selected = productSelect.options[productSelect.selectedIndex];
        unitPrice.value = selected.dataset.price || "";
    });

    // ADD ITEM
    document.getElementById('addItemBtn').addEventListener('click', () => {

        const selected = productSelect.options[productSelect.selectedIndex];
        if (!selected.value) return alert("Select a product");

        let price = parseFloat(unitPrice.value) || 0;
        let qtyVal = parseFloat(qty.value) || 1;
        let disc = parseFloat(discount.value) || 0;

        let sub = price * qtyVal - disc;
        let tax = 0;

        if (vatMode.value === "inclusive") {
            tax = sub - (sub / 1.16);
        } else if (vatMode.value === "exclusive") {
            tax = sub * 0.16;
            sub += tax;
        }

        saleItems.push({
            name: selected.text,
            quantity: qtyVal,
            unit: unit.value,
            price: price,
            discount: disc,
            tax: tax,
            subtotal: sub
        });

        renderTable();

        unitPrice.value = "";
        discount.value = 0;
        qty.value = 1;
        productSelect.value = "";
    });

    // RENDER TABLE
    function renderTable() {
        saleItemsTbody.innerHTML = "";

        let subtotal = 0, tax = 0, total = 0;

        saleItems.forEach((item, i) => {
            subtotal += item.subtotal - item.tax;
            tax += item.tax;
            total += item.subtotal;

            saleItemsTbody.innerHTML += `
                <tr>
                    <td class="border px-2 py-1">${item.name}</td>
                    <td class="border px-2 py-1">${item.quantity}</td>
                    <td class="border px-2 py-1">${item.unit}</td>
                    <td class="border px-2 py-1">${item.price}</td>
                    <td class="border px-2 py-1">${item.discount}</td>
                    <td class="border px-2 py-1">${item.tax.toFixed(2)}</td>
                    <td class="border px-2 py-1">${item.subtotal.toFixed(2)}</td>
                    <td class="border px-2 py-1">
                        <button onclick="removeItem(${i})"
                                class="bg-red-600 text-black px-2 py-1 rounded">
                            Remove
                        </button>
                    </td>
                </tr>`;
        });

        document.getElementById("subtotal").innerText = subtotal.toFixed(2);
        document.getElementById("taxTotal").innerText = tax.toFixed(2);
        document.getElementById("total").innerText = total.toFixed(2);
    }

    // REMOVE
    window.removeItem = (i) => {
        saleItems.splice(i, 1);
        renderTable();
    };

    // SHOW RECEIPT
    document.getElementById("printReceiptBtn").addEventListener("click", () => {

        if (saleItems.length === 0) return alert("Add items first!");

        let html = "";

        saleItems.forEach(item => {
            html += `
                <div class="flex justify-between">
                    <span>${item.name} (${item.quantity} ${item.unit})</span>
                    <span>${item.subtotal.toFixed(2)}</span>
                </div>
            `;
        });

        html += `
            <hr class="my-2">
            <div class="flex justify-between"><strong>Subtotal:</strong><span>${document.getElementById("subtotal").innerText}</span></div>
            <div class="flex justify-between"><strong>Tax:</strong><span>${document.getElementById("taxTotal").innerText}</span></div>
            <div class="flex justify-between text-lg font-bold"><strong>Total:</strong><span>${document.getElementById("total").innerText}</span></div>
        `;

        document.getElementById("receiptContent").innerHTML = html;
        document.getElementById("receiptModal").classList.remove("hidden");
    });
});

// PRINT ONLY RECEIPT
function printReceipt() {
    let content = document.getElementById("receiptContent").innerHTML;
    let win = window.open("", "PRINT", "height=600,width=400");
    win.document.write(content);
    win.document.close();
    win.print();
}

// CLOSE MODAL
function closeReceipt() {
    document.getElementById("receiptModal").classList.add("hidden");
}
</script>

@endsection
