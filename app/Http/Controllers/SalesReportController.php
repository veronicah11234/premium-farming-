<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\SaleItem;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class SalesReportController extends Controller
{
    // Show sales report
    public function index(Request $request)
    {
        $date = $request->input('date', now()->toDateString());
        $month = $request->input('month', now()->format('Y-m'));

        // ===== DAILY =====
        $dailySales = Sale::whereDate('date', $date)->get();
        $dailyMoney = $dailySales->sum('total');
        $dailyStock = SaleItem::whereHas('sale', fn($q) => $q->whereDate('date', $date))
            ->sum('quantity');

        // PRODUCT-WISE DAILY
        $dailyProductSummary = SaleItem::selectRaw(
            'product_name, SUM(quantity) as qty, SUM(subtotal) as money'
        )
        ->whereHas('sale', fn($q) => $q->whereDate('date', $date))
        ->groupBy('product_name')
        ->get();

        // ===== MONTHLY =====
        $monthlySales = Sale::where('date', 'LIKE', $month . '%')->get();
        $monthlyMoney = $monthlySales->sum('total');
        $monthlyStock = SaleItem::whereHas('sale', fn($q) => $q->where('date','LIKE',$month.'%'))
            ->sum('quantity');

        // PRODUCT-WISE MONTHLY
        $monthlyProductSummary = SaleItem::selectRaw(
            'product_name, SUM(quantity) as qty, SUM(subtotal) as money'
        )
        ->whereHas('sale', fn($q) => $q->where('date', 'LIKE', $month.'%'))
        ->groupBy('product_name')
        ->get();

        return view('reports.sales', compact(
            'date','month',
            'dailySales','dailyMoney','dailyStock','dailyProductSummary',
            'monthlySales','monthlyMoney','monthlyStock','monthlyProductSummary'
        ));
    }

    // Generate PDF of sales report
    public function pdf(Request $request)
    {
        $date = $request->input('date', now()->toDateString());
        $month = $request->input('month', now()->format('Y-m'));

        $dailySales = Sale::whereDate('date', $date)->get();
        $monthlySales = Sale::where('date', 'LIKE', $month . '%')->get();

        $pdf = Pdf::loadView('reports.sales_pdf', compact(
            'date','month','dailySales','monthlySales'
        ));

        return $pdf->download('sales-report.pdf');
    }
}
