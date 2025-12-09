<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\SaleItem;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class SaleController extends Controller
{
    /**
     * SAVE SALE AND REDIRECT TO RECEIPT
     */
    public function store(Request $request)
    {
        // Create sale
        $sale = Sale::create([
            'total' => $request->total,
        ]);

        // Save items
        foreach ($request->items as $item) {
            SaleItem::create([
                'sale_id' => $sale->id,
                'product_name' => $item['product_name'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'subtotal' => $item['subtotal'],
            ]);
        }

        return redirect()->route('sales.receipt', $sale->id);
    }


    /**
     * DAILY + MONTHLY REPORT
     */
    public function index(Request $request)
    {
        $date = $request->input('date', now()->toDateString());
        $month = $request->input('month', now()->format('Y-m'));

        // DAILY
        $dailySales = Sale::whereDate('created_at', $date)->get();
        $dailyMoney = $dailySales->sum('total');

        $dailyStock = SaleItem::whereHas('sale', fn($q) =>
            $q->whereDate('created_at', $date)
        )->sum('quantity');

        // PRODUCT-WISE DAILY
        $dailyProductSummary = SaleItem::selectRaw(
            'product_name, SUM(quantity) as qty, SUM(subtotal) as money'
        )
        ->whereHas('sale', fn($q) =>
            $q->whereDate('created_at', $date)
        )
        ->groupBy('product_name')
        ->get();

        return view('reports.sales', compact(
            'dailySales', 'dailyMoney', 'dailyStock',
            'dailyProductSummary'
        ));
    }


    /**
     * DOWNLOAD PDF REPORT
     */
    public function pdf(Request $request)
    {
        $date = $request->date;
        $month = $request->month;

        $dailySales = Sale::whereDate('created_at', $date)->get();
        $monthlySales = Sale::where('created_at', 'LIKE', $month.'%')->get();

        $pdf = Pdf::loadView('reports.sales_pdf', compact(
            'date','month','dailySales','monthlySales'
        ));

        return $pdf->download('sales-report.pdf');
    }


    /**
     * RECEIPT PAGE
     */
    public function receipt($id)
    {
        $sale = Sale::with('items')->findOrFail($id);
        return view('sales.receipt', compact('sale'));
    }
}
