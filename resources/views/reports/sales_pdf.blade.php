<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sales Report PDF</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        h2, h3 {
            text-align: center;
            margin-bottom: 5px;
        }

        .section-title {
            background: #f2f2f2;
            padding: 5px;
            font-weight: bold;
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }
        table th, table td {
            border: 1px solid #444;
            padding: 6px;
            text-align: left;
        }
        table th {
            background: #ddd;
        }
    </style>
</head>

<body>

    <h2>Sales Report</h2>
    <h3>Date: {{ $date }} | Month: {{ $month }}</h3>

    {{-- ================= DAILY SALES ================= --}}
    <div class="section-title">Daily Sales ({{ $date }})</div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Sale ID</th>
                <th>Total Amount</th>
                <th>Payment Method</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($dailySales as $index => $sale)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $sale->id }}</td>
                    <td>KES {{ number_format($sale->total, 2) }}</td>
                    <td>{{ $sale->payment_method ?? 'N/A' }}</td>
                    <td>{{ $sale->date }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align:center;">No sales recorded for this date.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- ================= MONTHLY SALES ================= --}}
    <div class="section-title">Monthly Sales ({{ $month }})</div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Sale ID</th>
                <th>Total Amount</th>
                <th>Payment Method</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($monthlySales as $index => $sale)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $sale->id }}</td>
                    <td>KES {{ number_format($sale->total, 2) }}</td>
                    <td>{{ $sale->payment_method ?? 'N/A' }}</td>
                    <td>{{ $sale->date }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align:center;">No sales recorded for this month.</td>
                </tr>
            @endforelse
        </tbody>
    </table>


</body>
</html>
