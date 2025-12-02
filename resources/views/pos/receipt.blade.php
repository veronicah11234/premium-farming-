<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Receipt</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; }
        .center { text-align: center; }
        .line { border-bottom: 1px dashed #000; margin: 10px 0; }
        table { width: 100%; border-collapse: collapse; }
        table th, table td { text-align: left; padding: 4px 0; }
        .right { text-align: right; }
    </style>
</head>
<body>

    <div class="center">
        <h2>PREMIUM FARMING FEEDS</h2>
        <p>Branches: Turitu, Ikinu & Githiga - Kiambu</p>
        <p>Phone: 0790641428</p>
        <p>Paybill: <strong>247247</strong> | Account No: <strong>470470</strong></p>
    </div>

    <div class="line"></div>

    <p><strong>Receipt No:</strong> {{ $receiptNumber }}</p>
    <p><strong>Date:</strong> {{ $date }}</p>
    <p><strong>Served By:</strong> {{ $servedBy }}</p>

    <div class="line"></div>

    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th class="right">Qty</th>
                <th class="right">Price</th>
                <th class="right">Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $item)
            <tr>
                <td>{{ $item['name'] }}</td>
                <td class="right">{{ $item['quantity'] }}</td>
                <td class="right">{{ number_format($item['price'], 2) }}</td>
                <td class="right">{{ number_format($item['amount'], 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="line"></div>

    <p class="right"><strong>Total: Ksh. {{ number_format($total, 2) }}</strong></p>

    <div class="line"></div>

    <p class="center">Goods once sold are not refundable</p>
    <p class="center">Welcome Again!</p>

</body>
</html>
