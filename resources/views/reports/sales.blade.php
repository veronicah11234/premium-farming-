@extends('layouts.app')

@section('content')
<div class="p-6">

    <h1 class="text-2xl font-bold mb-4">Sales Report</h1>

    <!-- Filters -->
    <div class="flex gap-4 mb-6">
        <form method="GET">
            <label>Date:</label>
            <input type="date" name="date" value="{{ $date }}" class="border px-2 py-1">
            <button class="bg-blue-600 text-black px-3 py-1 rounded">Daily</button>
        </form>

        <form method="GET">
            <label>Month:</label>
            <input type="month" name="month" value="{{ $month }}" class="border px-2 py-1">
            <button class="bg-green-600 text-black px-3 py-1 rounded">Monthly</button>
        </form>

        <a href="{{ route('sales.pdf', ['date'=>$date, 'month'=>$month]) }}"
           class="bg-purple-700 text-white px-3 py-1 rounded">
           Download PDF
        </a>
    </div>

    <!-- DAILY REPORT -->
    <div class="bg-white shadow rounded p-4 mb-6">
        <h2 class="text-xl font-bold mb-2">Daily Sales ({{ $date }})</h2>

        <p>Total Money: <strong>KES {{ number_format($dailyMoney,2) }}</strong></p>
        <p>Total Stock Sold: <strong>{{ $dailyStock }}</strong></p>

        <!-- PRODUCT SUMMARY -->
        <h3 class="mt-4 font-semibold">Product Summary</h3>
        <table class="w-full border mt-2 text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-2 py-1">Product</th>
                    <th class="border px-2 py-1">Qty Sold</th>
                    <th class="border px-2 py-1">Total Money</th>
                </tr>
            </thead>
            <tbody>
                @foreach($dailyProductSummary as $p)
                <tr>
                    <td class="border px-2 py-1">{{ $p->product_name }}</td>
                    <td class="border px-2 py-1">{{ $p->qty }}</td>
                    <td class="border px-2 py-1">{{ number_format($p->money,2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- CHART -->
        <canvas id="dailyChart" class="mt-4"></canvas>
    </div>

    <!-- MONTHLY REPORT -->
    <div class="bg-white shadow rounded p-4">
        <h2 class="text-xl font-bold mb-2">Monthly Sales ({{ $month }})</h2>

        <p>Total Money: <strong>KES {{ number_format($monthlyMoney,2) }}</strong></p>
        <p>Total Stock Sold: <strong>{{ $monthlyStock }}</strong></p>

        <!-- PRODUCT SUMMARY -->
        <h3 class="mt-4 font-semibold">Product Summary</h3>
        <table class="w-full border mt-2 text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-2 py-1">Product</th>
                    <th class="border px-2 py-1">Qty Sold</th>
                    <th class="border px-2 py-1">Total Money</th>
                </tr>
            </thead>
            <tbody>
                @foreach($monthlyProductSummary as $p)
                <tr>
                    <td class="border px-2 py-1">{{ $p->product_name }}</td>
                    <td class="border px-2 py-1">{{ $p->qty }}</td>
                    <td class="border px-2 py-1">{{ number_format($p->money,2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- CHART -->
        <canvas id="monthlyChart" class="mt-4"></canvas>
    </div>

</div>

<!-- CHART JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    new Chart(document.getElementById('dailyChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($dailyProductSummary->pluck('product_name')) !!},
            datasets: [{
                label: 'Qty Sold',
                data: {!! json_encode($dailyProductSummary->pluck('qty')) !!},
            }]
        }
    });

    new Chart(document.getElementById('monthlyChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($monthlyProductSummary->pluck('product_name')) !!},
            datasets: [{
                label: 'Qty Sold',
                data: {!! json_encode($monthlyProductSummary->pluck('qty')) !!},
            }]
        }
    });
</script>

@endsection
