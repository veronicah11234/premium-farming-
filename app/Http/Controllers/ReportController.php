<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\StockMovement;
use App\Models\Product;

class ReportController extends Controller
{
    public function bestSeller(Request $r) {
        $from = $r->input('from', now()->subMonth()->toDateString());
        $to = $r->input('to', now()->toDateString());

        $best = \DB::table('sale_items')
            ->select('product_id', \DB::raw('SUM(quantity) as qty_sold'))
            ->whereBetween('created_at', [$from, $to])
            ->groupBy('product_id')
            ->orderByDesc('qty_sold')
            ->limit(50)
            ->get();

        $products = Product::whereIn('id', $best->pluck('product_id'))->get();
        return view('pos.reports.best-seller', compact('best','products','from','to'))->with('mode','pos');
    }

    public function goodsReceivedReport(Request $r) {
        // similar: filter stock_movements.type = goods_received
    }

    public function stockLevel() {
        // compute current stock by summing stock_movements per store/product
    }
}
