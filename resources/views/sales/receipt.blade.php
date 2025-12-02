<!DOCTYPE html>
<html>
<head>
    <title>Receipt #{{ $sale->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            color: #333;
        }

        .receipt-container {
            width: 380px;
            margin: auto;
            border: 1px solid #bbb;
            padding: 15px;
            border-radius: 8px;
            background: #fdfdfd;
        }

        h2 {
            text-align: center;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        .info {
            margin-bottom: 10px;
            font-size: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            font-size: 14px;
        }

        table th, table td {
            border-bottom: 1px solid #ccc;
            padding: 6px 0;
        }

        .total {
            font-weight: bold;
            font-size: 16px;
            text-align: right;
            margin-top: 10px;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 13px;
            color: #666;
        }

        .print-btn {
            display: block;
            width: 100%;
            margin-top: 15px;
            padding: 10px;
            background: black;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 6px;
            font-size: 16px;
        }

        .print-btn:hover {
            opacity: 0.8;
        }

    </style>

    <script>
        function printReceipt() {
            window.print();
        }
    </script>

</head>
<body>

<div class="receipt-container">

    <h2>SALES RECEIPT</h2>

    <div class="info">
        <strong>Receipt No:</strong> {{ $sale->id }} <br>
        <strong>Date:</strong> {{ $sale->date }} <br>
        <strong>Total Items:</strong> {{ $sale->items->sum('quantity') }}
    </div>

    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Qty</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sale->items as $item)
                <tr>
                    <td>{{ $item->product_name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>KSh {{ number_format($item->subtotal, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total">
        TOTAL: KSh {{ number_format($sale->total, 2) }}
    </div>

    <button class="print-btn" onclick="printReceipt()">
        Print Receipt
    </button>

    <div class="footer">
        Thank you for your business! <br>
        Primetime Ventures POS System
    </div>

</div>

</body>
</html>
