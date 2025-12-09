<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;


use App\Models\Sale;
use App\Models\SaleItem;
use Carbon\Carbon;

class SalesReportController extends Controller
{
    public function index(Request $request)
{
    // Get selected date & month from user OR default to current
    $date = $request->input('date', now()->toDateString());
    $month = $request->input('month', now()->format('Y-m'));

    // ============================
    //  DAILY SALES
    // ============================
    $dailySales = Sale::whereDate('created_at', $date)->get();
    $dailyMoney = $dailySales->sum('total');

    $dailyStock = SaleItem::whereHas('sale', fn($q) =>
        $q->whereDate('created_at', $date)
    )->sum('quantity');

    // PRODUCT-WISE DAILY
    $dailyProductSummary = SaleItem::selectRaw("
        product_name,
        SUM(quantity) as qty,
        SUM(quantity * price) as money
    ")
    ->whereHas('sale', fn($q) =>
        $q->whereDate('created_at', $date)
    )
    ->groupBy('product_name')
    ->get();

    // ============================
    //  MONTHLY SALES
    // ============================
    $monthlySales = Sale::where('created_at', 'LIKE', $month.'%')->get();
    $monthlyMoney = $monthlySales->sum('total');

    $monthlyStock = SaleItem::whereHas('sale', fn($q) =>
        $q->where('created_at', 'LIKE', $month.'%')
    )->sum('quantity');

    // PRODUCT-WISE MONTHLY
    $monthlyProductSummary = SaleItem::selectRaw("
        product_name,
        SUM(quantity) as qty,
        SUM(quantity * price) as money
    ")
    ->whereHas('sale', fn($q) =>
        $q->where('created_at', 'LIKE', $month.'%')
    )
    ->groupBy('product_name')
    ->get();

    return view('reports.sales', compact(
        'date',                // ← FIX ADDED
        'month',               // ← FIX ADDED
        'dailySales',
        'dailyMoney',
        'dailyStock',
        'dailyProductSummary',
        'monthlySales',
        'monthlyMoney',
        'monthlyStock',
        'monthlyProductSummary'
    ));
}


    // Generate PDF of sales report
    public function pdf(Request $request)
    {
        $date = $request->input('date', now()->toDateString());
        $month = $request->input('month', now()->format('Y-m'));

        $dailySales = Sale::whereDate('created_at', $date)->get();
        $monthlySales = Sale::where('created_at', 'LIKE', $month.'%')->get();

        $pdf = Pdf::loadView('reports.sales_pdf', compact(
            'date','month','dailySales','monthlySales'
        ));

        return $pdf->download('sales-report.pdf');
    }
}
